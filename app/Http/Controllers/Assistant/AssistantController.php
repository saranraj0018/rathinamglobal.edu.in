<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssistantAskRequest;
use App\Http\Requests\AssistantMessageRequest;
use App\Http\Requests\AssistantTranscribeRequest;
use App\Models\AssistantConversation;
use App\Models\AssistantFeedback;
use App\Models\AssistantMessage;
use App\Services\Assistant\AssistantService;
use App\Services\Assistant\SpeechServiceException;
use App\Services\Assistant\SpeechTranscriptionService;
use App\Services\Assistant\TextToSpeechService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Public endpoints of the website assistant. They sit on the web middleware
 * (session + CSRF) so only pages of this site can call them, and every
 * conversation is bound to the visitor's session: another visitor's
 * conversation or message answers 404.
 */
class AssistantController extends Controller
{
    public function ask(AssistantAskRequest $request, AssistantService $assistant): JsonResponse
    {
        $conversation = $request->filled('conversation')
            ? $this->ownedConversation($request, (string) $request->input('conversation'))
            : AssistantConversation::create(['uuid' => (string) Str::uuid(), 'visitor_id' => $this->visitorId($request)]);

        $message = $assistant->ask($conversation, trim($request->string('message')->toString()), $request->input('language', 'auto'));

        return response()->json([
            'success' => true,
            'conversation' => $conversation->uuid,
            'message' => $this->present($message),
        ]);
    }

    public function history(Request $request, string $conversation): JsonResponse
    {
        $conversation = $this->ownedConversation($request, $conversation);

        return response()->json([
            'success' => true,
            'conversation' => $conversation->uuid,
            'messages' => $conversation->messages()->orderBy('id')->get()->map(fn (AssistantMessage $m): array => $this->present($m) + ['question' => $m->user_message])->all(),
        ]);
    }

    public function feedback(AssistantMessageRequest $request): JsonResponse
    {
        $message = $this->ownedMessage($request);

        AssistantFeedback::updateOrCreate(
            ['assistant_message_id' => $message->id],
            ['rating' => (int) $request->input('rating'), 'comment' => $request->input('comment')],
        );

        return response()->json(['success' => true]);
    }

    public function transcribe(AssistantTranscribeRequest $request, SpeechTranscriptionService $transcriber): JsonResponse
    {
        if (! $transcriber->isConfigured()) {
            return response()->json(['success' => false, 'message' => 'Voice transcription is not available. Please type your question.'], 503);
        }

        try {
            $text = $transcriber->transcribe($request->file('audio'), $request->input('language', 'auto'));
        } catch (SpeechServiceException $e) {
            Log::info('[assistant] transcription returned nothing', ['reason' => $e->getMessage()]);

            return response()->json(['success' => false, 'message' => 'I could not understand the audio. Please try again or type your question.'], 422);
        }

        return response()->json(['success' => true, 'text' => $text]);
    }

    public function speak(AssistantMessageRequest $request, TextToSpeechService $speech): Response|JsonResponse
    {
        $message = $this->ownedMessage($request);

        if (! $speech->isConfigured()) {
            return response()->json(['success' => false, 'message' => 'Voice output is not available.'], 503);
        }

        try {
            $audio = $speech->synthesize((string) $message->ai_response, (string) $message->response_language);
        } catch (SpeechServiceException) {
            return response()->json(['success' => false, 'message' => 'Voice output is unavailable right now. You can read the answer instead.'], 503);
        }

        return response($audio, 200, ['Content-Type' => 'audio/mpeg', 'Cache-Control' => 'private, no-store']);
    }

    private function visitorId(Request $request): string
    {
        return $request->session()->remember('assistant_visitor', fn (): string => (string) Str::uuid());
    }

    private function ownedConversation(Request $request, string $uuid): AssistantConversation
    {
        return AssistantConversation::query()
            ->where('uuid', $uuid)
            ->where('visitor_id', $this->visitorId($request))
            ->firstOrFail();
    }

    private function ownedMessage(Request $request): AssistantMessage
    {
        return AssistantMessage::query()
            ->whereKey($request->integer('message_id'))
            ->whereHas('conversation', fn ($q) => $q->where('visitor_id', $this->visitorId($request)))
            ->firstOrFail();
    }

    /**
     * @return array<string, mixed>
     */
    private function present(AssistantMessage $message): array
    {
        return [
            'id' => $message->id,
            'answer' => $message->ai_response,
            'language' => $message->response_language,
            'status' => $message->status,
            'sources' => collect($message->sources ?? [])->map(fn (array $s): array => ['id' => $s['id'], 'title' => $s['title']])->all(),
        ];
    }
}
