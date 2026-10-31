<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\AssistantConversation;
use App\Models\AssistantMessage;
use App\Services\Assistant\AssistantService;
use App\Services\Assistant\SpeechServiceException;
use App\Services\Assistant\TextToSpeechService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

/**
 * Adapter between the floating widget (public/js/voice-assistant.js, whose
 * markup and request format are unchanged) and the AI assistant backend.
 */
class VoiceWidgetController extends Controller
{
    public function chat(Request $request, AssistantService $assistant): JsonResponse
    {
        abort_unless(config('assistant.enabled'), 404);

        $data = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:'.config('assistant.max_message_length')],
            'language' => ['sometimes', 'in:en,ta'],
            'conversation_id' => ['nullable', 'uuid'],
        ]);

        $conversation = $this->ownedConversation($request, $data['conversation_id'] ?? null)
            ?? AssistantConversation::create(['uuid' => (string) Str::uuid(), 'visitor_id' => $this->visitorId($request)]);

        $message = $assistant->ask($conversation, trim(preg_replace('/[\p{Cc}\p{Cf}]+/u', ' ', $data['message']) ?? $data['message']), $data['language'] ?? 'auto');

        return response()->json([
            'success' => true,
            'answer' => $message->ai_response,
            'conversation_id' => $conversation->uuid,
            'language' => $message->response_language,
            'mode' => $message->status === AssistantMessage::STATUS_ANSWERED ? 'ai' : 'no-match',
            'sources' => [],
            'redirect' => null,
        ])->header('Cache-Control', 'no-store');
    }

    /**
     * Reads one of the assistant's own earlier replies aloud; arbitrary text is refused.
     */
    public function speech(Request $request, TextToSpeechService $speech): Response|JsonResponse
    {
        abort_unless(config('assistant.enabled') && $speech->isConfigured(), 404);

        $data = $request->validate([
            'text' => ['required', 'string', 'max:3000'],
            'language' => ['required', 'in:en,ta'],
            'conversation_id' => ['nullable', 'uuid'],
            'persona' => ['nullable', 'string', 'max:40'],
        ]);

        $conversation = $this->ownedConversation($request, $data['conversation_id'] ?? null);
        $spoken = $conversation?->messages()->where('ai_response', $data['text'])->exists()
            || in_array($data['text'], $this->personaGreetings(), true);

        if (! $spoken) {
            return response()->json(['success' => false, 'message' => 'Only the assistant’s own replies can be read aloud.'], 422);
        }

        $personas = require resource_path('data/assistant-personas.php');
        $gender = ($personas[$data['persona'] ?? '']['voice'] ?? 'female') === 'male' ? 'male' : 'female';

        try {
            $audio = $speech->synthesize($data['text'], $data['language'], $gender);
        } catch (SpeechServiceException) {
            return response()->json(['success' => false, 'message' => 'Speech is unavailable right now.'], 503);
        }

        return response($audio, 200, ['Content-Type' => 'audio/mpeg', 'Cache-Control' => 'no-store']);
    }

    private function visitorId(Request $request): string
    {
        return $request->session()->remember('assistant_visitor', fn (): string => (string) Str::uuid());
    }

    private function ownedConversation(Request $request, ?string $uuid): ?AssistantConversation
    {
        return $uuid === null ? null : AssistantConversation::query()
            ->where('uuid', $uuid)->where('visitor_id', $this->visitorId($request))->first();
    }

    /**
     * @return list<string>
     */
    private function personaGreetings(): array
    {
        return collect(require resource_path('data/assistant-personas.php'))->pluck('greeting')->flatMap(fn (array $g): array => array_values($g))->all();
    }
}
