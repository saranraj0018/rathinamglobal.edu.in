<?php

namespace Tests\Feature\Live;

use App\Services\VoiceAssistant\KnowledgeBase;
use App\Support\ContentRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\TestCase;

/**
 * Real Gemini calls. Skipped unless GEMINI_LIVE_TESTS=1, so the normal suite never spends quota:
 *
 *   GEMINI_LIVE_TESTS=1 php artisan test --compact tests/Feature/Live
 *
 * The key is read from AI_API_KEY and never written anywhere; the model can be overridden with
 * GEMINI_LIVE_MODEL. Every request/response (without headers) is written to
 * storage/logs/gemini-live-report.json for review.
 */
class GeminiLiveTest extends TestCase
{
    private const ENDPOINT = '/api/voice-assistant/chat';

    /**
     * @var array<int, array<string, mixed>>
     */
    private static array $calls = [];

    /**
     * @var array<int, array<string, mixed>>
     */
    private static array $scenarios = [];

    private int $startedAt = 0;

    protected function setUp(): void
    {
        parent::setUp();

        if (getenv('GEMINI_LIVE_TESTS') !== '1' || ! filled(env('AI_API_KEY'))) {
            $this->markTestSkipped('Set GEMINI_LIVE_TESTS=1 and AI_API_KEY to run the live Gemini tests.');
        }

        config([
            'services.ai.model' => env('GEMINI_LIVE_MODEL', 'gemini-3.8-flash'),
            'services.ai.max_tokens' => 2048,
            'services.ai.timeout' => 40,
            'rgu.voice_assistant.enabled' => true,
        ]);

        Http::globalRequestMiddleware(function (RequestInterface $request): RequestInterface {
            $body = json_decode((string) $request->getBody(), true) ?: [];
            $request->getBody()->rewind();
            $messages = $body['messages'] ?? [];

            self::$calls[] = [
                'url' => (string) $request->getUri(),
                'model' => $body['model'] ?? null,
                'system_chars' => mb_strlen((string) ($messages[0]['content'] ?? '')),
                'user' => mb_substr((string) (end($messages)['content'] ?? ''), 0, 400),
            ];

            return $request;
        });

        Http::globalResponseMiddleware(function (ResponseInterface $response): ResponseInterface {
            $body = json_decode((string) $response->getBody(), true) ?: [];
            $response->getBody()->rewind();

            self::$calls[array_key_last(self::$calls)] += [
                'status' => $response->getStatusCode(),
                'reply' => mb_substr((string) ($body['choices'][0]['message']['content'] ?? ($body['error']['message'] ?? $body[0]['error']['message'] ?? '')), 0, 600),
                'finish_reason' => $body['choices'][0]['finish_reason'] ?? null,
                'usage' => $body['usage'] ?? null,
            ];

            return $response;
        });

        $this->startedAt = count(self::$calls);
    }

