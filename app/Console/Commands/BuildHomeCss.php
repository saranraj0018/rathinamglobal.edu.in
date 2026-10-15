<?php

namespace App\Console\Commands;

use App\Support\CriticalCss;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Regenerates the homepage CSS build artifacts on the public disk:
 *
 *   assets/css/home.bundle.css  tailwind.css + style.css + extracted.css, in
 *                               that cascade order, minified (loaded async)
 *   assets/css/critical.css     the above-the-fold subset, inlined into the
 *                               homepage <head> by App\Support\CriticalCss so
 *                               the hero paints without layout shift
 *
 * Run it after editing tailwind.css, style.css or extracted.css.
 */
#[Signature('rgu:build-css')]
#[Description('Rebuild the homepage CSS bundle and its inlined critical CSS')]
class BuildHomeCss extends Command
{
    private const SOURCES = ['assets/css/tailwind.css', 'assets/css/style.css', 'assets/css/extracted.css'];

    private const BUNDLE = 'assets/css/home.bundle.css';

    /** Views that make up the area above the fold. */
    private const ABOVE_THE_FOLD_VIEWS = ['partials.nav', 'home.partials.banner', 'home.partials.marquee'];

    /** Classes Swiper adds to the banner slider at runtime. */
    private const RUNTIME_CLASSES = [
        'swiper', 'swiper-wrapper', 'swiper-slide', 'swiper-slide-active', 'swiper-slide-next',
        'swiper-slide-prev', 'swiper-initialized', 'swiper-horizontal', 'swiper-backface-hidden',
        'swiper-notification', 'swiper-pagination', 'swiper-pagination-bullet',
        'swiper-pagination-bullet-active', 'swiper-button-next', 'swiper-button-prev',
        'admissionSlider', 'sr-only', 'container',
    ];

    public function handle(): int
    {
        $disk = Storage::disk('public');

        foreach (self::SOURCES as $source) {
            if (! $disk->exists($source)) {
                $this->error("Missing source stylesheet: {$source}");

                return self::FAILURE;
            }
        }

        $bundle = '';
        foreach (self::SOURCES as $source) {
            $bundle .= "\n/* ===== ".basename($source)." ===== */\n".$disk->get($source);
        }
        $bundle = $this->minify($bundle);
        $disk->put(self::BUNDLE, $bundle);
        $this->components->info(sprintf('%s: %.1f KB', self::BUNDLE, strlen($bundle) / 1024));

        $classes = $this->aboveTheFoldClasses();
        $critical = $this->minify($this->criticalRules($disk, $classes));

        // The sources live in assets/css/ and use url("../images/x"). Inlined
        // into the page those must be document-relative; CriticalCss rewrites
        // "./assets/" to the storage URL when it inlines the file.
        $critical = preg_replace('#url\((["\']?)\.\./images/#i', 'url($1./assets/images/', $critical);

        $disk->put(CriticalCss::PATH, $critical);
        $this->components->info(sprintf('%s: %.1f KB from %d above-the-fold classes', CriticalCss::PATH, strlen($critical) / 1024, count($classes)));

        return self::SUCCESS;
    }

    /**
     * @return array<string, true>
     */
    private function aboveTheFoldClasses(): array
    {
        $classes = array_fill_keys(self::RUNTIME_CLASSES, true);

        foreach (self::ABOVE_THE_FOLD_VIEWS as $view) {
            try {
                $html = view($view, ['navMode' => 'transparent'])->render();
            } catch (Throwable $e) {
                $this->warn("Could not render {$view}: {$e->getMessage()}");

                continue;
            }

            preg_match_all('/\sclass\s*=\s*"([^"]*)"/i', $html, $matches);

            foreach ($matches[1] as $attribute) {
                foreach (preg_split('/\s+/', trim($attribute)) as $class) {
                    if ($class !== '') {
                        $classes[$class] = true;
                    }
                }
            }
        }

        return $classes;
    }

