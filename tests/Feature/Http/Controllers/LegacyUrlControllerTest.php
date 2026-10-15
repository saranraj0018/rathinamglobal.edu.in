<?php

namespace Tests\Feature\Http\Controllers;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class LegacyUrlControllerTest extends TestCase
{
    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function legacyPageUrls(): array
    {
        return [
            'php page' => ['/research/patents.php', '/research/patents'],
            'html page' => ['/law/index.html', '/law'],
            'index.php in a folder' => ['/research/index.php', '/research'],
            'global affairs' => ['/global-affairs.php', '/global-affairs'],
            'careers' => ['/careers.php', '/careers'],
            'dbt star scheme' => ['/dbt-star-scheme.php', '/dbt-star-scheme'],
            'event page' => ['/events/aicte-vaani-cybersecurity-2026.php', '/events/aicte-vaani-cybersecurity-2026'],
            'events index' => ['/events/index.php', '/events'],
            'dotted programme slug' => ['/courses/programmes/school-of-quantum-science/b.sc-computer-science.php', '/courses/programmes/school-of-quantum-science/b.sc-computer-science'],
        ];
    }

    #[DataProvider('legacyPageUrls')]
    public function test_old_php_and_html_urls_redirect_permanently_to_the_clean_url(string $legacy, string $clean): void
    {
        $this->get($legacy)->assertStatus(301)->assertRedirect(url($clean));
    }

    public function test_redirect_keeps_the_query_string(): void
    {
        $this->get('/courses/school-of-quantum-science.php?utm_source=x')
            ->assertStatus(301)
            ->assertRedirect(url('/courses/school-of-quantum-science').'?utm_source=x');
    }

    public function test_old_asset_paths_redirect_to_public_storage(): void
    {
        $this->get('/assets/brouchure.pdf')
            ->assertStatus(301)
            ->assertRedirect(storage_asset('assets/brouchure.pdf'));
    }

    public function test_page_aliases_redirect_to_the_canonical_page(): void
    {
        $this->get('/research/startup')->assertStatus(301)->assertRedirect('/research/startups');
        $this->get('/research/books-book-chapters')->assertStatus(301)->assertRedirect('/research/book-chapters');
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function removedUrls(): array
    {
        return [
            'web shell' => ['/acbus/submit/.cache.php'],
            'cloaked spam page (events)' => ['/events/home.php'],
            'cloaked spam page (research)' => ['/research/leads.php'],
            'private brochure' => ['/esg/private/ESG%20brouchure.pdf'],
            'path traversal' => ['/assets/..%2F..%2F.env'],
            'unknown page' => ['/no-such-page.php'],
        ];
    }

    #[DataProvider('removedUrls')]
    public function test_removed_and_unknown_urls_return_404(string $uri): void
    {
        $this->get($uri)->assertNotFound();
    }
}
