<?php

namespace App\Services\Assistant;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Server-side fallback for browsers without SpeechRecognition: Google Cloud
 * Speech-to-Text with Tamil (primary for "auto") and Indian English.
 * Audio is sent for recognition and never stored.
 */
class SpeechTranscriptionService
{
    private const ENDPOINT = 'https://speech.googleapis.com/v1/speech:recognize';

    public function __construct(private GoogleAccessToken $google) {}

    public function isConfigured(): bool
    {
        return $this->google->isConfigured();
    }

    /**
     * @param  'ta'|'en'|'auto'  $language
     * @return string the transcript, never empty
     *
     * @throws SpeechServiceException when the service fails or hears nothing
     */
    public function transcribe(UploadedFile $audio, string $language): string
    {
        $codes = match ($language) {
            'en' => ['en-IN', []],
            'ta' => ['ta-IN', ['en-IN']],
            default => ['ta-IN', ['en-IN']],
        };

        $encoding = str_contains((string) $audio->getMimeType(), 'ogg') ? 'OGG_OPUS' : 'WEBM_OPUS';

        try {
            $auth = $this->google->authorization();
            $response = Http::withHeaders($auth['headers'])
                ->withQueryParameters($auth['query'])
                ->acceptJson()
                ->connectTimeout(5)
                ->timeout((int) config('assistant.google.timeout'))
                ->post(self::ENDPOINT, [
                    'config' => [
                        'encoding' => $encoding,
                        'sampleRateHertz' => 48000,
                        'languageCode' => $codes[0],
                        'alternativeLanguageCodes' => $codes[1],
                        'enableAutomaticPunctuation' => true,
                    ],
                    'audio' => ['content' => base64_encode((string) $audio->getContent())],
                ]);
        } catch (Throwable $e) {
            Log::warning('[assistant] transcription unreachable', ['error' => class_basename($e)]);

            throw new SpeechServiceException('Speech recognition is unavailable.', previous: $e);
        }

        if ($response->failed()) {
            Log::warning('[assistant] transcription failed', ['status' => $response->status(), 'message' => mb_substr((string) $response->json('error.message'), 0, 200)]);

            throw new SpeechServiceException('Speech recognition failed.');
        }

        $transcript = trim(collect($response->json('results', []))->map(fn (array $r): string => (string) ($r['alternatives'][0]['transcript'] ?? ''))->implode(' '));

        if ($transcript === '') {
            throw new SpeechServiceException('No speech was recognised.');
        }

        return $transcript;
    }
}
