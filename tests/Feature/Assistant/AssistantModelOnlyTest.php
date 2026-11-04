<?php

namespace Tests\Feature\Assistant;

use App\Services\Assistant\HostelTransportKnowledgeService;
use App\Services\Assistant\KnowledgeSearchService;
use App\Services\Assistant\OfficialWebsiteSearchService;
use App\Services\Assistant\StaticKnowledgeSearchService;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Mockery;

class AssistantModelOnlyTest extends AssistantTestCase
{
    public function test_every_query_uses_only_gemini_and_never_calls_retrieval_services(): void
    {
        foreach ([
            KnowledgeSearchService::class,
            StaticKnowledgeSearchService::class,
            OfficialWebsiteSearchService::class,
            HostelTransportKnowledgeService::class,
        ] as $serviceClass) {
            $retrieval = Mockery::mock($serviceClass);
            $retrieval->shouldNotReceive('search');
            $this->instance($serviceClass, $retrieval);
        }

        Http::fake(['generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [['content' => ['parts' => [['text' => 'Here is a model generated answer.']]]]],
        ])]);

        $first = $this->postJson(route('assistant.ask'), ['message' => 'Explain how neural networks learn.'])
            ->assertOk()->json();
        $conversation = $first['conversation'];

        foreach ([
            'What are Rathinam hostel facilities?',
            'What is the latest BCA fee at RGU?',
            'Hostel fees pathi sollunga',
        ] as $question) {
            $this->postJson(route('assistant.ask'), ['message' => $question, 'conversation' => $conversation])->assertOk();
        }

        $requests = Http::recorded(fn (Request $request): bool => str_contains($request->url(), 'generativelanguage'));
        $this->assertCount(4, $requests);
        foreach ($requests as [$request]) {
            $this->assertStringContainsString('built-in model knowledge', json_encode($request->data(), JSON_UNESCAPED_UNICODE));
            $this->assertArrayNotHasKey('tools', $request->data());
        }
        Http::assertSentCount(4);
        $this->assertDatabaseCount('assistant_messages', 4);
    }

    public function test_follow_up_context_is_sent_without_external_knowledge(): void
    {
        Http::fake(['generativelanguage.googleapis.com/*' => Http::sequence()
            ->push(['candidates' => [['content' => ['parts' => [['text' => 'A general explanation.']]]]]])
            ->push(['candidates' => [['content' => ['parts' => [['text' => 'A follow-up answer.']]]]]])]);

        $first = $this->postJson(route('assistant.ask'), ['message' => 'What is machine learning?'])->assertOk()->json();
        $this->postJson(route('assistant.ask'), ['message' => 'Can you give an example?', 'conversation' => $first['conversation']])->assertOk();

        $requests = Http::recorded(fn (Request $request): bool => str_contains($request->url(), 'generativelanguage'));
        $followUpPayload = $requests->last()[0]->data();
        $this->assertStringContainsString('What is machine learning?', json_encode($followUpPayload));
        $this->assertStringContainsString('A general explanation.', json_encode($followUpPayload));
        $this->assertStringContainsString('Can you give an example?', json_encode($followUpPayload));
        $this->assertArrayNotHasKey('tools', $followUpPayload);
        Http::assertSentCount(2);
    }

    public function test_native_live_knowledge_endpoint_is_not_registered(): void
    {
        $response = $this->postJson('/api/voice-assistant/live-knowledge', []);
        $this->assertContains($response->getStatusCode(), [404, 405]);
    }
}