    /**
     * A rule is kept when it has no class selector at all (resets, element
     * selectors, :root, @font-face, @keyframes) or when any class in its
     * selector is above the fold. Sheets are walked in cascade order.
     *
     * @param  array<string, true>  $classes
     */
    private function criticalRules(Filesystem $disk, array $classes): string
    {
        $critical = '';

        foreach (self::SOURCES as $source) {
            foreach ($this->splitBlocks($disk->get($source)) as $block) {
                $trimmed = ltrim($block);

                if ($trimmed === '') {
                    continue;
                }

                if ($trimmed[0] === '@') {
                    if (preg_match('/^@(media|supports)\b/i', $trimmed)) {
                        $open = strpos($block, '{');
                        $inner = substr($block, $open + 1, strrpos($block, '}') - $open - 1);
                        $kept = '';

                        foreach ($this->splitBlocks($inner) as $innerBlock) {
                            $innerOpen = strpos($innerBlock, '{');

                            if ($innerOpen !== false && $this->isCritical(trim(substr($innerBlock, 0, $innerOpen)), $classes)) {
                                $kept .= $innerBlock;
                            }
                        }

                        if (trim($kept) !== '') {
                            $critical .= substr($block, 0, $open + 1).$kept.'}';
                        }
                    } else {
                        $critical .= $block;   // @font-face / @keyframes / @charset
                    }

                    continue;
                }

                $open = strpos($block, '{');

                if ($open !== false && $this->isCritical(trim(substr($block, 0, $open)), $classes)) {
                    $critical .= $block;
                }
            }
        }

        return $critical;
    }

    /**
     * @param  array<string, true>  $classes
     */
    private function isCritical(string $selector, array $classes): bool
    {
        foreach (explode(',', $selector) as $single) {
            $single = trim($single);

            if ($single === '') {
                continue;
            }

            if (! preg_match_all('/\.((?:\\\\[0-9a-fA-F]{1,6}[ ]?|\\\\.|[A-Za-z0-9_-])+)/s', $single, $matches)) {
                return true;
            }

            foreach ($matches[1] as $raw) {
                if (isset($classes[$this->unescape($raw)])) {
                    return true;
                }
            }
        }

        return false;
    }

    private function unescape(string $class): string
    {
        return preg_replace_callback('/\\\\([0-9a-fA-F]{1,6})[ ]?|\\\\(.)/s', function (array $m): string {
            if (isset($m[1]) && $m[1] !== '') {
                $codepoint = hexdec($m[1]);

                return $codepoint > 0 ? mb_chr($codepoint, 'UTF-8') : '';
            }

            return $m[2] ?? '';
        }, $class);
    }

    /**
     * @return array<int, string>
     */
    private function splitBlocks(string $css): array
    {
        $blocks = [];
        $depth = 0;
        $buffer = '';

        for ($i = 0, $length = strlen($css); $i < $length; $i++) {
            $char = $css[$i];
            $buffer .= $char;

            if ($char === '{') {
                $depth++;
            } elseif ($char === '}') {
                $depth--;

                if ($depth === 0) {
                    $blocks[] = $buffer;
                    $buffer = '';
                }
            }
        }

        return $blocks;
    }

    private function minify(string $css): string
    {
        $css = preg_replace('#/\*.*?\*/#s', '', $css);
        $css = preg_replace('/\s*([{}:;,>])\s*/', '$1', $css);
        $css = preg_replace('/\s+/', ' ', $css);
        $css = str_replace(';}', '}', trim($css));

        // Tailwind's empty custom properties ("--tw-pan-x: ;") need the space,
        // otherwise the declaration is invalid and dropped.
        $css = preg_replace('/(--[A-Za-z0-9-]+):\s*;/', '$1: ;', $css);

        return preg_replace('/(--[A-Za-z0-9-]+):\s*\}/', '$1: }', $css);
    }
}
