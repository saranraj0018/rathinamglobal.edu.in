<?php

namespace Tests\Unit\Assistant;

use App\Http\Controllers\Assistant\GeminiLiveTokenController;
use App\Http\Controllers\Assistant\VoiceWidgetController;
use App\Services\Assistant\AssistantService;
use App\Services\Assistant\HostelTransportKnowledgeService;
use App\Services\Assistant\KnowledgeSearchService;
use App\Services\Assistant\OfficialWebsiteSearchService;
use App\Services\Assistant\StaticKnowledgeSearchService;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/** THIS IS NEW CODE — verifies the native Live tool boundary and token setup using local mocks only. Reason: secure session-bound retrieval must work without billable Gemini calls. */
class NativeLiveToolTest extends TestCase
{
    /** Verify native startup returns only a one-use token and the approved session context. */
    public function test_native_token_returns_verified_session_context_without_tool_capability(): void
    {
        config([
            // THIS IS NEW CODE — exercise the retained retrieval-token behavior explicitly. Reason: this test covers rollback mode while diagnostic mode is the temporary app default.
            'assistant.diagnostic_mode' => false,
            'assistant.gemini_live.key' => 'test-live-key',
            'assistant.gemini_live.model' => 'gemini-3.8-live-extended-thinking',
            'assistant.gemini_live.url' => 'https://generativelanguage.googleapis.com/v1beta',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['name' => 'native-token'])]);
        $request = Request::create('/api/gemini-live/native-token', 'POST');

        $response = app(GeminiLiveTokenController::class)->native($request, app(HostelTransportKnowledgeService::class));
        $payload = $response->getData(true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('native-token', $payload['token']);
        $this->assertSame('gemini-3.8-live-extended-thinking', $payload['model']);
        $this->assertStringContainsString('Wi-Fi connectivity is available throughout the hostel premises', $payload['knowledge_context']);
        $this->assertStringContainsString('Pickup timings range between 6:45 AM and 8:05 AM', $payload['knowledge_context']);
        $this->assertArrayNotHasKey('tool_session_id', $payload);
        $this->assertStringNotContainsString('five hostels', $payload['knowledge_context']);
        $this->assertArrayNotHasKey('api_key', $payload);
        Http::assertSent(fn (ClientRequest $sent): bool => $sent['uses'] === 1
            && ! str_contains($sent->url(), 'test-live-key'));
        Http::assertNotSent(fn (ClientRequest $sent): bool => str_contains($sent->url(), '/generateContent'));
    }

    /** THIS IS NEW CODE — ensure Live tool calls return bounded official-site facts without database or Gemini generation. Reason: the initial approved scope must work before knowledge tables are populated. */
    public function test_live_tool_returns_bounded_official_facts_without_database_and_deduplicates_call_ids(): void
    {
        config([
            'assistant.diagnostic_mode' => false,
            'assistant.temporary_knowledge_mode' => true,
            'assistant.official_website.enabled' => true,
            'rgu.canonical_url' => 'https://rathinamglobal.edu.in',
        ]);
        Cache::flush();
        $session = app('session.store');
        $sessionId = 'c17e36be-39b8-46f0-a62d-5ed7d81b20bb';
        $session->put('assistant_live_tool_session', [
            'id' => $sessionId,
            'expires_at' => now()->addMinutes(10)->timestamp,
            'calls' => [],
        ]);
        $databaseSearch = \Mockery::mock(KnowledgeSearchService::class);
        $databaseSearch->shouldNotReceive('search');
        $this->app->instance(KnowledgeSearchService::class, $databaseSearch);
        $staticSearch = \Mockery::mock(StaticKnowledgeSearchService::class);
        $staticSearch->shouldNotReceive('search');
        $this->app->instance(StaticKnowledgeSearchService::class, $staticSearch);
        $data = [
            'tool_session_id' => $sessionId,
            'tool_call_id' => 'call_knowledge_01',
            'query' => 'Tell me about BCA courses',
            'category' => 'general',
            'language' => 'en',
        ];
        Http::fake([
            'https://rathinamglobal.edu.in/sitemap.xml' => Http::response('<urlset><url><loc>https://rathinamglobal.edu.in/courses/bca</loc></url></urlset>'),
            'https://rathinamglobal.edu.in/courses/bca' => Http::response('<html><body><main><p>Rathinam offers a BCA programme through its School of Quantum Science.</p></main></body></html>'),
        ]);

        $firstRequest = Request::create('/api/voice-assistant/live-knowledge', 'POST', $data);
        $firstRequest->setLaravelSession($session);
        $first = app(VoiceWidgetController::class)->liveKnowledge($firstRequest, app(AssistantService::class));
        $secondRequest = Request::create('/api/voice-assistant/live-knowledge', 'POST', $data);
        $secondRequest->setLaravelSession($session);
        $second = app(VoiceWidgetController::class)->liveKnowledge($secondRequest, app(AssistantService::class));

        $this->assertSame(200, $first->getStatusCode());
        $this->assertSame('ok', $first->getData(true)['status']);
        $this->assertNotEmpty($first->getData(true)['facts']);
        $this->assertLessThanOrEqual(5, count($first->getData(true)['facts']));
        $this->assertSame($first->getData(true), $second->getData(true));
        Http::assertSent(fn (ClientRequest $sent): bool => str_contains($sent->url(), '/courses/bca'));
        Http::assertNotSent(fn (ClientRequest $sent): bool => str_contains($sent->url(), 'generativelanguage.googleapis.com'));
    }

