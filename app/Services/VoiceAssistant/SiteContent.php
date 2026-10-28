<?php

namespace App\Services\VoiceAssistant;

use App\Support\ContentRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Turns every public content file in resources/data into knowledge-base
 * entries, one per page section, so the assistant can answer from the whole
 * website: programmes (fees, eligibility, curriculum, careers), schools,
 * research, events, the RGU Way, global affairs, conferences, bus routes, ...
 *
 * Files are read generically: human-readable text is kept, while images,
 * links, icons and styling values are skipped. A new data file is picked up
 * automatically; add it to PAGE_ROUTES only when its page URL cannot be
 * derived from its name.
 *
 * @phpstan-import-type Entry from KnowledgeBase
 */
class SiteContent
{
    /**
     * Files that are not public page content or are indexed elsewhere.
     */
    private const EXCLUDED_FILES = ['voice-assistant', 'faqs', 'reports'];

    /**
     * Content file => named route of the page that shows it (when not derivable from the name).
     */
    private const PAGE_ROUTES = [
        'home' => 'home',
        'events' => 'events.index',
        'bus-routes' => 'bus-registration.create',
        'research/overview' => 'research.index',
    ];

    /**
     * Content file => page name, when the file name alone does not read well.
     */
    private const PAGE_TITLES = [
        'home' => 'Home page',
        'rgu-way' => 'The RGU Way',
        'dsacb' => 'DSACB 2027 conference',
        'dbt-star-scheme' => 'DBT Star College Scheme',
        'global-affairs' => 'Global Affairs',
        'research/overview' => 'Research overview',
    ];

    /**
     * Keys whose values are never visitor-facing text.
     */
    private const SKIPPED_KEYS = [
        'image', 'images', 'img', 'src', 'icon', 'color', 'colour', 'class', 'slug', 'url', 'href', 'link', 'route',
        'gallery', 'gallery_rows', 'gallery_dimensions', 'tv_videos', 'facilities_carousel', 'image_alts', 'video',
        'poster', 'embed', 'style', 'gradient', 'bg', 'nav', 'filters', 'school_slug', 'program_slug', 'apply_url',
        'brochure_url', 'curriculum_pdf', 'prospectus_pdf', 'downloads', 'course_template', 'short_label', 'ta',
        'no', 'code', 'ltpc', 'eval', 'cat',
    ];

    /**
     * Keys whose value reads naturally without a "Key:" label in front of it.
     */
    private const UNLABELLED_KEYS = [
        'title', 'name', 'heading', 'headline', 'subtitle', 'desc', 'description', 'text', 'note', 'label', 'value',
        'q', 'a', 'body', 'content', 'tagline', 'eyebrow', 'caption', 'summary', 'paragraph', 'paragraphs', 'points',
        'items', 'rows', 'en',
    ];

    private const CHUNK_LENGTH = 900;

    public function __construct(private ContentRepository $content) {}

    /**
     * @return array<int, Entry>
     */
    public function entries(): array
    {
        $entries = [];

        foreach ($this->files() as $name) {
            $data = $this->content->get($name);
            $data = isset($data['en']) && is_array($data['en']) ? $data['en'] : $data;
            $page = $this->pageTitle($name, $data);
            $url = $this->pageUrl($name);
            $route = $this->pageRoute($name)[0];

            foreach ($data as $section => $value) {
                if (in_array((string) $section, self::SKIPPED_KEYS, true)) {
                    continue;
                }

                $heading = $this->sectionHeading($section, $value);
                $parts = $this->chunks($this->text($value));

                foreach ($parts as $number => $text) {
                    $title = $heading === '' ? $page : $page.' — '.$heading;

                    $entries[] = [
                        'id' => 'page-'.str_replace('/', '-', $name).'-'.Str::slug((string) $section).'-'.$number,
                        'category' => 'Website',
                        'title' => $title.(count($parts) > 1 ? ' (part '.($number + 1).')' : ''),
                        'question' => $title,
                        'answer' => $text,
                        'route' => $route,
                        'url' => $url,
                    ];
                }
            }
        }

        return $entries;
    }

