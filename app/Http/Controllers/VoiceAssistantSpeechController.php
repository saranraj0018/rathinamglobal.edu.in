<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoiceAssistantSpeechRequest;
use App\Services\VoiceAssistant\GoogleTextToSpeech;
use App\Services\VoiceAssistant\KnowledgeBase;
use App\Services\VoiceAssistant\ProviderException;
use App\Services\VoiceAssistant\VoiceAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Reads an assistant reply aloud (POST /api/voice-assistant/speech) for
 * browsers without a voice for the language, typically Tamil on desktops.
 *
 * Only a persona greeting or the latest answer of the visitor's own
 * conversation can be spoken, so the endpoint cannot be used to synthesise
 * arbitrary text on the site's text-to-speech account.
 */
class VoiceAssistantSpeechController extends Controller
{
    public function __invoke(
        VoiceAssistantSpeechRequest $request,
        VoiceAssistant $assistant,
        GoogleTextToSpeech $speech,
        KnowledgeBase $knowledge,
    ): Response|JsonResponse {
        abort_unless(config('rgu.voice_assistant.enabled') && $speech->isConfigured(), 404);

        $text = $request->string('text')->toString();
        $language = $request->string('language')->toString();
        $persona = $request->input('persona');

        if (! $assistant->said($text, $language, $request->input('conversation_id'))) {
            return response()->json(['success' => false, 'message' => 'Only the assistant’s own replies can be read aloud.'], 422);
        }

        $gender = $persona !== null ? $knowledge->personas()[$persona]['voice'] : 'female';

        try {
            $audio = $speech->synthesize($text, $language, $gender);
        } catch (ProviderException $e) {
            Log::warning('[voice-assistant] text-to-speech failed', ['error' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'Speech is unavailable right now.'], 503);
        }

        return response($audio, 200, [
            'Content-Type' => 'audio/mpeg',
            'Cache-Control' => 'no-store',
        ]);
    }
}
