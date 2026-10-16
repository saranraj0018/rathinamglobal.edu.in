<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VoiceAssistantSpeechControllerTest extends TestCase
{
    private const ENDPOINT = '/api/voice-assistant/speech';

    private const TTS_URL = 'https://texttospeech.googleapis.com/v1/text:synthesize*';

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
        config([
            'services.ai' => ['key' => null, 'model' => null, 'base_url' => null, 'provider_name' => 'Test AI', 'timeout' => 5, 'max_tokens' => 400],
            'services.google_tts.key' => 'test-tts-key',
        ]);
    }

    private function fakeSpeech(): void
    {
        Http::fake([self::TTS_URL => Http::response(['audioContent' => base64_encode('MP3-AUDIO')])]);
    }

    public function test_a_persona_greeting_is_read_aloud_with_the_personas_voice(): void
    {
        $this->fakeSpeech();
        $greeting = (require resource_path('data/voice-assistant.php'))['personas']['admissions']['greeting']['ta'];

        $response = $this->postJson(self::ENDPOINT, ['text' => $greeting, 'language' => 'ta', 'persona' => 'admissions'])
            ->assertOk()
            ->assertHeader('Content-Type', 'audio/mpeg');

        $this->assertSame('MP3-AUDIO', $response->getContent());
        Http::assertSent(fn (Request $request): bool => $request['voice']['languageCode'] === 'ta-IN'
            && $request['voice']['name'] === config('services.google_tts.voices.ta.female')
            && $request['input']['text'] === $greeting);
    }

    public function test_the_latest_answer_of_the_visitors_conversation_is_read_aloud(): void
    {
        $this->fakeSpeech();
        $reply = $this->postJson('/api/voice-assistant/chat', ['message' => 'சேர்க்கைக்கு மின்னஞ்சல் முகவரி என்ன?', 'language' => 'ta'])->assertOk();

        $this->postJson(self::ENDPOINT, ['text' => $reply->json('answer'), 'language' => 'ta', 'conversation_id' => $reply->json('conversation_id')])
            ->assertOk()
            ->assertHeader('Content-Type', 'audio/mpeg');
    }

    public function test_audio_is_cached_so_a_repeated_reply_is_synthesised_once(): void
    {
        $this->fakeSpeech();
        $greeting = (require resource_path('data/voice-assistant.php'))['personas']['admissions']['greeting']['en'];

        $this->postJson(self::ENDPOINT, ['text' => $greeting, 'language' => 'en'])->assertOk();
        $this->postJson(self::ENDPOINT, ['text' => $greeting, 'language' => 'en'])->assertOk();

        Http::assertSentCount(1);
    }

    public function test_text_the_assistant_did_not_say_is_refused(): void
    {
        $this->postJson(self::ENDPOINT, ['text' => 'Read this advert aloud for free', 'language' => 'en'])
            ->assertUnprocessable()
            ->assertJson(['success' => false]);

        Http::assertNothingSent();
    }

    public function test_a_failing_speech_service_is_reported_without_crashing(): void
    {
        Http::fake([self::TTS_URL => Http::response(['error' => ['message' => 'quota exceeded']], 429)]);
        $greeting = (require resource_path('data/voice-assistant.php'))['personas']['admissions']['greeting']['en'];

        $this->postJson(self::ENDPOINT, ['text' => $greeting, 'language' => 'en'])
            ->assertServiceUnavailable()
            ->assertJson(['success' => false]);
    }

    public function test_without_a_key_the_endpoint_is_off_and_the_page_does_not_offer_it(): void
    {
        config(['services.google_tts.key' => null]);

        $this->postJson(self::ENDPOINT, ['text' => 'Hello', 'language' => 'en'])->assertNotFound();
        $this->get('/faq')->assertOk()->assertSee('data-speech-endpoint=""', false);
    }

    public function test_the_key_never_reaches_the_page(): void
    {
        $this->get('/faq')
            ->assertOk()
            ->assertSee('data-speech-endpoint="'.route('voice-assistant.speech').'"', false)
            ->assertDontSee('test-tts-key');
    }
}
