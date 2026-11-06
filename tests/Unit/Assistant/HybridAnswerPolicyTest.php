<?php

namespace Tests\Unit\Assistant;

use App\Services\Assistant\AssistantService;
use App\Services\Assistant\PromptBuilderService;
use Tests\TestCase;

/** THIS IS NEW CODE — cover hybrid question routing and aligned chat/voice policies. Reason: general questions must not depend on retrieval, while Rathinam facts stay grounded. */
class HybridAnswerPolicyTest extends TestCase
{
    /** THIS IS NEW CODE — prove general-only questions bypass institution retrieval. Reason: Gemini general knowledge should be available without a Rathinam match. */
    public function test_general_only_question_does_not_require_rathinam_retrieval(): void
    {
        $this->assertSame('', app(AssistantService::class)->rathinamRetrievalQuestion('How do solar panels generate electricity?'));
    }

    /** THIS IS NEW CODE — prove Rathinam factual questions trigger verified retrieval. Reason: university claims must never come from guesswork. */
    public function test_rathinam_specific_question_requires_verified_retrieval(): void
    {
        $this->assertSame('What is the BCA fee at Rathinam', app(AssistantService::class)->rathinamRetrievalQuestion('What is the BCA fee at Rathinam?'));
    }

    /** THIS IS NEW CODE — prove mixed questions retain the general part and retrieve institutional facts. Reason: mixed requests need a complete answer with grounded university details. */
    public function test_mixed_question_requires_retrieval_for_its_rathinam_part(): void
    {
        $retrievalQuestion = app(AssistantService::class)->rathinamRetrievalQuestion('How does photosynthesis work, and what BCA courses does Rathinam offer?');

        $this->assertSame('what BCA courses does Rathinam offer', $retrievalQuestion);
        $this->assertTrue(app(AssistantService::class)->hasGeneralPart('How does photosynthesis work, and what BCA courses does Rathinam offer?', $retrievalQuestion));
    }

    /** THIS IS NEW CODE — ensure an empty knowledge result still carries the visitor question to Gemini. Reason: general questions must not early-return when nothing is retrieved. */
    public function test_empty_retrieval_keeps_general_question_in_gemini_turn(): void
    {
        $turn = app(PromptBuilderService::class)->userTurn('Explain photosynthesis simply.', []);

        $this->assertStringContainsString('Explain photosynthesis simply.', $turn);
        $this->assertStringContainsString("<knowledge>\n\n</knowledge>", $turn);
        $assistant = app(AssistantService::class);
        $this->assertFalse($assistant->hasGeneralPart('What is the BCA fee at Rathinam?', 'What is the BCA fee at Rathinam'));
    }

    /** THIS IS NEW CODE — verify missing institutional facts are never filled from general knowledge. Reason: retrieval gaps must be stated honestly. */
    public function test_unknown_rathinam_fact_is_not_invented(): void
    {
        $prompt = app(PromptBuilderService::class)->systemInstruction('en', 'en', 'admissions contact');

        $this->assertStringContainsString('Never infer an institutional fact from general knowledge.', $prompt);
        $this->assertStringContainsString('If verified Rathinam information is missing', $prompt);
    }

    /** THIS IS NEW CODE — compare policy requirements across chat and native voice. Reason: both interfaces must answer general and mixed questions consistently. */
    public function test_chat_and_native_voice_share_the_hybrid_policy(): void
    {
        $chat = app(PromptBuilderService::class)->systemInstruction('en', 'en', 'admissions contact');
        $voice = file_get_contents(public_path('js/gemini-live-native.js'));

        $this->assertStringContainsString('For general topics, answer helpfully from your general knowledge', $chat);
        $this->assertStringContainsString('Answer general questions from your general knowledge', (string) $voice);
        $this->assertStringContainsString('For Rathinam-specific', $chat);
        $this->assertStringContainsString('For Rathinam-specific facts', (string) $voice);
        $this->assertStringContainsString('For mixed questions', $chat);
        $this->assertStringContainsString('For mixed questions', (string) $voice);
        $this->assertStringContainsString('Never invent', $chat);
        $this->assertStringContainsString('Never invent', (string) $voice);
        $this->assertStringContainsString('If verified Rathinam information is missing', $chat);
        $this->assertStringContainsString('If Rathinam facts are missing', (string) $voice);
    }
}
