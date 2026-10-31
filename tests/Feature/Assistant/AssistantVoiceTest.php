<?php

namespace Tests\Feature\Assistant;

use App\Models\AssistantMessage;
use App\Services\Assistant\TextToSpeechService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class AssistantVoiceTest extends AssistantTestCase
{
    private function answeredMessage(string $language = 'en', string $text = 'The BCA fee is Rs 85,000.'): int
    {
        $this->bcaFeeFaq();
        $this->fakeGemini($text);
        $id = $this->ask('BCA fee?', language: $language)['message']['id'];

        return $id;
    }

    private function audio(): UploadedFile
    {
        return UploadedFile::fake()->create('speech.webm', 20, 'audio/webm');
    }

    public function test_transcription_returns_the_recognised_text(): void
    {
        Http::fake(['speech.googleapis.com/*' => Http::response(['results' => [['alternatives' => [['transcript' => 'BCA கட்டணம் என்ன']]]]])]);

        $this->post(route('assistant.transcribe'), ['audio' => $this->audio(), 'language' => 'ta'], ['Accept' => 'application/json'])
            ->assertOk()->assertJson(['success' => true, 'text' => 'BCA கட்டணம் என்ன']);
    }

    public function test_silence_and_recognition_failures_return_a_friendly_error(): void
    {
        Http::fake(['speech.googleapis.com/*' => Http::response(['results' => []])]);
        $this->post(route('assistant.transcribe'), ['audio' => $this->audio(), 'language' => 'en'], ['Accept' => 'application/json'])
            ->assertStatus(422)->assertJson(['success' => false]);

        Http::fake(['speech.googleapis.com/*' => Http::response(['error' => ['message' => 'bad']], 500)]);
        $this->post(route('assistant.transcribe'), ['audio' => $this->audio()], ['Accept' => 'application/json'])
            ->assertStatus(422)->assertJson(['success' => false]);
    }

    public function test_missing_or_invalid_audio_is_rejected(): void
    {
        $this->post(route('assistant.transcribe'), [], ['Accept' => 'application/json'])->assertUnprocessable();
        $this->post(route('assistant.transcribe'), ['audio' => UploadedFile::fake()->create('x.exe', 5, 'application/x-msdownload')], ['Accept' => 'application/json'])->assertUnprocessable();
    }

    public function test_transcription_reports_when_no_provider_is_configured(): void
    {
        config(['assistant.google.api_key' => null]);

        $this->post(route('assistant.transcribe'), ['audio' => $this->audio()], ['Accept' => 'application/json'])->assertStatus(503);
    }

    public function test_spoken_reply_uses_the_voice_for_the_answer_language(): void
    {
        $id = $this->answeredMessage();
        Http::fake(['texttospeech.googleapis.com/*' => Http::response(['audioContent' => base64_encode('MP3DATA')])]);

        $this->postJson(route('assistant.speak'), ['message_id' => $id])
            ->assertOk()->assertHeader('Content-Type', 'audio/mpeg');

        Http::assertSent(fn ($request) => $request['voice']['languageCode'] === 'en-IN' && $request['audioConfig']['speakingRate'] === 1.0);
    }

    public function test_tamil_answers_use_the_tamil_voice_and_are_cached(): void
    {
        $id = $this->answeredMessage('ta', 'BCA ஆண்டு கட்டணம் ரூ 85,000.');
        Http::fake(['texttospeech.googleapis.com/*' => Http::response(['audioContent' => base64_encode('MP3DATA')])]);

        $this->postJson(route('assistant.speak'), ['message_id' => $id])->assertOk();
        $this->postJson(route('assistant.speak'), ['message_id' => $id])->assertOk();

        Http::assertSentCount(1);
        Http::assertSent(fn ($request) => $request['voice']['languageCode'] === 'ta-IN');
    }

    public function test_romanised_tamil_is_never_sent_to_the_tamil_voice(): void
    {
        $speech = app(TextToSpeechService::class);

        $this->assertSame('en', $speech->voiceLanguageFor('BCA kattanam Rs 85,000 per year', 'ta'));
        $this->assertSame('ta', $speech->voiceLanguageFor('BCA கட்டணம் ரூ 85,000', 'ta'));
        $this->assertSame('en', $speech->voiceLanguageFor('Hello', 'en'));
    }

    public function test_voice_generation_failure_is_reported_safely(): void
    {
        $id = $this->answeredMessage();
        Http::fake(['texttospeech.googleapis.com/*' => Http::response(['error' => ['message' => 'quota']], 500)]);

        $this->postJson(route('assistant.speak'), ['message_id' => $id])
            ->assertStatus(503)->assertJson(['success' => false])->assertJsonMissing(['quota']);

        Http::fake(fn () => throw new ConnectionException('timeout'));
        $this->postJson(route('assistant.speak'), ['message_id' => $id])->assertStatus(503);
    }

    public function test_voice_output_is_unavailable_without_credentials(): void
    {
        $id = $this->answeredMessage();
        config(['assistant.google.api_key' => null]);

        $this->postJson(route('assistant.speak'), ['message_id' => $id])->assertStatus(503);
        $this->assertSame(1, AssistantMessage::count());
    }
}
