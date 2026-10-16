<?php

namespace App\Services\VoiceAssistant;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * Spoken answers from Google Cloud Text-to-Speech, for browsers that have no
 * voice of their own for a language (most desktop browsers have no Tamil
 * voice). Only assistant replies are ever sent, never what the visitor said.
 *
 * Audio is cached by voice and text, so repeated replies such as the persona
 * greetings are synthesised (and billed) once.
 */
class GoogleTextToSpeech
{
    private const ENDPOINT = 'https://texttospeech.googleapis.com/v1/text:synthesize';

    private const LANGUAGE_CODES = ['en' => 'en-IN', 'ta' => 'ta-IN'];

    /**
     * @param  array<string, array{female: string, male: string}>  $voices  language => gender => Google voice name
     */
    public function __construct(
        private ?string $apiKey,
        private array $voices,
        private Cache $cache,
        private int $timeout = 15,
        private int $cacheSeconds = 86400,
    ) {}

    public function isConfigured(): bool
    {
        return filled($this->apiKey);
    }

    /**
     * MP3 audio of the text read in the language, with a voice of the requested gender.
     *
     * @param  'female'|'male'  $gender
     *
     * @throws ProviderException when the service is not configured or fails
     */
    public function synthesize(string $text, string $language, string $gender = 'female'): string
    {
        if (! $this->isConfigured()) {
            throw new ProviderException('Text-to-speech is not configured.');
        }

        $voice = $this->voices[$language][$gender] ?? null;

        if ($voice === null || ! isset(self::LANGUAGE_CODES[$language])) {
            throw new ProviderException("No text-to-speech voice is configured for [{$language}].");
        }

        $cacheKey = 'voice-assistant:speech:'.sha1($voice."\n".$text);
        $cached = $this->cache->get($cacheKey);

        if (is_string($cached)) {
            return base64_decode($cached);
        }

        try {
            $response = Http::acceptJson()
                ->connectTimeout(5)
                ->timeout($this->timeout)
                ->withQueryParameters(['key' => $this->apiKey])
                ->post(self::ENDPOINT, [
                    'input' => ['text' => $text],
                    'voice' => ['languageCode' => self::LANGUAGE_CODES[$language], 'name' => $voice],
                    'audioConfig' => ['audioEncoding' => 'MP3'],
                ]);
        } catch (ConnectionException $e) {
            throw new ProviderException('Text-to-speech unreachable: '.$e->getMessage(), previous: $e);
        }

        if ($response->failed()) {
            // The error body never echoes the key; it is trimmed so a long payload cannot flood the log.
            throw new ProviderException(sprintf(
                'Text-to-speech returned HTTP %d: %s',
                $response->status(),
                mb_substr((string) ($response->json('error.message') ?? $response->body()), 0, 300),
            ));
        }

        $audio = $response->json('audioContent');

        if (! is_string($audio) || $audio === '') {
            throw new ProviderException('Text-to-speech returned no audio.');
        }

        $this->cache->put($cacheKey, $audio, $this->cacheSeconds);

        return base64_decode($audio);
    }
}
