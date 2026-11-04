<?php

namespace Tests\Feature\Assistant;

use Illuminate\Support\Facades\Http;

/** THIS IS NEW CODE — verifies non-billable retrieval fallbacks. Reason: reproduce missing local-index coverage without calling Gemini. */
class AssistantRetrievalFallbackTest extends AssistantTestCase
{
    /** THIS IS NEW CODE — protect the grounded answer policy and spoken style from regression. Reason: concise verified summaries must be expressed conversationally in both supported languages. */
    public function test_spoken_answer_prompt_summarizes_retrieved_facts_without_reading_source_text(): void
    {
        $prompt = app(\App\Services\Assistant\PromptBuilderService::class)->systemInstruction('ta', 'ta', 'admissions@example.invalid');

        $this->assertStringContainsString('natural spoken phrasing', $prompt);
        $this->assertStringContainsString('never quote, recite, or read source text', $prompt);
        $this->assertStringContainsString('one to three sentences', $prompt);
        $this->assertStringContainsString('using only the supplied knowledge base', $prompt);
    }

    public function test_official_site_evidence_is_used_when_database_has_no_match(): void
    {
        config(['assistant.gemini.model' => null, 'assistant.official_website.enabled' => true]);
        Http::fake([
            'https://rathinamglobal.edu.in/sitemap.xml' => Http::response('<urlset><url><loc>https://rathinamglobal.edu.in/courses/school-of-quantum-science</loc></url></urlset>'),
            'https://rathinamglobal.edu.in/courses/school-of-quantum-science' => Http::response('<html><title>School of Quantum Science</title><body>BCA Bachelor of Computer Applications programme.</body></html>'),
        ]);

        $reply = $this->ask('Tell me about BCA at Rathinam.');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('BCA', $reply['message']['answer']);
        Http::assertSent(fn ($request): bool => str_contains($request->url(), 'rathinamglobal.edu.in/courses/school-of-quantum-science'));
    }

    /** THIS IS NEW CODE — verifies precise, non-billable offline fallback answers for the two failing browser questions. Reason: Gemini timed out and previously returned page prefixes. */
    public function test_hostel_question_returns_the_official_site_answer_after_gemini_outage(): void
    {
        config(['assistant.gemini.model' => 'test-model', 'assistant.official_website.enabled' => true, 'assistant.temporary_knowledge_mode' => true]);
        Http::fake([
            'https://rathinamglobal.edu.in/sitemap.xml' => Http::response('<urlset></urlset>'),
            'https://rathinamglobal.edu.in/' => Http::response('<html><title>Rathinam Global University</title><body>HOSTEL & CAMPUS LIFE Does the campus offer dedicated Hostel Facilities? Yes, information regarding “Hostel Facility” is provided.</body></html>'),
            'generativelanguage.googleapis.com/*' => Http::response(['error' => ['status' => 'UNAVAILABLE', 'message' => 'temporarily unavailable']], 503),
        ]);

        $reply = $this->ask('Hostel facilities pathi sollu.');

        $this->assertSame('failed', $reply['message']['status']);
        $this->assertSame('ஆம். விடுதி வசதி குறித்த தகவல் வழங்கப்படுகிறது.', $reply['message']['answer']);
    }

    /** THIS IS NEW CODE — ensures a Gemini outage still yields a concise answer from the exact official course page. Reason: backend text generation is currently intermittently unavailable. */
    public function test_bsc_computer_science_question_returns_the_verified_course_answer_after_gemini_outage(): void
    {
        config(['assistant.gemini.model' => 'test-model', 'assistant.official_website.enabled' => true, 'assistant.temporary_knowledge_mode' => true]);
        Http::fake([
            'https://rathinamglobal.edu.in/sitemap.xml' => Http::response('<urlset><url><loc>https://rathinamglobal.edu.in/courses/b.sc-computer-science</loc></url></urlset>'),
            'https://rathinamglobal.edu.in/courses/b.sc-computer-science' => Http::response('<html><title>B.Sc Computer Science | School of Quantum Science, Computing & AI | RGU</title><body>Bachelor of Science in Computer Science with AI, Generative AI and Cloud.</body></html>'),
            'generativelanguage.googleapis.com/*' => Http::response(['error' => ['status' => 'UNAVAILABLE', 'message' => 'temporarily unavailable']], 503),
        ]);

        $reply = $this->ask('Rathinam College la BSc Computer Science irukka?');

        $this->assertSame('failed', $reply['message']['status']);
        $this->assertSame('ஆம். ரத்தினம் குளோபல் பல்கலைக்கழகத்தில் B.Sc Computer Science படிப்பு உள்ளது.', $reply['message']['answer']);
    }

    /** THIS IS NEW CODE — proves bundled programme data covers empty database results without Gemini usage. Reason: the actual index has no matching course rows. */
    public function test_bundled_programme_evidence_is_used_when_database_has_no_match(): void
    {
        config(['assistant.gemini.model' => null, 'assistant.official_website.enabled' => false, 'assistant.temporary_knowledge_mode' => true]);
        Http::fake();

        $reply = $this->ask('Tell me about B.Sc Computer Science at Rathinam.');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('Computer Science', $reply['message']['answer']);
        Http::assertNothingSent();
    }

    /** THIS IS NEW CODE — covers broad overview wording that normalizes to no search terms. Reason: reproduce “about Rathinam College” returning no verified information. */
    public function test_broad_rathinam_overview_uses_approved_institutional_facts_without_gemini(): void
    {
        config(['assistant.gemini.model' => null, 'assistant.official_website.enabled' => false, 'assistant.temporary_knowledge_mode' => true]);
        Http::fake();

        $reply = $this->ask('Tell me about Rathinam College.');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('deemed university in Coimbatore', $reply['message']['answer']);
        $this->assertStringContainsString('Arts and Science, Engineering, Management', $reply['message']['answer']);
        Http::assertNothingSent();
    }

    /** THIS IS NEW CODE — verify broad hostel questions return facilities from the official campus page. Reason: the prior fallback only repeated the FAQ placeholder. */
    public function test_broad_hostel_question_returns_verified_facilities_without_gemini(): void
    {
        config(['assistant.gemini.model' => null, 'assistant.official_website.enabled' => false, 'assistant.temporary_knowledge_mode' => true]);
        Http::fake();

        $reply = $this->ask('hostel', language: 'en');

        $this->assertSame('answered', $reply['message']['status']);
        $this->assertStringContainsString('five hostels', $reply['message']['answer']);
        $this->assertStringContainsString('24/7 security', $reply['message']['answer']);
        $this->assertStringContainsString('prayer hall, TV hall, gym', $reply['message']['answer']);
        Http::assertNothingSent();
    }

    /** THIS IS NEW CODE — ensure the requested welcome and role are active in the persona data. Reason: separately verify displayed greeting configuration. */
    public function test_priya_persona_uses_the_requested_greeting_and_general_assistant_label(): void
    {
        $persona = require resource_path('data/assistant-personas.php');

        $this->assertSame('Welcome to Rathinam AI. What information do you need?', $persona['admissions']['greeting']['en']);
        $this->assertSame('Rathinam AI Assistant', $persona['admissions']['role']['en']);
    }

    public function test_unrelated_question_does_not_send_generation_when_retrieval_is_empty(): void
    {
        config(['assistant.gemini.model' => null, 'assistant.official_website.enabled' => false, 'assistant.temporary_knowledge_mode' => true]);
        Http::fake();

        $reply = $this->ask('What is the weather on Mars?');

        $this->assertSame('unanswered', $reply['message']['status']);
        Http::assertNothingSent();
    }
}