    public static function tearDownAfterClass(): void
    {
        if (self::$calls !== []) {
            file_put_contents(storage_path('logs/gemini-live-report.json'), json_encode(['calls' => self::$calls, 'scenarios' => self::$scenarios], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        parent::tearDownAfterClass();
    }

    /**
     * @return array<string, mixed>
     */
    private function ask(string $message, string $language = 'en', ?string $conversationId = null): array
    {
        $before = count(self::$calls);
        $response = $this->postJson(self::ENDPOINT, array_filter(['message' => $message, 'language' => $language, 'conversation_id' => $conversationId]))->assertOk();

        $result = $response->json() + ['calls' => count(self::$calls) - $before, 'question' => $message];
        self::$scenarios[] = [
            'test' => $this->name(),
            'question' => $message,
            'language' => $language,
            'mode' => $result['mode'],
            'http_calls' => $result['calls'],
            'answer' => $result['answer'],
            'sources' => array_column($result['sources'], 'title'),
            'redirect' => $result['redirect']['key'] ?? null,
        ];

        return $result;
    }

    /**
     * Entry ids the first Gemini call picked in the given range of recorded calls.
     *
     * @return array<int, string>
     */
    private function pickedIds(int $callIndex): array
    {
        preg_match_all('/\d+/', (string) self::$calls[$callIndex]['reply'], $found);
        $entries = app(KnowledgeBase::class)->entries();

        return array_values(array_filter(array_map(fn (string $n): ?string => $entries[(int) $n - 1]['id'] ?? null, $found[0])));
    }

    public function test_the_first_call_selects_the_numbered_fact_and_the_second_answers_from_it(): void
    {
        $first = count(self::$calls);
        $result = $this->ask('Is there wifi in the hostel?');

        $this->assertSame(2, $result['calls']);
        $this->assertSame('ai', $result['mode']);
        $this->assertContains('fact-hostel-wifi', $this->pickedIds($first));
        $this->assertNotEmpty(self::$calls[$first]['usage']);
        $this->assertMatchesRegularExpression('/wi-?fi/i', $result['answer']);
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string}>
     */
    public static function questionsInThreeLanguages(): array
    {
        return [
            'english' => ['What time do the college buses reach the campus?', 'en', 'fact-transport-arrival'],
            'tamil' => ['ஹாஸ்டல்ல வைஃபை இருக்கா?', 'ta', 'fact-hostel-wifi'],
            'tanglish' => ['hostel la wifi irukka', 'en', 'fact-hostel-wifi'],
        ];
    }

    #[DataProvider('questionsInThreeLanguages')]
    public function test_questions_in_english_tamil_and_tanglish_pick_the_right_fact_and_reply_in_kind(string $question, string $language, string $expectedId): void
    {
        $first = count(self::$calls);
        $result = $this->ask($question, $language);

        $this->assertContains($expectedId, $this->pickedIds($first));
        $this->assertSame('ai', $result['mode']);

        if ($language === 'ta') {
            $this->assertMatchesRegularExpression('/\p{Tamil}/u', $result['answer']);
        } else {
            $this->assertDoesNotMatchRegularExpression('/\p{Tamil}/u', $result['answer']);
        }
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function applyRequests(): array
    {
        return [
            'english' => ['I want to apply for B.Tech Mechanical Engineering', 'en'],
            'tamil' => ['நான் பொறியியல் படிப்பில் சேர விரும்புகிறேன்', 'ta'],
            'tanglish' => ['naan engineering la join panna virumburen, apply pannanum', 'en'],
        ];
    }

    #[DataProvider('applyRequests')]
    public function test_apply_intent_is_flagged_and_opens_the_engineering_page(string $question, string $language): void
    {
        $first = count(self::$calls);
        $result = $this->ask($question, $language);

        $this->assertStringContainsStringIgnoringCase('APPLY', (string) self::$calls[$first]['reply']);
        $this->assertSame('https://admissions.rathinamcollege.edu.in/engineering', $result['redirect']['url'] ?? null);
        $this->assertStringNotContainsString('[[', $result['answer']);
    }

    public function test_a_question_with_no_matching_entry_returns_the_contact_without_answer_generation(): void
    {
        $result = $this->ask('Who won the IPL final yesterday?');

        $this->assertSame(1, $result['calls']);
        $this->assertSame('no-match', $result['mode']);
        $this->assertSame([], $result['sources']);
        $this->assertStringContainsString('admission@rathinam.in', $result['answer']);
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function groundedQuestions(): array
    {
        return [
            'bus arrival' => ['What time do buses reach the campus?'],
            'hostel rooms' => ['What types of hostel rooms are there?'],
            'contact' => ['What is the admissions phone number and email?'],
        ];
    }

    #[DataProvider('groundedQuestions')]
    public function test_numbers_in_answers_come_only_from_the_selected_entries(string $question): void
    {
        $first = count(self::$calls);
        $result = $this->ask($question);

        $entries = app(KnowledgeBase::class)->entries();
        $allowed = implode(' ', array_map(fn (string $id): string => collect($entries)->firstWhere('id', $id)['answer'] ?? '', $this->pickedIds($first)))
            .' '.implode(' ', app(KnowledgeBase::class)->contact());

        preg_match_all('/\d[\d:.+\s-]*\d|\d/', $result['answer'], $numbers);
        $digitsAllowed = preg_replace('/\D/', '', $allowed);

        foreach ($numbers[0] as $number) {
            $this->assertStringContainsString(preg_replace('/\D/', '', $number), $digitsAllowed, "Unsupported number [{$number}] in: {$result['answer']}");
        }
    }

    public function test_repeated_question_is_cached_expires_and_is_invalidated_by_content_changes(): void
    {
        $question = 'What time do the buses reach the campus?';

        $this->assertSame(2, $this->ask($question)['calls'], 'cold: pick + answer');
        $this->assertSame(0, $this->ask($question)['calls'], 'warm: answer cache hit, no Gemini call');

        $this->travelTo(Carbon::now()->addMinutes(61));
        $this->assertSame(1, $this->ask($question)['calls'], 'after 1h: answer expired, pick (24h) still cached');
        $this->assertSame(0, $this->ask($question)['calls'], 'answer re-cached');

        $this->travelTo(Carbon::now()->addHours(25));
        $this->assertSame(2, $this->ask($question)['calls'], 'after 25h: both caches expired');
        $this->travelBack();

        $original = app(KnowledgeBase::class)->fingerprint();

        $this->app->bind(ContentRepository::class, fn (): ContentRepository => new class extends ContentRepository
        {
            public function get(string $name): array
            {
                $data = parent::get($name);

                if ($name === 'voice-assistant') {
                    foreach ($data['facts'] as &$fact) {
                        if ($fact['id'] === 'transport-arrival') {
                            $fact['answer'] = 'All buses reach the campus by 9:15 AM.';
                            unset($fact['answer_ta']);
                        }
                    }
                }

                return $data;
            }
        });

        $this->assertNotSame($original, app(KnowledgeBase::class)->fingerprint());

        $updated = $this->ask($question);
        $this->assertSame(2, $updated['calls'], 'edited fact: neither stale cache is served');
        $this->assertStringContainsString('9:15', $updated['answer']);
        $this->assertStringNotContainsString('8:45', $updated['answer']);
    }

    public function test_an_invalid_api_key_returns_the_unavailable_reply_without_leaking_the_key(): void
    {
        config(['services.ai.key' => 'AIzaInvalidKeyForTesting000000000000000']);

        $result = $this->ask('Is there wifi in the hostel?');

        $this->assertSame('unavailable', $result['mode']);
        $this->assertStringContainsString('admission@rathinam.in', $result['answer']);
        $this->assertStringNotContainsString('AIzaInvalidKey', json_encode($result));
        $this->assertContains(self::$calls[array_key_last(self::$calls)]['status'], [400, 401, 403]);
    }

    public function test_an_unknown_model_returns_the_unavailable_reply(): void
    {
        config(['services.ai.model' => 'gemini-1.5-flash']);

        $this->assertSame('unavailable', $this->ask('Is there wifi in the hostel?')['mode']);
        $this->assertSame(404, self::$calls[array_key_last(self::$calls)]['status']);
    }
}
