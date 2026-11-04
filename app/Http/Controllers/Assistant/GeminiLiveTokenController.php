<?php

namespace App\Http\Controllers\Assistant;

/** THIS IS NEW CODE — provision short-lived browser tokens without exposing the permanent key. Reason: secure Gemini Live WebSocket setup. */

use App\Services\Assistant\HostelTransportKnowledgeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiLiveTokenController
{
    /** Issue a one-use token and the approved facts for one native Live session. */
    public function native(Request $request, HostelTransportKnowledgeService $knowledge): JsonResponse
    {
        $startedAt = hrtime(true);
        // THIS IS NEW CODE — accept only UUID-shaped browser correlation IDs. Reason: match safe frontend lifecycle diagnostics without logging user content.
        $providedId = (string) $request->header('X-Assistant-Request-Id', '');
        $requestId = preg_match('/^[a-f0-9-]{36}$/i', $providedId) === 1 ? $providedId : (string) Str::uuid();
        $key = config('assistant.gemini_live.key');
        $model = (string) config('assistant.gemini_live.model');
        $url = (string) config('assistant.gemini_live.url');
        if ($key === '' || $model === '' || $url === '') {
            return response()->json(['error' => 'Gemini Live is not configured.'], 503);
        }

        $knowledgeStartedAt = hrtime(true);
        $knowledgeContext = $knowledge->liveSessionContext();
        $knowledgeLoadMs = (int) round((hrtime(true) - $knowledgeStartedAt) / 1_000_000);
        if ($knowledgeContext === '') {
            Log::error('[assistant.lifecycle] live_native_knowledge_unavailable', [
                'request_id' => $requestId,
                'knowledge_load_ms' => $knowledgeLoadMs,
            ]);

            return response()->json(['error' => 'Verified voice assistant information is unavailable.'], 503);
        }

        try {
            $response = Http::connectTimeout(3)->timeout((int) config('assistant.gemini_live.token_timeout', 8))
                ->withHeaders(['x-goog-api-key' => $key])
                ->post(rtrim($url, '/').'/auth_tokens', [
                    'uses' => 1,
                    'newSessionExpireTime' => now()->addMinute()->toIso8601String(),
                    'expireTime' => now()->addMinutes(15)->toIso8601String(),
                ]);

            if (! $response->successful() || ! is_string($response->json('name'))) {
                Log::warning('[assistant.lifecycle] live_native_token_failed', [
                    'request_id' => $requestId,
                    'elapsed_ms' => $this->elapsedMs($startedAt),
                    'http_status' => $response->status(),
                    'upstream_status' => $response->json('error.status'),
                    'upstream_message' => mb_substr((string) $response->json('error.message', ''), 0, 200),
                ]);

                return response()->json(['error' => 'Unable to start the native voice assistant.'], 502);
            }

            Log::info('[assistant.lifecycle] live_native_token_ready', [
                'request_id' => $requestId,
                'elapsed_ms' => $this->elapsedMs($startedAt),
                'knowledge_load_ms' => $knowledgeLoadMs,
                'knowledge_characters' => mb_strlen($knowledgeContext),
                'model' => $model,
            ]);

            return response()->json([
                'token' => $response->json('name'),
                'model' => $model,
                'knowledge_context' => $knowledgeContext,
                'knowledge_load_ms' => $knowledgeLoadMs,
            ])->header('Cache-Control', 'no-store');
        } catch (\Throwable $exception) {
            Log::warning('[assistant.lifecycle] live_native_token_error', [
                'request_id' => $requestId,
                'elapsed_ms' => $this->elapsedMs($startedAt),
                'error_type' => class_basename($exception),
            ]);

            return response()->json(['error' => 'Unable to start the native voice assistant.'], 502);
        }
    }

    // THIS IS NEW CODE — time token provisioning with the browser session ID while keeping the returned token private.
    public function __invoke(Request $request): JsonResponse
    {
        $startedAt = hrtime(true);
        $providedId = (string) $request->header('X-Assistant-Request-Id', '');
        $requestId = preg_match('/^[a-f0-9-]{36}$/i', $providedId) === 1 ? $providedId : (string) Str::uuid();
        Log::info('[assistant.lifecycle] live_token_requested', ['request_id' => $requestId, 'elapsed_ms' => 0]);
        $key = config('assistant.gemini_live.key');
        $purpose = $request->string('purpose')->toString();
        $isTranscription = $purpose === 'transcription';
        $model = config($isTranscription ? 'assistant.gemini_live.transcription_model' : 'assistant.gemini_live.model');
        $url = config('assistant.gemini_live.url');

        // Check Gemini Live configuration
        if (empty($key) || empty($model) || empty($url)) {
            Log::warning('[assistant.lifecycle] live_token_not_configured', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt)]);

            return response()->json([
                'error' => 'Gemini Live is not configured.',
            ], 503);
        }

        if (! in_array($purpose, ['speaker', 'transcription'], true)) {
            return response()->json(['error' => 'Invalid Gemini Live token purpose.'], 422);
        }

        $liveModel = str_starts_with($model, 'models/') ? $model : "models/{$model}";
        // OLD CODE — NOT USED NOW: the previous Live config used responseModalities directly at the config root.
        // $liveConfig = $isTranscription
        //     ? ['responseModalities' => ['TEXT'], 'inputAudioTranscription' => ['languageCodes' => []]]
        //     : ['responseModalities' => ['AUDIO']];
        // OLD CODE — NOT USED NOW: Google rejected this legacy AuthToken field with INVALID_ARGUMENT / unknown field.
        // 'liveConnectConstraints' => ['model' => $liveModel, 'config' => $liveConfig],
        // THIS IS NEW CODE — build the BidiGenerateContent setup expected by the live endpoint. Reason: the deployed AuthToken schema rejected the legacy liveConnectConstraints field.
        // OLD CODE — NOT USED NOW: the prior token constraint locked only the model and output modality, which could cause the service to ignore browser speech/system settings.
        // $liveSetup = [
        //     'model' => $liveModel,
        //     'generationConfig' => ['responseModalities' => [$isTranscription ? 'TEXT' : 'AUDIO']],
        // ];
        // THIS IS NEW CODE — keep the complete speaker setup in the constrained token so server and browser use the same protocol settings.
        $liveSetup = [
            'model' => $liveModel,
            'generationConfig' => ['responseModalities' => [$isTranscription ? 'TEXT' : 'AUDIO']],
        ];
        if ($isTranscription) {
            $liveSetup['inputAudioTranscription'] = ['languageCodes' => []];
        } else {
            // THIS IS NEW CODE — lock the speaker token to the same audio, voice, and exact-text behavior as the browser setup. Reason: AuthToken setup constraints supersede the WebSocket setup when fieldMask is omitted.
            $liveSetup['generationConfig']['speechConfig'] = [
                'voiceConfig' => ['prebuiltVoiceConfig' => ['voiceName' => 'Aoede']],
            ];
            if (str_ends_with($model, '-extended-thinking')) {
                $liveSetup['generationConfig']['thinkingConfig'] = ['thinkingLevel' => 'LOW'];
            }
            $liveSetup['systemInstruction'] = [
                'parts' => [['text' => 'You are a speech renderer. Speak the exact text supplied by the client, verbatim. Do not add, remove, or infer any information.']],
            ];
            $liveSetup['outputAudioTranscription'] = new \stdClass;
        }

        try {
            // Request a temporary Gemini Live token
            $response = Http::connectTimeout(3)->timeout((int) config('assistant.gemini_live.token_timeout', 8))
                ->withHeaders([
                    'x-goog-api-key' => $key,
                ])
                ->post(rtrim($url, '/').'/auth_tokens', [
                    'uses' => 1,
                    'bidiGenerateContentSetup' => $liveSetup,
                ]);

            // Handle Google API errors
            if (! $response->successful() || ! $response->json('name')) {
                // THIS IS NEW CODE — record allow-listed upstream fields with the key redacted. Reason: identify API rejections without leaking credentials or response payloads.
                $upstreamError = $response->json('error', []);
                $upstreamMessage = is_array($upstreamError) ? (string) ($upstreamError['message'] ?? '') : '';
                $safeUpstreamMessage = mb_substr(str_replace($key, '[redacted]', $upstreamMessage), 0, 240);
                Log::warning('[assistant.lifecycle] live_token_failed', [
                    'request_id' => $requestId,
                    'elapsed_ms' => $this->elapsedMs($startedAt),
                    'http_status' => $response->status(),
                    'upstream_code' => is_array($upstreamError) ? ($upstreamError['code'] ?? null) : null,
                    'upstream_status' => is_array($upstreamError) ? ($upstreamError['status'] ?? null) : null,
                    'upstream_message' => $safeUpstreamMessage,
                ]);

                return response()->json([
                    'error' => 'Unable to start voice assistant.',
                ], 502);
            }

            // Return temporary token to frontend
            Log::info('[assistant.lifecycle] live_token_ready', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'http_status' => $response->status()]);

            return response()->json([
                'token' => $response->json('name'),
                'model' => $model,
            ])->header('Cache-Control', 'no-store')->header('X-Assistant-Request-Id', $requestId);

        } catch (\Throwable $e) {

            Log::error('[assistant.lifecycle] live_token_error', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'error_type' => class_basename($e)]);

            return response()->json([
                'error' => 'Unable to start voice assistant.',
            ], 502);
        }
    }

    /** THIS IS NEW CODE — compute monotonic timings for correlated token logs. */
    private function elapsedMs(int $startedAt): int
    {
        return (int) ((hrtime(true) - $startedAt) / 1_000_000);
    }
}
