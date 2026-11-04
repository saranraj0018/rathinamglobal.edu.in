<?php

namespace App\Services\Assistant;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * THIS IS NEW CODE — retrieves relevant content from the configured canonical
 * Rathinam website without mixing it into the admin-managed index.
 */
class OfficialWebsiteSearchService
{
    private const PAGE_LIMIT = 120;

    private const RESULT_LIMIT = 3;

    public function __construct(private TextNormalizer $normalizer) {}

    /**
     * @return list<RetrievedChunk>
     */
    // THIS IS NEW CODE — add request correlation to official-site fetch diagnostics without logging the question.
    public function search(string $question, ?string $requestId = null): array
    {
        if (! config('assistant.official_website.enabled', true)) {
            return [];
        }

        // THIS IS NEW CODE — reuse query-matched official facts across calls. Reason: avoid repeating synchronous sitemap and page retrieval for common questions.
        $cacheKey = 'assistant.official-site-query.'.hash('sha256', mb_strtolower(trim($question)));
        try {
            $cachedResults = Cache::get($cacheKey);
            if (is_array($cachedResults)) {
                $restored = $this->restoreCachedChunks($cachedResults);
                if ($restored !== []) {
                    return $restored;
                }
            }
        } catch (\Throwable) {
            // THIS IS NEW CODE — fall back to the existing same-host retrieval when cache reads fail. Reason: cache failures must not become site facts or hide a valid website response.
        }

        $results = $this->searchUncached($question, $requestId);
        if ($results !== []) {
            try {
                // THIS IS NEW CODE — cache scalar chunk records instead of PHP objects. Reason: cache stores with restricted unserialization return incomplete classes and break native retrieval.
                Cache::put($cacheKey, array_map(fn (RetrievedChunk $chunk): array => [
                    'chunk_id' => $chunk->chunkId,
                    'source_type' => $chunk->sourceType,
                    'source_id' => $chunk->sourceId,
                    'title' => $chunk->title,
                    'content' => $chunk->content,
                    'score' => $chunk->score,
                ], $results), now()->addHours(6));
            } catch (\Throwable) {
                // THIS IS NEW CODE — keep cache writes optional. Reason: cache persistence errors must not discard verified retrieved facts.
            }
        }

        return $results;
    }

    /** THIS IS NEW CODE — allow native Live retrieval to use already cached official facts without network access. Reason: prevent synchronous website crawling on a first-party voice tool turn. */
    public function searchCached(string $question): array
    {
        if (! config('assistant.official_website.enabled', true)) {
            return [];
        }

        try {
            $cached = Cache::get('assistant.official-site-query.'.hash('sha256', mb_strtolower(trim($question))));

            return is_array($cached) ? $this->restoreCachedChunks($cached) : [];
        } catch (\Throwable) {
            return [];
        }
    }

