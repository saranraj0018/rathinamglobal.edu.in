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
    public function test_legacy_live_knowledge_route_is_not_registered(): void
    {
        $this->postJson('/api/voice-assistant/live-knowledge', [])->assertMethodNotAllowed();
    }
}
