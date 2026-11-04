<?php

namespace Tests\Feature\Assistant;

use App\Services\Assistant\HostelTransportKnowledgeService;
use Illuminate\Support\Facades\Http;

class HostelTransportKnowledgeTest extends AssistantTestCase
{
    private HostelTransportKnowledgeService $htService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->htService = app(HostelTransportKnowledgeService::class);
        config([
            'assistant.diagnostic_mode' => false,
            'assistant.temporary_knowledge_mode' => true,
            'assistant.official_website.enabled' => false,
        ]);
    }

    /**
     * 1. All 30 FAQs are available to retrieval.
     */
    public function test_all_30_faqs_are_available_to_retrieval(): void
    {
        HostelTransportKnowledgeService::clearCache();
        $faqs = $this->htService->allFaqs();

        $this->assertCount(30, $faqs, 'Must contain all 30 FAQs extracted from Hostel_Transport.pdf');

        $numbers = array_column($faqs, 'number');
        sort($numbers);
        $this->assertSame(range(1, 30), $numbers, 'Must contain all Q1 through Q30 in sequential order');

        foreach ($faqs as $faq) {
            $this->assertNotEmpty($faq['question'], "FAQ {$faq['number']} question must not be empty");
            $this->assertNotEmpty($faq['answer'], "FAQ {$faq['number']} answer must not be empty");
            $this->assertNotEmpty($faq['section'], "FAQ {$faq['number']} section must not be empty");
            $this->assertNotEmpty($faq['search_text'], "FAQ {$faq['number']} search_text must not be empty");
        }
    }

    /**
     * 2. English hostel questions retrieve the correct answer.
     */
    public function test_english_hostel_questions_retrieve_the_correct_answer(): void
    {
        $this->fakeGemini('Wi-Fi is available across all hostel blocks.');

        // Q7: Wi-Fi
        $hits = $this->htService->search('Is Wi-Fi available in the hostel?');
        $this->assertNotEmpty($hits);
        $this->assertSame(7, $hits[0]->chunkId);
        $this->assertStringContainsString('Wi-Fi connectivity is available throughout the hostel premises', $hits[0]->content);

        // Q6: Furniture
        $hitsFurniture = $this->htService->search('What furniture is provided in hostel rooms?');
        $this->assertNotEmpty($hitsFurniture);
        $this->assertSame(6, $hitsFurniture[0]->chunkId);
        $this->assertStringContainsString('Beds, study tables, chairs', $hitsFurniture[0]->content);

        // Q22: Outside food
        $hitsFood = $this->htService->search('Is outside food allowed in the hostel?');
        $this->assertNotEmpty($hitsFood);
        $this->assertSame(22, $hitsFood[0]->chunkId);
        $this->assertStringContainsString('Outside food delivery is regulated', $hitsFood[0]->content);

        // End-to-end chat turn
        $reply = $this->ask('Is Wi-Fi available in the hostel?');
        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('Wi-Fi connectivity is available', $this->geminiPrompt());
    }

    /**
     * 3. Tamil hostel questions retrieve the correct answer.
     */
    public function test_tamil_hostel_questions_retrieve_the_correct_answer(): void
    {
        // Q7 in Tamil
        $hits = $this->htService->search('விடுதியில் Wi-Fi வசதி உள்ளதா?');
        $this->assertNotEmpty($hits);
        $this->assertSame(7, $hits[0]->chunkId);
        $this->assertStringContainsString('Wi-Fi connectivity is available', $hits[0]->content);

        // Q10 in Tamil: Food
        $hitsFood = $this->htService->search('விடுதியில் உணவு வழங்கப்படுகிறதா?');
        $this->assertNotEmpty($hitsFood);
        $this->assertSame(10, $hitsFood[0]->chunkId);
        $this->assertStringContainsString('Both vegetarian and non-vegetarian food is provided', $hitsFood[0]->content);

        // Q12 in Tamil: Laundry
        $hitsLaundry = $this->htService->search('விடுதியில் துணி துவைக்கும் வசதி உள்ளதா?');
        $this->assertNotEmpty($hitsLaundry);
        $this->assertSame(12, $hitsLaundry[0]->chunkId);
        $this->assertStringContainsString('Laundry services are available', $hitsLaundry[0]->content);
    }

    /**
     * 4. Tanglish hostel questions retrieve the correct answer.
     */
    public function test_tanglish_hostel_questions_retrieve_the_correct_answer(): void
    {
        // Q7 in Tanglish
        $hits = $this->htService->search('Hostel la Wi-Fi irukka?');
        $this->assertNotEmpty($hits);
        $this->assertSame(7, $hits[0]->chunkId);
        $this->assertStringContainsString('Wi-Fi connectivity is available', $hits[0]->content);

        // Q23 in Tanglish: Roommate preference
        $hitsRoommate = $this->htService->search('Hostel la roommate select panna mudiyuma?');
        $this->assertNotEmpty($hitsRoommate);
        $this->assertSame(23, $hitsRoommate[0]->chunkId);
        $this->assertStringContainsString('Roommate preferences are considered', $hitsRoommate[0]->content);

        // Q12 in Tanglish: Laundry
        $hitsLaundry = $this->htService->search('Hostel la laundry service irukka?');
        $this->assertNotEmpty($hitsLaundry);
        $this->assertSame(12, $hitsLaundry[0]->chunkId);
        $this->assertStringContainsString('Laundry services are available', $hitsLaundry[0]->content);
    }

    /**
     * 5. Transport timing questions retrieve the correct information.
     */
    public function test_transport_timing_questions_retrieve_the_correct_information(): void
    {
        // Q26: Morning pickup
        $hitsMorning = $this->htService->search('What are the morning pickup timings?');
        $this->assertNotEmpty($hitsMorning);
        $this->assertSame(26, $hitsMorning[0]->chunkId);
        $this->assertStringContainsString('6:45 AM and 8:05 AM', $hitsMorning[0]->content);

        // Q27: Arrival time
        $hitsArrival = $this->htService->search('What time do buses reach the campus?');
        $this->assertNotEmpty($hitsArrival);
        $this->assertSame(27, $hitsArrival[0]->chunkId);
        $this->assertStringContainsString('8:45 AM', $hitsArrival[0]->content);

        // Q28: Evening drop
        $hitsDrop = $this->htService->search('What are the evening drop timings?');
        $this->assertNotEmpty($hitsDrop);
        $this->assertSame(28, $hitsDrop[0]->chunkId);
        $this->assertStringContainsString('4:45 PM and 5:00 PM', $hitsDrop[0]->content);

        // Q30: Bus safety features
        $hitsSafety = $this->htService->search('What safety features are available in college buses?');
        $this->assertNotEmpty($hitsSafety);
        $this->assertSame(30, $hitsSafety[0]->chunkId);
        $this->assertStringContainsString('GPS tracking, CCTV cameras, first-aid kits', $hitsSafety[0]->content);
    }

    /**
     * 6. General AI questions bypass university retrieval.
     */
    public function test_general_ai_questions_bypass_university_retrieval(): void
    {
        // Knowledge service search returns empty
        $hits = $this->htService->search('What is artificial intelligence?');
        $this->assertEmpty($hits, 'General AI question must bypass hostel/transport retrieval');

        $this->fakeGemini('Artificial intelligence is technology enabling machines to learn.');

        $reply = $this->ask('What is artificial intelligence?');
        $this->assertSame('answered', $reply['message']['status']);

        // Assert prompt sent to Gemini has NO institutional hostel or transport chunks
        $prompt = $this->geminiPrompt();
        $this->assertStringNotContainsString('Wi-Fi connectivity is available', $prompt);
        $this->assertStringNotContainsString('Hostel', $prompt);
        $this->assertStringNotContainsString('pickup timings', $prompt);
    }

    /**
     * 7. General Python questions bypass university retrieval.
     */
    public function test_general_python_questions_bypass_university_retrieval(): void
    {
        $hits = $this->htService->search('Explain Python programming language.');
        $this->assertEmpty($hits, 'General Python question must bypass hostel/transport retrieval');

        $this->fakeGemini('Python is a popular high-level programming language.');

        $reply = $this->ask('Explain Python.');
        $this->assertSame('answered', $reply['message']['status']);

        $prompt = $this->geminiPrompt();
        $this->assertStringNotContainsString('hostel', $prompt);
        $this->assertStringNotContainsString('transport', $prompt);
    }

    /**
     * 8. Follow-up questions retain relevant conversation context.
     */
    public function test_follow_up_questions_retain_relevant_conversation_context(): void
    {
        $this->fakeGemini('Yes, Wi-Fi is provided throughout the hostel.');

        // Turn 1: Hostel question
        $turn1 = $this->ask('Does Rathinam provide hostel facilities?');
        $this->assertSame('answered', $turn1['message']['status']);

        // Turn 2: Follow-up without repeating "hostel", reusing the conversation
        $turn2 = $this->ask('Is Wi-Fi available there?', conversation: $turn1['conversation']);
        $this->assertSame('answered', $turn2['message']['status']);

        // Turn 2 context should carry verified knowledge
        $prompt = $this->geminiPrompt();
        $this->assertStringContainsString('Wi-Fi connectivity is available', $prompt);
    }

    /**
     * 9. Unknown hostel/transport questions do not produce invented answers.
     */
    public function test_unknown_hostel_transport_questions_do_not_produce_invented_answers(): void
    {
        Http::fake();

        // Question about something NOT in the hostel knowledge file
        $reply = $this->ask('What is the swimming pool fee for hostel students?');

        $this->assertSame('unanswered', $reply['message']['status']);
        $this->assertStringContainsString('I do not have verified information', $reply['message']['answer']);
        $this->assertStringContainsString('admissions team', $reply['message']['answer']);

        // Gemini was not called to invent facts
        Http::assertNothingSent();
    }

    /**
     * 10. Retrieval failures do not leave Priya stuck displaying "Wait".
     */
    public function test_retrieval_failures_do_not_leave_priya_stuck_displaying_wait(): void
    {
        // When Gemini fails or times out, extractive fallback delivers verified answer
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['error' => 'Service Unavailable'], 503)]);

        $reply = $this->ask('Is Wi-Fi available in the hostel?');

        // Status is marked failed for API telemetry, but ai_response contains verified answer
        $this->assertSame('failed', $reply['message']['status']);
        $this->assertStringContainsString('Wi-Fi connectivity is available throughout the hostel premises', $reply['message']['answer']);
        $this->assertNotSame('', $reply['message']['answer']);
    }
}