    /** THIS IS NEW CODE — isolate the existing official-site search behind a six-hour result cache. Reason: keep site parsing out of most repeated Live turns. */
    private function searchUncached(string $question, ?string $requestId): array
    {

        $baseUrl = rtrim((string) config('rgu.canonical_url'), '/');
        $baseHost = strtolower((string) parse_url($baseUrl, PHP_URL_HOST));
        if ($baseHost === '' || parse_url($baseUrl, PHP_URL_SCHEME) !== 'https') {
            return [];
        }

        $units = $this->normalizer->units($question);
        $terms = array_values(array_unique(array_merge(...array_column($units, 'stems'))));
        if ($terms === []) {
            return [];
        }

        $sitemapUrl = $baseUrl.'/sitemap.xml';
        if (! $this->isAllowedUrl($sitemapUrl, $baseHost)) {
            return [];
        }

        $response = $this->getAllowedResponse($sitemapUrl, $baseHost, 'application/xml,text/xml,text/html', $requestId);
        if (! $response->successful()) {
            return [];
        }

        preg_match_all('/<loc>\s*(.*?)\s*<\/loc>/is', $response->body(), $matches);
        $locations = $matches[1] ?? [];
        // THIS IS NEW CODE — sitemap indexes are followed only on the configured Rathinam host.
        foreach (array_slice($locations, 0, 5) as $location) {
            $nestedUrl = html_entity_decode(trim(strip_tags($location)), ENT_QUOTES | ENT_XML1, 'UTF-8');
            if (! $this->isAllowedUrl($nestedUrl, $baseHost) || ! str_contains(mb_strtolower((string) parse_url($nestedUrl, PHP_URL_PATH)), 'sitemap')) {
                continue;
            }
            $nested = $this->getAllowedResponse($nestedUrl, $baseHost, 'application/xml,text/xml', $requestId);
            if ($nested->successful()) {
                preg_match_all('/<loc>\s*(.*?)\s*<\/loc>/is', $nested->body(), $nestedMatches);
                $locations = [...$locations, ...($nestedMatches[1] ?? [])];
            }
        }
        $candidates = [];
        foreach (array_slice($locations, 0, self::PAGE_LIMIT) as $location) {
            $url = html_entity_decode(trim(strip_tags($location)), ENT_QUOTES | ENT_XML1, 'UTF-8');
            if (! $this->isAllowedUrl($url, $baseHost)) {
                continue;
            }

            $path = mb_strtolower(rawurldecode((string) parse_url($url, PHP_URL_PATH)));
            $score = 0;
            foreach ($units as $unit) {
                foreach ($unit['stems'] as $term) {
                    if ($term !== '' && str_contains($path, $term)) {
                        $score += $unit['concept'] ? 0.5 : 3;
                    }
                }
            }
            if ($score > 0) {
                $candidates[] = ['url' => $url, 'score' => $score];
            }
        }
        // THIS IS NEW CODE — course abbreviations appear in page text, not the Rathinam sitemap URL slugs.
        $questionWords = $this->normalizer->words($question);
        $coursePages = [
            'bca' => '/courses/school-of-quantum-science',
            'bba' => '/courses/school-of-business-and-commerce',
            'mba' => '/courses/school-of-business-and-commerce',
        ];
        foreach ($coursePages as $course => $path) {
            if (in_array($course, $questionWords, true)) {
                $matchingUrl = $baseUrl.$path;
                foreach (array_slice($locations, 0, self::PAGE_LIMIT) as $location) {
                    $url = html_entity_decode(trim(strip_tags($location)), ENT_QUOTES | ENT_XML1, 'UTF-8');
                    if ($this->isAllowedUrl($url, $baseHost) && parse_url($url, PHP_URL_PATH) === $path) {
                        $matchingUrl = $url;
                        break;
                    }
                }
                $candidates[] = ['url' => $matchingUrl, 'score' => 10];
            }
        }
        // THIS IS NEW CODE — course codes such as BCA are often listed on the catalogue, not in a page URL.
        if (! in_array($baseUrl.'/', array_column($candidates, 'url'), true)) {
            $candidates[] = ['url' => $baseUrl.'/', 'score' => 1];
        }
        usort($candidates, fn (array $a, array $b): int => $b['score'] <=> $a['score']);

        $results = [];
        // THIS IS NEW CODE — deduplicate facts shared by multiple pages before building the answer context. Reason: repeated website copy made speech sound repetitive.
        $seenSentences = [];
        foreach (array_slice($candidates, 0, self::RESULT_LIMIT) as $candidate) {
            try {
                $page = $this->getAllowedResponse($candidate['url'], $baseHost, 'text/html', $requestId);
            } catch (\Throwable) {
                continue;
            }
            if (! $page->successful()) {
                continue;
            }

            $content = $this->pageText($page->body());
            $matchesInContent = array_filter($terms, fn (string $term): bool => $term !== '' && str_contains(mb_strtolower($content), mb_strtolower($term)));
            if ($content !== '' && $matchesInContent !== []) {
                $snippet = $this->relevantSnippet($content, array_values($matchesInContent), $seenSentences);
                if ($snippet !== '') {
                    // THIS IS NEW CODE — use a neutral source label instead of passing SEO page titles into spoken-answer context. Reason: titles can contain promotional claims and navigation-like text.
                    $results[] = new RetrievedChunk(0, 'official_website', 0, 'Official Rathinam information', $snippet, (float) (count($matchesInContent) + $candidate['score']));
                }
            }
        }

        return $results;
    }

