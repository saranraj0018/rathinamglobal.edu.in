<?php

namespace App\Http\Controllers\Assistant;

use App\Http\Controllers\Controller;
use App\Models\AssistantConversation;
use App\Models\AssistantMessage;
use App\Services\Assistant\AssistantService;
use App\Services\Assistant\GeminiException;
use App\Services\Assistant\SpeechServiceException;
use App\Services\Assistant\TextToSpeechService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Adapter between the floating widget (public/js/voice-assistant.js, whose
 * markup and request format are unchanged) and the AI assistant backend.
 */
class VoiceWidgetController extends Controller
{
    /** THIS IS NEW CODE ΓÇö search only approved Rathinam sources for a native Live tool call. Reason: let Live reason and speak while Laravel supplies concise verified facts. */
    public function liveKnowledge(Request $request, AssistantService $assistant): JsonResponse
    {
        // THIS IS NEW CODE ΓÇö refuse every retrieval-tool request while diagnostic mode is active. Reason: no native Live tool call may reach any data or website source.
        abort_unless(! config('assistant.diagnostic_mode'), 404);

        $providedRequestId = (string) $request->header('X-Assistant-Request-Id', '');
        $requestId = preg_match('/^[a-f0-9-]{36}$/i', $providedRequestId) === 1 ? $providedRequestId : (string) Str::uuid();

        Log::info('[assistant.lifecycle] live_tool_call_received', [
            'request_id' => $requestId,
            'category' => (string) $request->input('category', 'general'),
            'query_length' => mb_strlen((string) $request->input('query', '')),
        ]);

        $data = $request->validate([
            'tool_session_id' => ['required', 'uuid'],
            'tool_call_id' => ['required', 'string', 'max:256'],
            'query' => ['required', 'string', 'min:2', 'max:240'],
            'category' => ['nullable', 'string', 'max:64'],
            'language' => ['nullable', 'string', 'max:16'],
        ]);

        $session = $request->session()->get('assistant_live_tool_session');
        if (! is_array($session) && is_string($data['tool_session_id'] ?? null)) {
            $cachedSession = Cache::get('assistant_live_tool_session_'.$data['tool_session_id']);
            if (is_array($cachedSession)) {
                $session = $cachedSession;
            }
        }
        if (! is_array($session)
            || ! is_string($session['id'] ?? null)
            || ! hash_equals($session['id'], $data['tool_session_id'])
            || (int) ($session['expires_at'] ?? 0) < now()->timestamp) {
            Log::warning('[assistant.lifecycle] live_tool_session_invalid_or_expired', [
                'request_id' => $requestId,
                'session_valid' => is_array($session),
                'session_matched' => is_array($session) && hash_equals($session['id'] ?? '', $data['tool_session_id']),
            ]);

            return response()->json(['status' => 'expired', 'not_found' => true, 'facts' => []], 401);
        }

        $callKey = 'assistant.live-tool-call.'.hash('sha256', $session['id'].'|'.$data['tool_call_id']);
        try {
            $cached = Cache::get($callKey);
            if (is_array($cached) && ($cached['state'] ?? null) === 'complete') {
                return response()->json($cached['result']);
            }
            if (! Cache::add($callKey, ['state' => 'processing'], now()->addMinutes(15))) {
                return response()->json(['status' => 'duplicate', 'not_found' => true, 'facts' => []], 409);
            }
        } catch (\Throwable $exception) {
            Log::warning('[assistant.lifecycle] live_tool_idempotency_unavailable', ['error_type' => class_basename($exception)]);

            return response()->json(['status' => 'unavailable', 'not_found' => true, 'facts' => []], 503);
        }

        try {
            $category = $data['category'] ?? 'general';
            $result = $assistant->searchForLiveTool($data['query'], $requestId);
            $result['query'] = mb_substr($data['query'], 0, 240);
            $result['category'] = $category;
            $result['language'] = $data['language'] ?? 'auto';
            $currentSession = $request->session()->get('assistant_live_tool_session')
                ?: Cache::get('assistant_live_tool_session_'.$data['tool_session_id']);
            if (! is_array($currentSession) || ! hash_equals((string) ($currentSession['id'] ?? ''), $data['tool_session_id'])) {
                Cache::forget($callKey);

                return response()->json(['status' => 'expired', 'not_found' => true, 'facts' => []], 410);
            }

            Cache::put($callKey, ['state' => 'complete', 'result' => $result], now()->addMinutes(15));

            return response()->json($result)->header('Cache-Control', 'no-store');
        } catch (\Throwable $exception) {
            Cache::forget($callKey);
            Log::warning('[assistant.lifecycle] live_tool_call_failed', [
                'request_id' => $requestId,
                'error_type' => class_basename($exception),
            ]);

            return response()->json(['status' => 'unavailable', 'not_found' => true, 'facts' => []], 503);
        }
    }

