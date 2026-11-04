<?php

namespace Tests\Feature\Assistant;

use App\Models\AssistantMessage;
use App\Services\Assistant\TextToSpeechService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class AssistantVoiceTest extends AssistantTestCase
{
    /** Verify the native client accepts the token contract without starting retrieval or contacting Gemini. */
    public function test_native_live_token_contract_matches_the_model_only_client(): void
    {
        config([
            'assistant.gemini_live.key' => 'test-live-key',
            'assistant.gemini_live.model' => 'gemini-3.8-live-extended-thinking',
            'assistant.gemini_live.url' => 'https://generativelanguage.googleapis.com/v1beta',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['name' => 'native-token'])]);

        $this->postJson(route('gemini-live.native-token'))
            ->assertOk()
            ->assertExactJson([
                'token' => 'native-token',
                'model' => 'gemini-3.8-live-extended-thinking',
            ]);
        Http::assertSent(fn (Request $request): bool => $request['uses'] === 1);

        $this->assertContains('web', Route::getRoutes()->getByName('gemini-live.native-token')->gatherMiddleware());
        $disabledKnowledgeRoute = $this->postJson('/api/voice-assistant/live-knowledge', []);
        $this->assertContains($disabledKnowledgeRoute->getStatusCode(), [404, 405]);
        Http::assertSentCount(1);
        $nativeClient = file_get_contents(public_path('js/gemini-live-native.js'));
        $this->assertIsString($nativeClient);
        $this->assertStringNotContainsString('tool_session_id', $nativeClient);
        $this->assertStringNotContainsString('functionDeclarations', $nativeClient);
    }

    public function test_native_live_token_provider_failure_is_returned_as_502(): void
    {
        config([
            'assistant.gemini_live.key' => 'test-live-key',
            'assistant.gemini_live.model' => 'gemini-3.8-live-extended-thinking',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['error' => ['message' => 'temporary failure']], 503)]);

        $this->postJson(route('gemini-live.native-token'))
            ->assertStatus(502)
            ->assertJson(['error' => 'Unable to start the native voice assistant.']);

        Http::assertSentCount(1);
    }

    public function test_native_live_setup_does_not_declare_or_call_knowledge_tools(): void
    {
        $client = file_get_contents(public_path('js/gemini-live-native.js'));

        $this->assertIsString($client);
        $this->assertStringContainsString('MODEL_ONLY_POLICY', $client);
        $this->assertStringContainsString('toolsDeclared: false', $client);
        $this->assertStringNotContainsString('functionDeclarations', $client);
        $this->assertStringNotContainsString('fetchTool(', $client);
        $this->assertStringNotContainsString('tool_session_id', $client);
        // THIS IS NEW CODE — assert the endpoint remains under Laravel's session/CSRF web middleware. Reason: Laravel deliberately bypasses CSRF validation in its testing environment.
        $this->assertContains('web', Route::getRoutes()->getByName('gemini-live.native-token')->gatherMiddleware());
    }

    /** THIS IS NEW CODE — verify one-use Live tokens are restricted to supported models and matching setup modalities without billable audio. Reason: prevent browser setup from drifting from Google token constraints. */
    public function test_live_tokens_are_constrained_to_the_requested_model_and_modality(): void
    {
        config([
            'assistant.gemini_live.key' => 'test-live-key',
            'assistant.gemini_live.model' => 'gemini-3.8-live-extended-thinking',
            'assistant.gemini_live.transcription_model' => 'gemini-3.5-transcribe-live',
        ]);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::sequence()
            ->push(['name' => 'speaker-token'])
            ->push(['name' => 'transcription-token'])]);

        $this->postJson('/api/gemini-live/token', ['purpose' => 'speaker'])
            ->assertOk()
            ->assertJson(['token' => 'speaker-token', 'model' => 'gemini-3.8-live-extended-thinking'])
            ->assertHeaderContains('Cache-Control', 'no-store');
        $this->postJson('/api/gemini-live/token', ['purpose' => 'transcription'])
            ->assertOk()
            ->assertJson(['token' => 'transcription-token', 'model' => 'gemini-3.5-transcribe-live']);

        // OLD CODE — NOT USED NOW: these checks matched the rejected legacy field.
        // Http::assertSent(fn ($request): bool => $request['liveConnectConstraints']['model'] === 'models/gemini-3.8-live');
        // Http::assertSent(fn ($request): bool => $request['liveConnectConstraints']['model'] === 'models/gemini-3.5-transcribe-live'
        //     && $request['liveConnectConstraints']['config']['inputAudioTranscription']['languageCodes'] === []);
        // THIS IS NEW CODE — assert Google's current AuthToken resource shape. Reason: the endpoint's live schema expects bidiGenerateContentSetup, not the legacy wrapper.
        Http::assertSent(fn ($request): bool => $request['uses'] === 1
            && $request['bidiGenerateContentSetup']['model'] === 'models/gemini-3.8-live-extended-thinking'
            && $request['bidiGenerateContentSetup']['generationConfig']['responseModalities'] === ['AUDIO']
            && $request['bidiGenerateContentSetup']['generationConfig']['thinkingConfig']['thinkingLevel'] === 'LOW'
            && $request['bidiGenerateContentSetup']['generationConfig']['speechConfig']['voiceConfig']['prebuiltVoiceConfig']['voiceName'] === 'Aoede'
            && $request['bidiGenerateContentSetup']['systemInstruction']['parts'][0]['text'] === 'You are a speech renderer. Speak the exact text supplied by the client, verbatim. Do not add, remove, or infer any information.'
            && isset($request['bidiGenerateContentSetup']['outputAudioTranscription']));
        Http::assertSent(fn ($request): bool => $request['uses'] === 1
            && $request['bidiGenerateContentSetup']['model'] === 'models/gemini-3.5-transcribe-live'
            && $request['bidiGenerateContentSetup']['generationConfig']['responseModalities'] === ['TEXT']
            && $request['bidiGenerateContentSetup']['inputAudioTranscription']['languageCodes'] === []);
    }

    /** THIS IS NEW CODE — verify browser setup waits for Extended Thinking IDLE and suppresses intermediate speech. Reason: turnComplete alone is not the end of an Extended Thinking interaction. */
    public function test_live_browser_handles_extended_thinking_idle_and_audio_buffering(): void
    {
        $script = file_get_contents(public_path('js/gemini-live.js'));

        $this->assertIsString($script);
        $this->assertStringContainsString("requiresInteractionIdle = model.endsWith('/gemini-3.8-live-extended-thinking')", $script);
        $this->assertStringContainsString("interactionStatus === 'IN_PROGRESS'", $script);
        $this->assertStringContainsString("interactionStatus === 'IDLE'", $script);
        $this->assertStringContainsString('pendingAnswerAudioChunks = []', $script);
        $this->assertStringContainsString("speakerGenerationConfig.thinkingConfig = { thinkingLevel: 'LOW' }", $script);
    }

    /** THIS IS NEW CODE — reject arbitrary Live token purposes without contacting Google. Reason: only issue approved audio and transcription credentials. */
    public function test_live_token_rejects_unknown_purpose_without_provider_request(): void
    {
        config(['assistant.gemini_live.key' => 'test-live-key']);
        Http::fake();

        $this->postJson('/api/gemini-live/token', ['purpose' => 'other'])->assertUnprocessable();
        Http::assertNothingSent();
    }

    /** THIS IS NEW CODE — verify the exact welcome and startup sequence. Reason: a displayed greeting must finish before microphone access or capture starts. */
    public function test_priya_welcome_is_exact_and_spoken_before_microphone_startup(): void
    {
        $persona = require resource_path('data/assistant-personas.php');
        $script = file_get_contents(public_path('js/voice-assistant.js'));

        $this->assertSame('Welcome to Rathinam AI. What information do you need?', $persona['admissions']['greeting']['en']);
        $this->assertSame('ரத்தினம் AI-க்கு வரவேற்கிறோம். உங்களுக்கு என்ன தகவல் தேவை?', $persona['admissions']['greeting']['ta']);
        $this->assertSame('Rathinam AI Assistant', $persona['admissions']['role']['en']);
        $this->assertIsString($script);
        $welcomePosition = strpos($script, 'Welcome to Rathinam AI. What information do you need?');
        $speechWaitPosition = strpos($script, 'await new Promise((resolve, reject) => {', $welcomePosition ?: 0);
        $speechCallbackPosition = strpos($script, 'window.GeminiLive.speak(welcome, onDone)', $welcomePosition ?: 0);
        $nativeWelcomePosition = strpos($script, 'window.GeminiLiveNative.sayWelcome(welcome, onDone)', $welcomePosition ?: 0);
        $microphonePermissionPosition = strpos($script, 'const micError = await requestMicrophone();', $speechWaitPosition ?: 0);
        $microphoneStartPosition = strpos($script, 'await client.startMicrophone();', $microphonePermissionPosition ?: 0);

        $this->assertNotFalse($welcomePosition);
        $this->assertNotFalse($speechWaitPosition);
        $this->assertNotFalse($speechCallbackPosition);
        $this->assertNotFalse($nativeWelcomePosition);
        $this->assertNotFalse($microphonePermissionPosition);
        $this->assertNotFalse($microphoneStartPosition);
        $this->assertTrue($welcomePosition < $speechCallbackPosition);
        $this->assertTrue($welcomePosition < $nativeWelcomePosition);
        $this->assertTrue($speechWaitPosition < $microphonePermissionPosition);
        $this->assertTrue($speechCallbackPosition < $microphonePermissionPosition);
        $this->assertTrue($microphonePermissionPosition < $microphoneStartPosition);
    }

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
