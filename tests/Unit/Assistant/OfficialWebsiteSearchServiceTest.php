<?php

namespace Tests\Unit\Assistant;

use App\Services\Assistant\OfficialWebsiteSearchService;
use App\Http\Controllers\Assistant\GeminiLiveTokenController;
use Illuminate\Http\Request;
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

    /** THIS IS NEW CODE — verify the Extended Thinking model and constrained speaker setup without contacting Google. Reason: token and WebSocket configuration must agree before Live testing. */
    public function test_live_token_uses_extended_thinking_model_and_matching_speaker_setup(): void
    {
        config([
            'assistant.gemini_live.key' => 'test-live-key',
            'assistant.gemini_live.model' => 'gemini-3.8-live-extended-thinking',
            'assistant.gemini_live.url' => 'https://generativelanguage.googleapis.com/v1beta',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['name' => 'unit-speaker-token'])]);

        $response = app(GeminiLiveTokenController::class)(Request::create('/api/gemini-live/token', 'POST', ['purpose' => 'speaker']));

        $this->assertSame('gemini-3.8-live-extended-thinking', $response->getData(true)['model']);
        Http::assertSent(fn ($request): bool => $request['bidiGenerateContentSetup']['model'] === 'models/gemini-3.8-live-extended-thinking'
            && $request['bidiGenerateContentSetup']['generationConfig']['responseModalities'] === ['AUDIO']
            && $request['bidiGenerateContentSetup']['generationConfig']['thinkingConfig']['thinkingLevel'] === 'LOW'
            && $request['bidiGenerateContentSetup']['systemInstruction']['parts'][0]['text'] === 'You are a speech renderer. Speak the exact text supplied by the client, verbatim. Do not add, remove, or infer any information.'
            && isset($request['bidiGenerateContentSetup']['outputAudioTranscription']));
    }

    /** THIS IS NEW CODE — keep standard Live as a reversible option without Extended Thinking fields. Reason: support a safe protocol rollback for comparison or compatibility issues. */
    public function test_standard_live_rollback_omits_extended_thinking_setup(): void
    {
        config([
            'assistant.gemini_live.key' => 'test-live-key',
            'assistant.gemini_live.model' => 'gemini-3.8-live',
            'assistant.gemini_live.url' => 'https://generativelanguage.googleapis.com/v1beta',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['name' => 'unit-standard-token'])]);

        $response = app(GeminiLiveTokenController::class)(Request::create('/api/gemini-live/token', 'POST', ['purpose' => 'speaker']));

        $this->assertSame('gemini-3.8-live', $response->getData(true)['model']);
        Http::assertSent(fn ($request): bool => $request['bidiGenerateContentSetup']['model'] === 'models/gemini-3.8-live'
            && ! isset($request['bidiGenerateContentSetup']['generationConfig']['thinkingConfig']));
    }

    /** THIS IS NEW CODE — verify configured models are loaded independently of credential values. Reason: detect stale config or accidental model drift without printing secrets. */
    public function test_cached_application_configuration_uses_the_requested_text_and_live_models(): void
    {
        $this->assertSame('gemini-3.8-live-extended-thinking', config('assistant.gemini_live.model'));
        $this->assertSame('gemini-3.8-flash', config('assistant.gemini.model'));
    }

    /** THIS IS NEW CODE — verify final turn gating and call-only memory cleanup in browser code without a Gemini connection. Reason: prevent stale audio or prior call context crossing turns. */
    public function test_live_client_waits_for_idle_and_voice_call_teardown_clears_history(): void
    {
        $liveScript = file_get_contents(public_path('js/gemini-live.js'));
        $voiceScript = file_get_contents(public_path('js/voice-assistant.js'));
        $endCallPosition = strpos((string) $voiceScript, 'function endCall()');
        $endCall = $endCallPosition === false ? '' : substr((string) $voiceScript, $endCallPosition, 1200);

        $this->assertStringContainsString("speechTurnComplete || (requiresInteractionIdle && !speechInteractionIdle)", (string) $liveScript);
        $this->assertStringContainsString("interactionStatus === 'IN_PROGRESS'", (string) $liveScript);
        $this->assertStringContainsString("interactionStatus === 'IDLE'", (string) $liveScript);
        $this->assertStringContainsString('pendingAnswerAudioChunks = []', (string) $liveScript);
        $this->assertStringContainsString('state.conversationId = null;', $endCall);
        $this->assertStringContainsString('state.lastLiveTranscript = "";', $endCall);
    }
}