    private function isAllowedUrl(string $url, string $baseHost): bool
    {
        return parse_url($url, PHP_URL_SCHEME) === 'https'
            && strtolower((string) parse_url($url, PHP_URL_HOST)) === $baseHost
            && parse_url($url, PHP_URL_USER) === null
            && parse_url($url, PHP_URL_PASS) === null;
    }

    /** THIS IS NEW CODE — follow a small number of redirects, rejecting every off-domain hop. */
    // THIS IS NEW CODE — record status and duration for each official-domain HTTP request; never record response bodies.
    private function getAllowedResponse(string $url, string $baseHost, string $accept, ?string $requestId = null): Response
    {
        for ($redirect = 0; $redirect <= 3; $redirect++) {
            if (! $this->isAllowedUrl($url, $baseHost)) {
                return Http::response('', 403);
            }

            // THIS IS NEW CODE — cache approved same-host page responses to avoid repeated website crawling. Reason: Live tool lookups should prefer local cache on repeated requests.
            $cacheKey = 'assistant.official-site-page.'.hash('sha256', $url);
            try {
                $cachedPage = Cache::get($cacheKey);
                if (is_array($cachedPage) && isset($cachedPage['status'], $cachedPage['body'])) {
                    $headers = is_string($cachedPage['location'] ?? null) && $cachedPage['location'] !== ''
                        ? ['Location' => $cachedPage['location']]
                        : [];

                    return Http::response((string) $cachedPage['body'], (int) $cachedPage['status'], $headers);
                }
            } catch (\Throwable) {
                // THIS IS NEW CODE — allow the current validated fetch when cache storage is unavailable. Reason: retain secure retrieval fallback behavior.
            }

            $fetchStartedAt = hrtime(true);
            $response = Http::withOptions(['allow_redirects' => false])->accept($accept)
                ->connectTimeout(3)->timeout(7)->get($url);
            Log::info('[assistant.lifecycle] official_site_http_response', ['request_id' => $requestId, 'stage_elapsed_ms' => (int) ((hrtime(true) - $fetchStartedAt) / 1_000_000), 'http_status' => $response->status(), 'path' => (string) parse_url($url, PHP_URL_PATH)]);

            if ($response->successful() || in_array($response->status(), [301, 302, 303, 307, 308], true)) {
                try {
                    Cache::put($cacheKey, [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'location' => (string) $response->header('Location', ''),
                    ], now()->addHours(6));
                } catch (\Throwable) {
                    // THIS IS NEW CODE — allow the current validated response when page caching fails. Reason: cache writes must not block an answer.
                }
            }

            if (! in_array($response->status(), [301, 302, 303, 307, 308], true)) {
                return $response;
            }

            $location = $response->header('Location');
            if (! is_string($location) || $location === '') {
                return $response;
            }
            if (str_starts_with($location, '/')) {
                $url = 'https://'.$baseHost.$location;
            } elseif (! str_starts_with($location, 'https://')) {
                $url = rtrim('https://'.$baseHost.'/'.dirname((string) parse_url($url, PHP_URL_PATH)), '/').'/'.$location;
            } else {
                $url = $location;
            }
        }

        return Http::response('', 508);
    }

