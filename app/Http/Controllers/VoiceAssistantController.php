<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoiceAssistantChatRequest;
use App\Services\VoiceAssistant\ConversationBusyException;
use App\Services\VoiceAssistant\VoiceAssistant;
use Illuminate\Http\JsonResponse;

/**
 * Website voice assistant (POST /api/voice-assistant/chat).
 *
 * Speech recognition and text-to-speech run in the visitor's browser; only
 * the question text reaches this endpoint. Public content only — the
 * assistant has no access to accounts, forms or any private data.
 */
class VoiceAssistantController extends Controller
{
    public function __invoke(VoiceAssistantChatRequest $request, VoiceAssistant $assistant): JsonResponse
    {
        abort_unless(config('rgu.voice_assistant.enabled'), 404);

        try {
            $reply = $assistant->reply(
                $request->string('message')->toString(),
                $request->string('language', 'en')->toString(),
                $request->input('conversation_id'),
                $request->input('persona'),
            );
        } catch (ConversationBusyException) {
            return $this->reply(['success' => false, 'message' => 'Still answering your previous question. Please wait a moment.'], 409);
        }

        return $this->reply(['success' => true, ...$reply]);
    }

    /**
     * @param  array<string, mixed>  $body
     */
    private function reply(array $body, int $status = 200): JsonResponse
    {
        return response()->json($body, $status)->header('Cache-Control', 'no-store');
    }
}
