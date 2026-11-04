<?php

namespace Tests\Feature\Assistant;

use Illuminate\Support\Facades\Http;

class NativeLiveArchitectureTest extends AssistantTestCase
{
    public function test_native_live_preloads_all_approved_faqs_without_declaring_tools(): void
    {
        config([
            'assistant.gemini_live.key' => 'test-live-key',
            'assistant.gemini_live.model' => 'gemini-3.8-live-extended-thinking',
            'assistant.gemini_live.url' => 'https://generativelanguage.googleapis.com/v1beta',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['name' => 'native-token'])]);

        $response = $this->postJson(route('gemini-live.native-token'))->assertOk();

        $this->assertSame(30, substr_count((string) $response->json('knowledge_context'), 'Verified answer:'));
        $this->assertSame('native-token', $response->json('token'));
        $this->assertArrayNotHasKey('tools', $response->json());
        $nativeClient = file_get_contents(public_path('js/gemini-live-native.js'));
        $this->assertIsString($nativeClient);
        $this->assertStringNotContainsString('functionDeclarations', $nativeClient);
        $this->assertStringNotContainsString('/api/voice-assistant/live-knowledge', $nativeClient);
        Http::assertSentCount(1);
    }

    public function test_legacy_live_knowledge_tool_endpoint_is_not_registered(): void
    {
        $response = $this->postJson('/api/voice-assistant/live-knowledge', []);
        $this->assertSame(405, $response->getStatusCode());
    }
}