    /** THIS IS NEW CODE — retain readable content blocks while excluding page chrome and SEO metadata. Reason: raw website shell text was being passed to Gemini as facts. */
    private function pageText(string $html): string
    {
        $document = new \DOMDocument;
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_NONET | LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new \DOMXPath($document);
        // THIS IS NEW CODE — remove headings and common page chrome before collecting prose. Reason: headings are useful for crawling but should not become spoken answer text.
        foreach ($xpath->query('//head | //title | //script | //style | //noscript | //template | //nav | //header | //footer | //aside | //form | //button | //h1 | //h2 | //h3 | //h4 | //h5 | //h6 | //*[@role="navigation"] | //*[@aria-hidden="true"] | //*[@class and contains(translate(@class, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"), "breadcrumb")]') ?: [] as $node) {
            $node->parentNode?->removeChild($node);
        }

        $main = $xpath->query('//main | //article | //*[@role="main"]')?->item(0);
        $root = $main ?: $document->getElementsByTagName('body')->item(0);
        if (! $root) {
            return '';
        }

        // OLD CODE — NOT USED NOW: DOM textContent merged adjacent paragraphs, joining facts to SEO copy and causing both to be dropped or read together.
        // $text = html_entity_decode((string) $root->textContent, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        // THIS IS NEW CODE — preserve spaces between DOM text nodes. Reason: separate factual paragraphs from adjacent headings and boilerplate before sentence-level filtering.
        $textNodes = $xpath->query('.//text()', $root);
        $segments = [];
        foreach ($textNodes ?: [] as $textNode) {
            $segments[] = (string) $textNode->textContent;
        }
        $text = html_entity_decode(implode(' ', $segments), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/[\p{Z}\s]+/u', ' ', $text) ?? '';

        return trim($text);
    }

    /** THIS IS NEW CODE — rebuild typed chunks only from bounded scalar cache entries. Reason: never trust cache serialization or expose malformed cache values as retrieval evidence. */
    /**
     * @param  list<array<string, mixed>>  $items
     * @return list<RetrievedChunk>
     */
    private function restoreCachedChunks(array $items): array
    {
        $chunks = [];
        foreach (array_slice($items, 0, self::RESULT_LIMIT) as $item) {
            if (! is_array($item)
                || ! is_numeric($item['chunk_id'] ?? null)
                || ! is_string($item['source_type'] ?? null)
                || ! is_numeric($item['source_id'] ?? null)
                || ! is_string($item['title'] ?? null)
                || ! is_string($item['content'] ?? null)
                || ! is_numeric($item['score'] ?? null)) {
                continue;
            }

            $chunks[] = new RetrievedChunk(
                (int) $item['chunk_id'],
                mb_substr($item['source_type'], 0, 40),
                (int) $item['source_id'],
                mb_substr($item['title'], 0, 180),
                mb_substr($item['content'], 0, 720),
                (float) $item['score'],
            );
        }

        return $chunks;
    }

    /**
     * @param  list<string>  $terms
     */
    /** THIS IS NEW CODE — select a few query-matched factual sentences instead of an arbitrary page prefix. Reason: prevent unrelated and duplicated website copy from becoming answer context. */
    private function relevantSnippet(string $content, array $terms, array &$seenSentences): string
    {
        $sentences = preg_split('/(?<=[.!?。！？])\s+/u', $content) ?: [];
        $selected = [];
        foreach ($sentences as $sentence) {
            $sentence = trim($sentence);
            $lower = mb_strtolower($sentence);
            $wordCount = preg_match_all('/[\p{L}\p{N}]+/u', $sentence);
            $isBoilerplate = preg_match('/\b(skip to main content|home|about us?|committees?|statutory committees?|privacy policy|terms (?:and|&) conditions|all rights reserved|best university in|the potter from college)\b/iu', $sentence) === 1;
            $hasQueryMatch = array_filter($terms, fn (string $term): bool => $term !== '' && str_contains($lower, mb_strtolower($term))) !== [];
            $dedupeKey = mb_strtolower(preg_replace('/\s+/u', ' ', $sentence) ?? $sentence);
            if (! $isBoilerplate && $hasQueryMatch && $wordCount >= 5 && mb_strlen($sentence) <= 360 && ! in_array($dedupeKey, $seenSentences, true)) {
                $selected[] = $sentence;
                $seenSentences[] = $dedupeKey;
            }
            if (count($selected) >= 4) {
                break;
            }
        }

        return mb_substr(implode(' ', $selected), 0, 720);
    }
}