    /** THIS IS NEW CODE — reject expired tool capabilities and clear them on hang-up. Reason: one student's Live session must never authorize another call. */
    public function test_tool_rejects_expired_session_and_hangup_invalidates_the_capability(): void
    {
        config(['assistant.diagnostic_mode' => false]);
        $session = app('session.store');
        $sessionId = 'c17e36be-39b8-46f0-a62d-5ed7d81b20bb';
        $session->put('assistant_live_tool_session', [
            'id' => $sessionId,
            'expires_at' => now()->subMinute()->timestamp,
            'calls' => [],
        ]);
        $controller = app(VoiceWidgetController::class);
        $toolRequest = Request::create('/api/voice-assistant/live-knowledge', 'POST', [
            'tool_session_id' => $sessionId,
            'tool_call_id' => 'call_expired',
            'query' => 'What courses are available?',
        ]);
        $toolRequest->setLaravelSession($session);
        $expired = $controller->liveKnowledge($toolRequest, app(AssistantService::class));
        $endRequest = Request::create('/api/voice-assistant/live-session/end', 'POST', ['tool_session_id' => $sessionId]);
        $endRequest->setLaravelSession($session);
        $ended = $controller->endLiveSession($endRequest);

        $this->assertSame(401, $expired->getStatusCode());
        $this->assertSame(200, $ended->getStatusCode());
        $this->assertNull($session->get('assistant_live_tool_session'));
    }

    /** THIS IS NEW CODE — exercise the official-site parser and Live context with mocked scraped HTML. Reason: prove navigation, SEO titles and repeated passages do not enter spoken-answer facts. */
    public function test_native_context_removes_navigation_seo_and_duplicate_website_passages(): void
    {
        config([
            'assistant.diagnostic_mode' => false,
            'assistant.temporary_knowledge_mode' => true,
            'assistant.official_website.enabled' => true,
            'rgu.canonical_url' => 'https://rathinamglobal.edu.in',
        ]);
        Cache::flush();
        Http::fake([
            'https://rathinamglobal.edu.in/sitemap.xml' => Http::response('<urlset><url><loc>https://rathinamglobal.edu.in/courses/bca</loc></url></urlset>'),
            'https://rathinamglobal.edu.in/courses/bca' => Http::response('<html><head><title>Best University in Tamil Nadu | Rathinam Global University</title><meta name="description" content="Skip to main content Home About Committee"></head><body><nav>Skip to main content Home About Committee</nav><main><h1>BCA Courses</h1><p>Rathinam offers a BCA programme in the School of Quantum Science.</p><p>Rathinam offers a BCA programme in the School of Quantum Science.</p><p>Best University in Tamil Nadu, apply now and read more.</p></main></body></html>'),
        ]);

        $websiteChunks = app(OfficialWebsiteSearchService::class)->search('BCA');
        Http::assertSent(fn (ClientRequest $sent): bool => str_contains($sent->url(), '/courses/bca'));
        $this->assertNotEmpty($websiteChunks);
        $result = app(AssistantService::class)->searchForLiveTool('BCA');
        $context = json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $this->assertSame('ok', $result['status']);
        $this->assertStringContainsString('Rathinam offers a BCA programme', $context);
        $this->assertStringNotContainsString('BCA Courses', $context);
        $this->assertStringNotContainsString('Skip to main content', $context);
        $this->assertStringNotContainsString('Best University in Tamil Nadu', $context);
        $this->assertCount(count(array_unique($result['facts'])), $result['facts']);
        $this->assertContains(['type' => 'official_website'], $result['source']);
        foreach (Http::recorded() as [$sent]) {
            $this->assertSame('rathinamglobal.edu.in', parse_url($sent->url(), PHP_URL_HOST));
            $this->assertSame('GET', $sent->method());
        }
    }

    /** THIS IS NEW CODE — return explicit not-found for unrelated or unsupported institution details. Reason: Live must not turn weak lexical matches into invented Rathinam facts. */
    public function test_native_tool_reports_unknown_course_and_fee_without_fabricating_facts(): void
    {
        config(['assistant.temporary_knowledge_mode' => true, 'assistant.official_website.enabled' => true]);
        Cache::flush();
        config(['rgu.canonical_url' => 'https://rathinamglobal.edu.in']);
        Http::fake([
            'https://rathinamglobal.edu.in/sitemap.xml' => Http::response('<urlset></urlset>'),
            'https://rathinamglobal.edu.in/' => Http::response('<html><body><main><p>Rathinam Global University offers programmes for students.</p></main></body></html>'),
        ]);

        $assistant = app(AssistantService::class);
        $unknownQuestion = 'What is the fictional Quantum Potato degree course?';
        $unknownCourse = $assistant->searchForLiveTool($unknownQuestion);
        $unknownFee = $assistant->searchForLiveTool('What is the fee for the fictional Quantum Potato degree?');

        $this->assertSame('not_found', $unknownCourse['status']);
        $this->assertTrue($unknownCourse['not_found']);
        $this->assertSame([], $unknownCourse['facts']);
        $this->assertSame('not_found', $unknownFee['status']);
        $this->assertSame([], $unknownFee['facts']);
        Http::assertNotSent(fn (ClientRequest $sent): bool => str_contains($sent->url(), 'generativelanguage.googleapis.com'));
    }
}
