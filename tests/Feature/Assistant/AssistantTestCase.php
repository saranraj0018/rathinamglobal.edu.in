<?php

namespace Tests\Feature\Assistant;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

abstract class AssistantTestCase extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'assistant.gemini.key' => 'test-key',
            'assistant.gemini.model' => 'test-model',
            'assistant.gemini.retry_delay_ms' => 0,
            'assistant.google.api_key' => 'google-test-key',
            'assistant.google.credentials' => null,
        ]);
    }

    protected function fakeGemini(string $text = 'Grounded answer.'): void
    {
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [['content' => ['parts' => [['text' => $text]]]]],
            'usageMetadata' => ['promptTokenCount' => 120, 'candidatesTokenCount' => 30],
        ])]);
    }

    protected function bcaFeeFaq(): Faq
    {
        return Faq::factory()->create([
            'faq_category_id' => FaqCategory::factory()->create(['name_en' => 'Fees'])->id,
            'question_en' => 'What is the fee for the BCA course?',
            'answer_en' => 'The BCA annual fee is Rs 85,000.',
            'question_ta' => 'BCA படிப்புக்கான கட்டணம் என்ன?',
            'answer_ta' => 'BCA ஆண்டு கட்டணம் ரூ 85,000.',
            'keywords' => 'BCA fees, tuition',
            'variations' => "BCA fees evlo\nBCA kattanam enna",
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function ask(string $message, ?string $conversation = null, string $language = 'auto'): array
    {
        return $this->postJson(route('assistant.ask'), ['message' => $message, 'conversation' => $conversation, 'language' => $language])
            ->assertOk()->json();
    }

    protected function geminiPrompt(): string
    {
        $sent = Http::recorded(fn (Request $request): bool => str_contains($request->url(), 'generativelanguage'));

        return (string) json_encode($sent->last()[0]->data(), JSON_UNESCAPED_UNICODE);
    }
}