    /**
     * Every content file name, e.g. "programmes/school-of-quantum-science/b.sc-computer-science".
     *
     * @return array<int, string>
     */
    private function files(): array
    {
        $root = resource_path('data');
        $names = [];

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));

        foreach ($iterator as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $name = Str::of($file->getPathname())->after($root.DIRECTORY_SEPARATOR)->beforeLast('.php')->replace(DIRECTORY_SEPARATOR, '/')->toString();

            if (! in_array($name, self::EXCLUDED_FILES, true) && $this->content->has($name)) {
                $names[] = $name;
            }
        }

        sort($names);

        return $names;
    }

    /**
     * @param  array<mixed>  $data
     */
    private function pageTitle(string $name, array $data): string
    {
        $schools = $this->content->get('voice-assistant')['schools'];

        return match (true) {
            isset(self::PAGE_TITLES[$name]) => self::PAGE_TITLES[$name],
            str_starts_with($name, 'programmes/') => trim(($data['meta']['department_name'] ?? $data['hero']['title'] ?? Str::headline(basename($name)))
                .(isset($data['meta']['school']) ? ' programme, '.$data['meta']['school'] : ' programme')),
            str_starts_with($name, 'schools/') => $schools[basename($name)] ?? Str::headline(basename($name)),
            str_starts_with($name, 'research/') => 'Research '.Str::headline(basename($name)),
            str_starts_with($name, 'events/') => (string) ($data['title'] ?? $data['hero']['title'] ?? Str::headline(basename($name))).' event',
            default => Str::headline($name),
        };
    }

    private function pageUrl(string $name): string
    {
        [$route, $parameters] = $this->pageRoute($name);

        return Route::has($route) ? route($route, $parameters) : route('home');
    }

    /**
     * @return array{0: string, 1: array<int, string>}
     */
    private function pageRoute(string $name): array
    {
        $segments = explode('/', $name);

        return match (true) {
            isset(self::PAGE_ROUTES[$name]) => [self::PAGE_ROUTES[$name], []],
            $segments[0] === 'programmes' && count($segments) === 3 => ['programmes.show', [$segments[1], $segments[2]]],
            $segments[0] === 'schools' => ['schools.show', [$segments[1]]],
            $segments[0] === 'events' => ['events.show', [$segments[1]]],
            $segments[0] === 'research' => ['research.'.$segments[1], []],
            default => [$name, []],
        };
    }

    private function sectionHeading(int|string $section, mixed $value): string
    {
        if (is_array($value) && is_string($value['title'] ?? null)) {
            return $this->plain($value['title']);
        }

        if (is_array($value) && is_string($value['year'] ?? null)) {
            return $this->plain($value['year']);
        }

        return is_int($section) ? '' : Str::headline($section);
    }

    /**
     * Readable text for a value: lists become "a; b; c", records "Label: value. ...", table rows "a | b | c".
     */
    private function text(mixed $value, ?string $key = null): string
    {
        if (is_bool($value) || $value === null) {
            return '';
        }

        if (is_scalar($value)) {
            $text = $this->plain((string) $value);

            if ($text === '' || $this->isTechnical($text)) {
                return '';
            }

            return $key === null || in_array($key, self::UNLABELLED_KEYS, true) ? $text : Str::headline($key).': '.$text;
        }

        // A table row: a list of plain cells.
        if (array_is_list($value) && $value !== [] && array_reduce($value, fn (bool $carry, mixed $cell): bool => $carry && is_scalar($cell), true) && count($value) > 2) {
            return implode(' | ', array_filter(array_map(fn (mixed $cell): string => $this->text($cell), $value), fn (string $cell): bool => $cell !== '' && $cell !== '-'));
        }

        // A field/value pair, as in eligibility tables.
        if (isset($value['field'], $value['value']) && is_string($value['field'])) {
            $answer = $this->text($value['value']);

            return $answer === '' ? '' : $this->plain($value['field']).': '.$answer;
        }

        $parts = [];

        foreach ($value as $childKey => $child) {
            if (is_string($childKey) && in_array($childKey, self::SKIPPED_KEYS, true)) {
                continue;
            }

            $part = $this->text($child, is_string($childKey) && ! is_array($child) ? $childKey : null);

            if ($part !== '') {
                $parts[] = is_string($childKey) && is_array($child) && ! in_array($childKey, self::UNLABELLED_KEYS, true)
                    ? Str::headline($childKey).': '.$part
                    : $part;
            }
        }

        return implode(array_is_list($value) ? '; ' : '. ', $parts);
    }

    /**
     * Paths, URLs, colours, CSS classes and similar values that are not prose.
     */
    private function isTechnical(string $text): bool
    {
        return preg_match('#^(https?://|/|\#|www\.)#i', $text) === 1
            || preg_match('/\.(webp|jpe?g|png|svg|gif|pdf|mp4|webm)(\?.*)?$/i', $text) === 1
            || (! str_contains($text, ' ') && str_contains($text, '/'));
    }

    /**
     * Splits long section text into pieces small enough to pass to the AI as context.
     *
     * @return array<int, string>
     */
    private function chunks(string $text): array
    {
        $text = trim($text);

        if ($text === '') {
            return [];
        }

        $chunks = [];
        $current = '';

        foreach (preg_split('/(?<=[.;])\s+/u', $text) ?: [$text] as $piece) {
            if ($current !== '' && mb_strlen($current) + mb_strlen($piece) > self::CHUNK_LENGTH) {
                $chunks[] = $current;
                $current = '';
            }

            $current = trim($current.' '.$piece);
        }

        if ($current !== '') {
            $chunks[] = $current;
        }

        return $chunks;
    }

    private function plain(string $html): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }
}
