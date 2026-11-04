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

    /** Compute elapsed time for native Live token diagnostics. */
    private function elapsedMs(int $startedAt): int
    {
        return (int) ((hrtime(true) - $startedAt) / 1_000_000);
    }
}