    /** THIS IS NEW CODE ΓÇö invalidate the session-bound Live tool capability when a call ends. Reason: prevent stale requests from a disconnected Live session. */
    public function endLiveSession(Request $request): JsonResponse
    {
        $data = $request->validate(['tool_session_id' => ['required', 'uuid']]);
        $session = $request->session()->get('assistant_live_tool_session');
        if (is_array($session) && hash_equals((string) ($session['id'] ?? ''), $data['tool_session_id'])) {
            $request->session()->forget('assistant_live_tool_session');
        }
        Cache::forget('assistant_live_tool_session_'.$data['tool_session_id']);

        return response()->json(['success' => true])->header('Cache-Control', 'no-store');
    }

    public function chat(Request $request, AssistantService $assistant): JsonResponse
    {
        // THIS IS NEW CODE ΓÇö correlate safe lifecycle timings without logging the visitor's question.
        $startedAt = hrtime(true);
        $requestId = $this->diagnosticRequestId($request);
        Log::info('[assistant.lifecycle] request_received', ['request_id' => $requestId, 'elapsed_ms' => 0]);
        abort_unless(config('assistant.enabled'), 404);

        $data = $request->validate([
            'message' => ['required', 'string', 'min:2', 'max:'.config('assistant.max_message_length')],
            // THIS IS NEW CODE ΓÇö voice transcripts are auto-detected so Tamil callers aren't forced into the stored UI language.
            'language' => ['sometimes', 'in:auto,en,ta'],
            'conversation_id' => ['nullable', 'uuid'],
        ]);

        // THIS IS NEW CODE ΓÇö pass the unmodified question directly to Gemini without conversation persistence or retrieval. Reason: isolate API-key testing from database and institutional sources.
        if (config('assistant.diagnostic_mode')) {
            try {
                $reply = $assistant->diagnosticAnswer($data['message'], $requestId);

                return response()->json(['success' => true, 'answer' => $reply->text, 'request_id' => $requestId, 'conversation_id' => null, 'language' => $data['language'] ?? 'auto', 'mode' => 'diagnostic', 'sources' => [], 'redirect' => null])->header('Cache-Control', 'no-store')->header('X-Assistant-Request-Id', $requestId);
            } catch (GeminiException $exception) {
                return response()->json(['success' => false, 'message' => 'Gemini diagnostic request failed.', 'reason' => $exception->reason, 'request_id' => $requestId], 503)->header('Cache-Control', 'no-store');
            }
        }

        $conversation = $this->ownedConversation($request, $data['conversation_id'] ?? null)
            ?? AssistantConversation::create(['uuid' => (string) Str::uuid(), 'visitor_id' => $this->visitorId($request)]);

        Log::info('[assistant.lifecycle] request_validated', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt)]);
        // OLD CODE ΓÇö NOT USED NOW: the former assistant call lacked a request ID and monotonic start time.
        // $message = $assistant->ask($conversation, trim(preg_replace('/[\p{Cc}\p{Cf}]+/u', ' ', $data['message']) ?? $data['message']), $data['language'] ?? 'auto');
        $message = $assistant->ask($conversation, trim(preg_replace('/[\p{Cc}\p{Cf}]+/u', ' ', $data['message']) ?? $data['message']), $data['language'] ?? 'auto', $requestId, $startedAt);

        // THIS IS NEW CODE ΓÇö record the final HTTP outcome alongside the stored answer status.
        Log::info('[assistant.lifecycle] response_ready', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'http_status' => 200, 'status' => $message->status]);

        return response()->json([
            'success' => true,
            'answer' => $message->ai_response,
            // THIS IS NEW CODE ΓÇö return the correlation ID so browser and Laravel timings can be matched.
            'request_id' => $requestId,
            'conversation_id' => $conversation->uuid,
            'language' => $message->response_language,
            'mode' => $message->status === AssistantMessage::STATUS_ANSWERED ? 'ai' : 'no-match',
            'sources' => [],
            'redirect' => null,
        ])->header('Cache-Control', 'no-store')->header('X-Assistant-Request-Id', $requestId);
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

    /** THIS IS NEW CODE ΓÇö accept only UUID-shaped diagnostic IDs; never log arbitrary header contents. */
    private function diagnosticRequestId(Request $request): string
    {
        $provided = (string) $request->header('X-Assistant-Request-Id', '');

        return preg_match('/^[a-f0-9-]{36}$/i', $provided) === 1 ? $provided : (string) Str::uuid();
    }

    /** THIS IS NEW CODE ΓÇö report elapsed request time without recording request content. */
    private function elapsedMs(int $startedAt): int
    {
        return (int) ((hrtime(true) - $startedAt) / 1_000_000);
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
