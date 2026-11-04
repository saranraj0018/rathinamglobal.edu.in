<?php

namespace Tests\Feature\Assistant;

use App\Http\Controllers\Assistant\VoiceWidgetController;
use App\Models\AssistantMessage;
use App\Services\Assistant\AssistantService;
use App\Services\Assistant\HostelTransportKnowledgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AssistantTwoPathTest extends AssistantTestCase
{
    private HostelTransportKnowledgeService $htService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->htService = app(HostelTransportKnowledgeService::class);
        HostelTransportKnowledgeService::clearCache();

        config([
            'assistant.diagnostic_mode' => false,
            'assistant.hostel_only_knowledge' => true,
            'assistant.temporary_knowledge_mode' => true,
            'assistant.official_website.enabled' => false,
        ]);
    }

    protected function fakeGeminiResponses(array $responses): void
    {
        $sequence = Http::fakeSequence('generativelanguage.googleapis.com/*');
        foreach ($responses as $text) {
            $sequence->push([
                'candidates' => [['content' => ['parts' => [['text' => $text]]]]],
                'usageMetadata' => ['promptTokenCount' => 120, 'candidatesTokenCount' => 30],
            ]);
        }
    }

    /**
     * 1. What is artificial intelligence? -> General Gemini answer
     */
    public function test_what_is_artificial_intelligence_uses_general_gemini_intelligence(): void
    {
        $this->fakeGemini('Artificial intelligence enables computers to learn and solve problems.');

        $reply = $this->ask('What is artificial intelligence?');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('Artificial intelligence enables computers', $reply['message']['answer']);

        // Must NOT contain any hostel or transport chunks in the prompt sent to Gemini
        $prompt = $this->geminiPrompt();
        $this->assertStringNotContainsString('Wi-Fi connectivity is available', $prompt);
        $this->assertStringNotContainsString('Hostel', $prompt);
        $this->assertStringNotContainsString('pickup timings', $prompt);
    }

    /**
     * 2. Explain Python -> General Gemini answer
     */
    public function test_explain_python_uses_general_gemini_intelligence(): void
    {
        $this->fakeGemini('Python is a readable, versatile programming language.');

        $reply = $this->ask('Explain Python');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('Python is a readable', $reply['message']['answer']);

        $prompt = $this->geminiPrompt();
        $this->assertStringNotContainsString('hostel', $prompt);
        $this->assertStringNotContainsString('transport', $prompt);
    }

    /**
     * 3. What is machine learning? -> General Gemini answer
     */
    public function test_what_is_machine_learning_uses_general_gemini_intelligence(): void
    {
        $this->fakeGemini('Machine learning is a subset of AI focusing on data-driven patterns.');

        $reply = $this->ask('What is machine learning?');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('subset of AI', $reply['message']['answer']);

        $prompt = $this->geminiPrompt();
        $this->assertStringNotContainsString('hostel', $prompt);
        $this->assertStringNotContainsString('bus', $prompt);
    }

    /**
     * 4. Does Rathinam provide hostel Wi-Fi? -> Retrieve hostel Q7
     */
    public function test_does_rathinam_provide_hostel_wifi_retrieves_q7(): void
    {
        $this->fakeGemini('Yes, Wi-Fi is available across all hostel premises.');

        $reply = $this->ask('Does Rathinam provide hostel Wi-Fi?');

        $this->assertSame('answered', $reply['message']['status']);
        $prompt = $this->geminiPrompt();
        $this->assertStringContainsString('Wi-Fi connectivity is available throughout the hostel premises', $prompt);
    }

    /**
     * 5. Hostel la food irukka? -> Retrieve hostel Q10
     */
    public function test_hostel_la_food_irukka_retrieves_q10(): void
    {
        $this->fakeGemini('ஆம், விடுதியில் சைவம் மற்றும் அசைவ உணவு வழங்கப்படுகிறது.');

        $reply = $this->ask('Hostel la food irukka?');

        $this->assertSame('answered', $reply['message']['status']);
        $prompt = $this->geminiPrompt();
        $this->assertStringContainsString('Both vegetarian and non-vegetarian food is provided', $prompt);
    }

    /**
     * 6. விடுதியில் துணி துவைக்கும் வசதி உள்ளதா? -> Retrieve hostel Q12
     */
    public function test_tamil_laundry_question_retrieves_q12(): void
    {
        $this->fakeGemini('ஆம், விடுதி மாணவர்களுக்கு துணி துவைக்கும் வசதி வழங்கப்படுகிறது.');

        $reply = $this->ask('விடுதியில் துணி துவைக்கும் வசதி உள்ளதா?');

        $this->assertSame('answered', $reply['message']['status']);
        $prompt = $this->geminiPrompt();
        $this->assertStringContainsString('Laundry services are available for hostel students', $prompt);
    }

    /**
     * 7. What time do buses reach campus? -> Retrieve hostel Q27
     */
    public function test_what_time_do_buses_reach_campus_retrieves_q27(): void
    {
        $this->fakeGemini('All college buses reach the campus by 8:45 AM.');

        $reply = $this->ask('What time do buses reach campus?');

        $this->assertSame('answered', $reply['message']['status']);
        $prompt = $this->geminiPrompt();
        $this->assertStringContainsString('All buses reach the campus by 8:45 AM', $prompt);
    }

    /**
     * 8. Bus-la GPS tracking irukka? -> Retrieve hostel Q30
     */
    public function test_bus_la_gps_tracking_irukka_retrieves_q30(): void
    {
        $this->fakeGemini('ஆம், அனைத்து பேருந்துகளிலும் GPS டிராக்கிங் வசதி உள்ளது.');

        $reply = $this->ask('Bus-la GPS tracking irukka?');

        $this->assertSame('answered', $reply['message']['status']);
        $prompt = $this->geminiPrompt();
        $this->assertStringContainsString('GPS tracking, CCTV cameras, first-aid kits', $prompt);
    }

    /**
     * 9. What is the hostel fee? -> No invented answer, unanswered status
     */
    public function test_what_is_the_hostel_fee_does_not_invent_answer(): void
    {
        Http::fake();

        $reply = $this->ask('What is the hostel fee?');

        $this->assertSame(AssistantMessage::STATUS_UNANSWERED, $reply['message']['status']);
        $this->assertStringContainsString('I do not have verified information', $reply['message']['answer']);
        $this->assertStringContainsString('admissions team', $reply['message']['answer']);

        // Gemini must not be called to fabricate fees
        Http::assertNothingSent();
    }

    /**
     * 10. Tell me a joke -> General Gemini answer
     */
    public function test_tell_me_a_joke_uses_general_gemini_intelligence(): void
    {
        $this->fakeGemini('Why do programmers prefer dark mode? Because light attracts bugs!');

        $reply = $this->ask('Tell me a joke');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('Because light attracts bugs', $reply['message']['answer']);

        $prompt = $this->geminiPrompt();
        $this->assertStringNotContainsString('hostel', $prompt);
        $this->assertStringNotContainsString('transport', $prompt);
    }

    /**
     * 11. General question followed by hostel question
     */
    public function test_general_question_followed_by_hostel_question(): void
    {
        $this->fakeGeminiResponses([
            'Artificial intelligence is technology enabling computers to learn.',
            'Yes, Wi-Fi is provided throughout the hostel.',
        ]);

        // Turn 1: General question
        $turn1 = $this->ask('What is artificial intelligence?');
        $this->assertSame('answered', $turn1['message']['status']);

        // Turn 2: Hostel question
        $turn2 = $this->ask('Does Rathinam provide hostel Wi-Fi?', conversation: $turn1['conversation']);
        $this->assertSame('answered', $turn2['message']['status']);
        $this->assertStringContainsString('Wi-Fi connectivity is available', $this->geminiPrompt());
    }

    /**
     * 12. Hostel question followed by general question
     */
    public function test_hostel_question_followed_by_general_question(): void
    {
        $this->fakeGeminiResponses([
            'Yes, Wi-Fi is available in all hostel blocks.',
            'Machine learning teaches machines to recognise patterns.',
        ]);

        // Turn 1: Hostel question
        $turn1 = $this->ask('Does Rathinam provide hostel Wi-Fi?');
        $this->assertSame('answered', $turn1['message']['status']);

        // Turn 2: General question
        $turn2 = $this->ask('Explain machine learning', conversation: $turn1['conversation']);
        $this->assertSame('answered', $turn2['message']['status']);
        $this->assertStringContainsString('Machine learning teaches', $turn2['message']['answer']);
    }

    /**
     * 13. English to Tamil language switching
     */
    public function test_english_to_tamil_language_switching(): void
    {
        $this->fakeGeminiResponses([
            'Yes, hot water facility is available.',
            'ஆம், சுடு தண்ணீர் வசதி உள்ளது.',
        ]);

        // Turn 1: English
        $turn1 = $this->ask('Is hot water facility available in the hostel?');
        $this->assertSame('answered', $turn1['message']['status']);
        $this->assertSame('en', $turn1['message']['language']);

        // Turn 2: Tamil
        $turn2 = $this->ask('சுடு தண்ணீர் வசதி உள்ளதா?', conversation: $turn1['conversation']);
        $this->assertSame('answered', $turn2['message']['status']);
        $this->assertSame('ta', $turn2['message']['language']);
    }

    /**
     * 14. Follow-up question retains context
     */
    public function test_follow_up_question_retains_context(): void
    {
        $this->fakeGeminiResponses([
            'Yes, separate hostel facilities are provided.',
            'Wi-Fi is available across all premises.',
        ]);

        // Turn 1
        $turn1 = $this->ask('Does Rathinam provide hostel facilities?');
        $this->assertSame('answered', $turn1['message']['status']);

        // Turn 2: Follow-up without repeating "hostel"
        $turn2 = $this->ask('Is Wi-Fi available there?', conversation: $turn1['conversation']);
        $this->assertSame('answered', $turn2['message']['status']);
        $this->assertStringContainsString('Wi-Fi connectivity is available', $this->geminiPrompt());
    }

    /**
     * 15. Retrieval failure does not break general conversation
     */
    public function test_retrieval_failure_does_not_break_general_conversation(): void
    {
        // When Gemini fails on an unknown general turn, friendly fallback is given
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['error' => 'Service Unavailable'], 503)]);

        $reply = $this->ask('Tell me about quantum computing');

        $this->assertSame('failed', $reply['message']['status']);
        $this->assertNotEmpty($reply['message']['answer']);
    }

    /**
     * 16. Live tool endpoint returns verified facts in proper format for Gemini Live
     */
    public function test_live_tool_endpoint_returns_verified_hostel_facts(): void
    {
        Cache::flush();
        $session = app('session.store');
        $sessionId = 'e57976e5-4f51-419b-a0ea-4ceeeef50123';
        $session->put('assistant_live_tool_session', [
            'id' => $sessionId,
            'expires_at' => now()->addMinutes(10)->timestamp,
            'calls' => [],
        ]);

        $controller = app(VoiceWidgetController::class);
        $assistant = app(AssistantService::class);

        $request = Request::create('/api/voice-assistant/live-knowledge', 'POST', [
            'tool_session_id' => $sessionId,
            'tool_call_id' => 'call_wifi_01',
            'query' => 'Does Rathinam provide hostel Wi-Fi?',
            'category' => 'hostel',
        ]);
        $request->setLaravelSession($session);

        $response = $controller->liveKnowledge($request, $assistant);
        $data = $response->getData(true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', $data['status']);
        $this->assertFalse($data['not_found']);
        $this->assertNotEmpty($data['facts']);
        $this->assertStringContainsString('Wi-Fi connectivity is available throughout the hostel premises', $data['facts'][0]);
    }

    /**
     * 18. Q25 retrieval specifically returns areas covered and bus route facts
     */
    public function test_q25_retrieval_returns_areas_covered(): void
    {
        $chunks = $this->htService->search('What bus routes are available?');
        $this->assertNotEmpty($chunks);

        $faq25 = collect($chunks)->first(fn ($c) => $c->sourceId === 25);
        $this->assertNotNull($faq25);
        $this->assertStringContainsString('Major towns, residential locations, and student-dense areas are covered', $faq25->content);
    }

    /**
     * 19. Q25 Live tool response returns status ok and source-supported facts
     */
    public function test_q25_live_tool_response(): void
    {
        Cache::flush();
        $session = app('session.store');
        $sessionId = 'e57976e5-4f51-419b-a0ea-4ceeeef50123';
        $session->put('assistant_live_tool_session', [
            'id' => $sessionId,
            'expires_at' => now()->addMinutes(10)->timestamp,
            'calls' => [],
        ]);

        $request = Request::create('/api/voice-assistant/live-knowledge', 'POST', [
            'tool_session_id' => $sessionId,
            'tool_call_id' => 'call_bus_routes_25',
            'query' => 'What bus routes are available?',
            'category' => 'transport',
        ]);
        $request->setLaravelSession($session);

        $response = app(VoiceWidgetController::class)->liveKnowledge($request, app(AssistantService::class));
        $data = $response->getData(true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', $data['status']);
        $this->assertFalse($data['not_found']);
        $this->assertNotEmpty($data['facts']);
        $this->assertTrue(collect($data['facts'])->contains(fn ($f) => str_contains($f, 'Major towns, residential locations, and student-dense areas are covered.')));
    }

    /**
     * 20. Q26 Live tool response returns morning pickup timings
     */
    public function test_q26_live_tool_response_returns_morning_pickup_timings(): void
    {
        Cache::flush();
        $session = app('session.store');
        $sessionId = 'e57976e5-4f51-419b-a0ea-4ceeeef50123';
        $session->put('assistant_live_tool_session', [
            'id' => $sessionId,
            'expires_at' => now()->addMinutes(10)->timestamp,
            'calls' => [],
        ]);

        $request = Request::create('/api/voice-assistant/live-knowledge', 'POST', [
            'tool_session_id' => $sessionId,
            'tool_call_id' => 'call_pickup_26',
            'query' => 'What are the morning pickup timings?',
            'category' => 'transport',
        ]);
        $request->setLaravelSession($session);

        $response = app(VoiceWidgetController::class)->liveKnowledge($request, app(AssistantService::class));
        $data = $response->getData(true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('ok', $data['status']);
        $this->assertFalse($data['not_found']);
        $this->assertNotEmpty($data['facts']);
        $this->assertTrue(collect($data['facts'])->contains(fn ($f) => str_contains($f, '6:45 AM and 8:05 AM')));
    }

    /**
     * 21. Live tool failure handling: expired session rejects with 401
     */
    public function test_live_tool_failure_handling_rejects_expired_session(): void
    {
        Cache::flush();
        $session = app('session.store');
        $sessionId = 'e57976e5-4f51-419b-a0ea-4ceeeef50123';
        $session->put('assistant_live_tool_session', [
            'id' => $sessionId,
            'expires_at' => now()->subMinute()->timestamp,
            'calls' => [],
        ]);

        $request = Request::create('/api/voice-assistant/live-knowledge', 'POST', [
            'tool_session_id' => $sessionId,
            'tool_call_id' => 'call_expired_01',
            'query' => 'What bus routes are available?',
            'category' => 'transport',
        ]);
        $request->setLaravelSession($session);

        $response = app(VoiceWidgetController::class)->liveKnowledge($request, app(AssistantService::class));
        $this->assertSame(401, $response->getStatusCode());
        $this->assertSame('expired', $response->getData(true)['status']);
    }

    /**
     * 22. Live tool handles empty retrieval for unverified campus details
     */
    public function test_live_tool_empty_retrieval_for_unverified_facilities(): void
    {
        Cache::flush();
        $session = app('session.store');
        $sessionId = 'e57976e5-4f51-419b-a0ea-4ceeeef50123';
        $session->put('assistant_live_tool_session', [
            'id' => $sessionId,
            'expires_at' => now()->addMinutes(10)->timestamp,
            'calls' => [],
        ]);

        $request = Request::create('/api/voice-assistant/live-knowledge', 'POST', [
            'tool_session_id' => $sessionId,
            'tool_call_id' => 'call_unverified_01',
            'query' => 'Is there an Olympic swimming pool in the hostel?',
            'category' => 'hostel',
        ]);
        $request->setLaravelSession($session);

        $response = app(VoiceWidgetController::class)->liveKnowledge($request, app(AssistantService::class));
        $data = $response->getData(true);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('not_found', $data['status']);
        $this->assertTrue($data['not_found']);
        $this->assertSame([], $data['facts']);
    }
}
