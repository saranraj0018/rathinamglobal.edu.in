<?php

namespace Tests\Unit\Assistant;

use App\Services\Assistant\OfficialWebsiteSearchService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/** THIS IS NEW CODE — verifies website extraction with mocked local HTTP responses. Reason: prevent scraped navigation/SEO text reaching Gemini without billable generation calls. */
class OfficialWebsiteSearchServiceTest extends TestCase
{
    public function test_retrieval_keeps_only_short_relevant_content_from_the_main_article(): void
    {
        config(['assistant.official_website.enabled' => true, 'rgu.canonical_url' => 'https://rathinamglobal.edu.in']);
        Http::fake([
            'https://rathinamglobal.edu.in/sitemap.xml' => Http::response('<urlset><url><loc>https://rathinamglobal.edu.in/hostel-facilities</loc></url></urlset>'),
            'https://rathinamglobal.edu.in/hostel-facilities' => Http::response(<<<'HTML'
                <html><head><title>Best University in Tamil Nadu | Rathinam Global University</title><meta name="description" content="Hostel information"></head>
                <body><header><nav>Skip to main content Home About Committee Statutory Committees</nav></header>
                <main><h1>Hostel facilities</h1><p>Rathinam Global University provides hostel accommodation for students. The hostels have 24 hour security and free Wi-Fi access.</p><p>Hostel residents can use wash centres and the campus mess.</p></main>
                <footer>Contact | Sitemap | All rights reserved</footer></body></html>
                HTML),
        ]);

        $chunks = app(OfficialWebsiteSearchService::class)->search('Tell me about hostel facilities');

        $this->assertCount(1, $chunks);
        $this->assertSame('Official Rathinam information', $chunks[0]->title);
        $this->assertStringContainsString('24 hour security', $chunks[0]->content);
        $this->assertStringNotContainsString('Best University in Tamil Nadu', $chunks[0]->content);
        $this->assertStringNotContainsString('Skip to main content', $chunks[0]->content);
        $this->assertStringNotContainsString('Statutory Committees', $chunks[0]->content);
        $this->assertStringNotContainsString('All rights reserved', $chunks[0]->content);
        $this->assertLessThanOrEqual(720, mb_strlen($chunks[0]->content));
    }

    /** THIS IS NEW CODE — verify configured models are loaded independently of credential values. Reason: detect stale config or accidental model drift without printing secrets. */
    public function test_cached_application_configuration_uses_the_requested_text_and_live_models(): void
    {
        $this->assertSame('gemini-3.8-live-extended-thinking', config('assistant.gemini_live.model'));
        $this->assertSame('gemini-3.8-flash', config('assistant.gemini.model'));
    }
}
