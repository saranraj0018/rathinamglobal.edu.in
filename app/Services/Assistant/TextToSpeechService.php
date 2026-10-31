<?php

namespace App\Services\Assistant;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Natural Tamil and English speech from Google Cloud Text-to-Speech.
 * Audio is cached by voice, rate and text so repeated answers are billed once.
 */
class TextToSpeechService
{
    private const ENDPOINT = 'https://texttospeech.googleapis.com/v1/text:synthesize';

    public function __construct(private GoogleAccessToken $google) {}

    public function isConfigured(): bool
    {
        return $this->google->isConfigured();
    }

    /**
     * Romanised Tamil read by a Tamil voice is mangled, so text that is mostly
     * Latin letters is always spoken by the English voice.
     */
    public function voiceLanguageFor(string $text, string $requested): string
    {
        if ($requested !== 'ta') {
            return 'en';
        }

        $letters = preg_match_all('/\p{L}/u', $text);
        $tamil = preg_match_all('/\p{Tamil}/u', $text);

        return $letters > 0 && $tamil / $letters >= (float) config('assistant.tts.min_tamil_ratio') ? 'ta' : 'en';
    }

    /**
     * MP3 audio of the text.
     *
     * @throws SpeechServiceException
     */
    public function synthesize(string $text, string $language): string
    {
        $text = $this->plainText($text);
        $voice = config('assistant.tts.voices.'.$this->voiceLanguageFor($text, $language));
        $rate = (float) config('assistant.tts.speaking_rate');
        $cacheKey = 'assistant:tts:'.sha1($voice['name'].'|'.$rate.'|'.$text);

        if (is_string($cached = Cache::get($cacheKey))) {
            return base64_decode($cached);
        }

        try {
            $auth = $this->google->authorization();
            $response = Http::withHeaders($auth['headers'])
                ->withQueryParameters($auth['query'])
                ->acceptJson()
                ->connectTimeout(5)
                ->timeout((int) config('assistant.google.timeout'))
                ->post(self::ENDPOINT, [
                    'input' => ['text' => mb_substr($text, 0, (int) config('assistant.tts.max_characters'))],
                    'voice' => ['languageCode' => $voice['language_code'], 'name' => $voice['name']],
                    'audioConfig' => ['audioEncoding' => 'MP3', 'speakingRate' => $rate, 'pitch' => (float) config('assistant.tts.pitch')],
                ]);
        } catch (Throwable $e) {
            Log::warning('[assistant] text-to-speech error', ['error' => class_basename($e)]);

            throw new SpeechServiceException('Text-to-speech is unavailable.', previous: $e);
        }

        $audio = $response->json('audioContent');

        if ($response->failed() || ! is_string($audio) || $audio === '') {
            Log::warning('[assistant] text-to-speech failed', ['status' => $response->status(), 'message' => mb_substr((string) $response->json('error.message'), 0, 200)]);

            throw new SpeechServiceException('Text-to-speech failed.');
        }

        Cache::put($cacheKey, $audio, (int) config('assistant.tts.cache_seconds'));

        return base64_decode($audio);
    }

    private function plainText(string $text): string
    {
        return trim(preg_replace('/[*_#`>]+|\s+/u', ' ', $text) ?? $text);
    }
}
