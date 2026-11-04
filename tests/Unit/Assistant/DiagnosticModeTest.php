<?php

namespace Tests\Unit\Assistant;

use App\Http\Controllers\Assistant\VoiceWidgetController;
use App\Services\Assistant\AssistantService;
use App\Services\Assistant\GeminiResponse;
use App\Services\Assistant\GeminiService;
use App\Services\Assistant\KnowledgeSearchService;
use App\Services\Assistant\OfficialWebsiteSearchService;
use App\Services\Assistant\PromptBuilderService;
use App\Services\Assistant\StaticKnowledgeSearchService;
use App\Services\Assistant\TextNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

/** THIS IS NEW CODE — verify temporary diagnostic requests bypass stored knowledge and use only Gemini. Reason: prevent any retrieval or database access while checking API keys. */
class DiagnosticModeTest extends TestCase
{
    /** THIS IS NEW CODE — confirm the primary chat endpoint never loads or creates a conversation during diagnosis. Reason: a database connection must not affect API-key testing. */
    public function test_primary_chat_route_uses_gemini_without_database_conversation_access(): void
    {
        config(['assistant.diagnostic_mode' => true]);
        $assistant = Mockery::mock(AssistantService::class);
        $assistant->shouldReceive('diagnosticAnswer')->once()->with('How does rain form?')
            ->andReturn(new GeminiResponse('Direct Gemini response.', 'configured-text-model', null, null));
        $assistant->shouldNotReceive('ask');
        $this->app->instance(AssistantService::class, $assistant);
        $csrf = str_repeat('a', 40);

        $response = $this->withSession(['_token' => $csrf])->withHeader('X-CSRF-TOKEN', $csrf)
            ->postJson(route('assistant.ask'), ['message' => 'How does rain form?']);

        $response->assertOk()->assertJsonPath('message.answer', 'Direct Gemini response.')
            ->assertJsonPath('message.sources', [])->assertJsonPath('conversation', null);
    }

    /** THIS IS NEW CODE — prove the service sends exactly one raw user turn and a no-lookup prompt to Gemini. Reason: prevent retrieval context from contaminating the key test. */
    public function test_service_sends_only_the_raw_user_question_to_gemini(): void
    {
        $gemini = Mockery::mock(GeminiService::class);
        $gemini->shouldReceive('generate')->once()->withArgs(function (string $prompt, array $turns): bool {
            return str_contains($prompt, 'general assistant in temporary API-key diagnostic mode')
                && str_contains($prompt, 'Do not claim to have looked up Rathinam facts')
                && $turns === [['role' => 'user', 'text' => '  What is photosynthesis?  ']];
        })->andReturn(new GeminiResponse('Gemini-only answer.', 'configured-text-model', null, null));

        $service = new AssistantService(
            new TextNormalizer,
            Mockery::mock(KnowledgeSearchService::class),
            Mockery::mock(StaticKnowledgeSearchService::class),
            Mockery::mock(OfficialWebsiteSearchService::class),
            new PromptBuilderService,
            $gemini,
        );

        $this->assertSame('Gemini-only answer.', $service->diagnosticAnswer('  What is photosynthesis?  ')->text);
    }

    /** THIS IS NEW CODE — prove diagnostic Live token setup creates no retrieval session capability. Reason: the browser must have no authorized Laravel data-search path in this mode. */
    public function test_native_live_diagnostic_token_does_not_create_a_tool_session(): void
    {
        config([
            'assistant.diagnostic_mode' => true,
            'assistant.gemini_live.key' => 'mock-key',
            'assistant.gemini_live.model' => 'configured-live-model',
            'assistant.gemini_live.url' => 'https://generativelanguage.googleapis.com/v1beta',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['name' => 'one-use-token'])]);
        $session = app('session.store');
        $request = Request::create('/api/gemini-live/native-token', 'POST');
        $request->setLaravelSession($session);

        $response = app(\App\Http\Controllers\Assistant\GeminiLiveTokenController::class)->native($request);

        $this->assertTrue($response->getData(true)['diagnostic_mode']);
        $this->assertNull($response->getData(true)['tool_session_id']);
        $this->assertFalse($session->has('assistant_live_tool_session'));
        Http::assertSentCount(1);
    }

    /** THIS IS NEW CODE — confirm voice chat returns Gemini output directly without persistence or retrieval calls. Reason: voice diagnostics must test the configured Gemini model alone. */
    public function test_voice_chat_diagnostic_branch_returns_gemini_answer_without_creating_a_conversation(): void
    {
        config(['assistant.diagnostic_mode' => true]);
        $assistant = Mockery::mock(AssistantService::class);
        $assistant->shouldReceive('diagnosticAnswer')->once()->with('raw voice question', Mockery::type('string'))
            ->andReturn(new GeminiResponse('Direct Gemini response.', 'configured-text-model', null, null));
        $assistant->shouldNotReceive('ask');
        $assistant->shouldNotReceive('searchForLiveTool');

        $request = Request::create('/api/voice-assistant/chat', 'POST', server: ['CONTENT_TYPE' => 'application/json'], content: '{"message":"raw voice question"}');
        $response = app(VoiceWidgetController::class)->chat($request, $assistant);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('Direct Gemini response.', $response->getData(true)['answer']);
        $this->assertSame('diagnostic', $response->getData(true)['mode']);
        $this->assertSame([], $response->getData(true)['sources']);
    }
}
