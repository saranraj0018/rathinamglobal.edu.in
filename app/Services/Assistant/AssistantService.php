<?php

namespace App\Services\Assistant;

use App\Models\AssistantConversation;
use App\Models\AssistantMessage;
use App\Models\AssistantSetting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/** THIS IS NEW CODE ΓÇö support general answers alongside verified Rathinam facts. Reason: general questions should not require an institution retrieval match. */
class AssistantService
{
    public function __construct(
        private TextNormalizer $normalizer,
        private KnowledgeSearchService $search,
        // THIS IS NEW CODE ΓÇö search approved resources/data files when the index is unavailable or empty.
        private StaticKnowledgeSearchService $staticSearch,
        // THIS IS NEW CODE ΓÇö retrieve official site content separately from indexed knowledge.
        private OfficialWebsiteSearchService $websiteSearch,
        private PromptBuilderService $prompts,
        private GeminiService $gemini,
        private ?HostelTransportKnowledgeService $hostelTransportKnowledge = null,
    ) {
        $this->hostelTransportKnowledge ??= app(HostelTransportKnowledgeService::class);
    }

    /** THIS IS NEW CODE ΓÇö send the untouched question directly to Gemini without touching application data. Reason: isolate the configured API key/model for temporary diagnostic testing. */
    public function diagnosticAnswer(string $question, ?string $requestId = null): GeminiResponse
    {
        $requestId ??= (string) Str::uuid();
        $prompt = 'You are a general assistant in temporary API-key diagnostic mode. Answer from your own general knowledge only. Do not claim to have looked up Rathinam facts or consulted any database, website, FAQ, document, or other source. If asked about Rathinam, be clear that you have not verified institution-specific information.';

        return $this->gemini->generate($prompt, [['role' => 'user', 'text' => $question]], $requestId);
    }

    /**
     * @param  'auto'|'ta'|'en'  $languagePreference
     */
    // OLD CODE ΓÇö NOT USED NOW: this signature could not connect browser and server lifecycle logs.
    // public function ask(AssistantConversation $conversation, string $question, string $languagePreference = 'auto'): AssistantMessage
    // THIS IS NEW CODE ΓÇö propagate a safe correlation ID and monotonic start time through every backend stage.
    public function ask(AssistantConversation $conversation, string $question, string $languagePreference = 'auto', ?string $requestId = null, ?int $startedAt = null): AssistantMessage
    {
        $requestId ??= (string) Str::uuid();
        $startedAt ??= hrtime(true);
        $detected = $this->normalizer->detectLanguage($question);
        $language = $this->responseLanguage($detected, $languagePreference);
        $contact = AssistantSetting::valueOf('admissions_contact', config('assistant.messages.default_contact'));
        $history = $conversation->messages()->whereNotNull('ai_response')->latest('id')
            ->limit(max(1, intdiv((int) config('assistant.max_context_messages'), 2)))->get()->reverse()->values();

        $record = [
            'assistant_conversation_id' => $conversation->id,
            'user_message' => $question,
            'detected_language' => $detected,
            'response_language' => $language,
        ];

        if ($this->normalizer->isGreeting($question)) {
            return AssistantMessage::create($record + [
                'ai_response' => config("assistant.messages.greeting.{$language}"),
                'status' => AssistantMessage::STATUS_ANSWERED,
            ]);
        }

        $retrievalQuestion = $this->rathinamRetrievalQuestion($question);
        $searchQuery = $retrievalQuestion !== '' ? $retrievalQuestion : $question;
        $chunks = $this->retrieve($searchQuery, $history, $requestId, $startedAt);

        // In hostel-only knowledge mode, bypass live website crawling unless official_website.enabled is explicitly true (e.g. legacy fallback tests)
        if (config('assistant.hostel_only_knowledge', true) && ! config('assistant.official_website.enabled', false)) {
            $websiteChunks = [];
        } else {
            $requiresRathinamFacts = $retrievalQuestion !== '' || $chunks !== [];
            try {
                $websiteStartedAt = hrtime(true);
                $websiteChunks = $requiresRathinamFacts ? $this->websiteSearch->search($searchQuery, $requestId) : [];
                Log::info('[assistant.lifecycle] official_site_retrieval_complete', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'stage_elapsed_ms' => $this->elapsedMs($websiteStartedAt), 'result_count' => count($websiteChunks)]);
            } catch (Throwable $exception) {
                Log::warning('[assistant.lifecycle] official_site_retrieval_failed', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'error_type' => class_basename($exception)]);
                $websiteChunks = [];
            }
        }

        // Prefer database chunks over static data
        $databaseChunks = array_values(array_filter($chunks, fn (RetrievedChunk $chunk): bool => $chunk->sourceType !== 'static_data'));
        $hostelFactsChunk = collect($chunks)->first(fn (RetrievedChunk $chunk): bool => $chunk->title === 'Verified Hostel Facilities');
        if ($websiteChunks !== []) {
            $bestWebsiteScore = max(array_map(fn (RetrievedChunk $chunk): float => $chunk->score, $websiteChunks));
            $websiteChunks = array_values(array_filter($websiteChunks, fn (RetrievedChunk $chunk): bool => $chunk->score >= $bestWebsiteScore * 0.75));
        }

        $allChunks = $databaseChunks !== []
            ? [...$databaseChunks, ...$websiteChunks]
            : ($hostelFactsChunk !== null
                ? [$hostelFactsChunk, ...$websiteChunks]
                : ($websiteChunks !== [] ? $websiteChunks : $chunks));

        $isGeneralEducational = preg_match('/\b(artificial intelligence|ai|machine learning|deep learning|data science|python|programming|coding|cloud computing|neural network|algorithm|technology|tell me a joke|joke|who are you|what can you do|how does the internet work|internet|computer|science|software)\b|α««α»åα«╖α«┐α«⌐α»ì α«▓α»çα«░α»ìα«⌐α«┐α«Öα»ì|α«Üα»åα«»α«▒α»ìα«òα»ê α«¿α»üα«úα»ìα«úα«▒α«┐α«╡α»ü|α«¿α«òα»êα«Üα»ìα«Üα»üα«╡α»ê/iu', $question) === 1
            && preg_match('/\b(rathinam|rgu|admission|fee|fees|placement|hostel|transport|bus|buses|busses|scholarship|bca|bba|mba|b\.com|m\.com|b\.sc|m\.sc|b\.e|b\.tech)\b|α«╡α«┐α«ƒα»üα«ñα«┐|α«¬α»çα«░α»üα«¿α»ìα«ñα»ü|α«¬α»ïα«òα»ìα«òα»üα«╡α«░α«ñα»ìα«ñα»ü/iu', $question) === 0;

        if ($allChunks === [] && ! $isGeneralEducational) {
            Log::info('[assistant.lifecycle] verified_retrieval_empty', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt)]);

            return AssistantMessage::create($record + [
                'ai_response' => ($this->isRathinamQuestion($question) || preg_match('/\b(swimming pool|pool|gym|canteen|cafeteria|mess|bus|transport|hostel|fees?|admission)\b/i', $question) === 1)
                    ? $this->message('no_information', $language, $contact)
                    : $this->unrelatedReply($question, $language),
                'status' => AssistantMessage::STATUS_UNANSWERED,
            ]);
        }

        // THIS IS NEW CODE ΓÇö retain sources internally for auditing without exposing them to visitors.
        $record['sources'] = array_map(fn (RetrievedChunk $chunk): array => $chunk->toSource(), $allChunks);

        if (! $this->gemini->isConfigured() && $allChunks === []) {
            return AssistantMessage::create($record + [
                // THIS IS NEW CODE ΓÇö explain general-answer unavailability when Gemini is not configured. Reason: there is no verified passage for a safe extractive fallback.
                'ai_response' => $this->message('unavailable', $language, $contact),
                'model' => 'extractive',
                'status' => AssistantMessage::STATUS_FAILED,
            ]);
        }

        if (! $this->gemini->isConfigured()) {
            $bestChunk = $allChunks[0];

            return AssistantMessage::create($record + [
                'ai_response' => $this->extractiveAnswer($bestChunk, $language, $question),
                'model' => 'extractive',
                'status' => AssistantMessage::STATUS_ANSWERED,
            ]);
        }

        try {
            $geminiStartedAt = hrtime(true);
            $reply = $this->gemini->generate(
                $this->prompts->systemInstruction($language, $detected, (string) $contact),
                $this->turns($history, $this->prompts->userTurn($question, $allChunks)),
                $requestId,
                $startedAt,
            );
            Log::info('[assistant.lifecycle] answer_generation_complete', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'stage_elapsed_ms' => $this->elapsedMs($geminiStartedAt), 'model' => $reply->model]);

            return AssistantMessage::create($record + [
                'ai_response' => $reply->text,
                'model' => $reply->model,
                'prompt_tokens' => $reply->promptTokens,
                'completion_tokens' => $reply->completionTokens,
                'status' => AssistantMessage::STATUS_ANSWERED,
            ]);
        } catch (GeminiException $e) {
            Log::warning('[assistant.lifecycle] answer_generation_fallback', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'reason' => $e->reason]);

            // The retrieved FAQ text is already verified, so it is a safe answer when the AI service is down.
            return AssistantMessage::create($record + [
                // THIS IS NEW CODE ΓÇö keep the existing verified extractive fallback and handle general turns without evidence. Reason: API failures must not create an undefined chunk access.
                'ai_response' => $allChunks !== [] && in_array($allChunks[0]->sourceType, ['faq', 'static_data', 'official_website', 'knowledge_document'], true)
                    ? $this->extractiveAnswer($allChunks[0], $language, $question)
                    : $this->message('unavailable', $language, $contact),
                'model' => 'extractive',
                'status' => AssistantMessage::STATUS_FAILED,
                'error_reason' => $e->reason,
            ]);
        }
    }

    /** THIS IS NEW CODE ΓÇö expose verified retrieval to native Live without invoking Gemini Flash. Reason: Live should decide, understand returned facts, and speak its own response. */
    private function responseLanguage(string $detected, string $preference): string
    {
        if (in_array($preference, ['ta', 'en'], true)) {
            return $preference;
        }

        return $detected === TextNormalizer::ENGLISH ? 'en' : 'ta';
    }

    // Check if the question concerns Rathinam institutional matters
    public function isRathinamQuestion(string $question): bool
    {
        return $this->rathinamRetrievalQuestion($question) !== '';
    }

    // THIS IS NEW CODE ΓÇö send only institution-focused clauses to retrieval. Reason: mixed questions should not pollute Rathinam search with their general-knowledge portion.
    public function rathinamRetrievalQuestion(string $question): string
    {
        $clauses = preg_split('/\s+(?:and|also|plus|as well as|but|while|whereas|α««α«▒α»ìα«▒α»üα««α»ì|α«åα«⌐α«╛α«▓α»ì)\s+|[;.!?]+/iu', $question) ?: [$question];
        $institutionClauses = array_values(array_filter($clauses, fn (string $clause): bool => preg_match('/\b(rathinam|rgu|admission|fee|fees|placement|hostel|transport|bus|buses|busses|scholarship|bca|bba|mba|b\.com|m\.com|b\.sc|m\.sc|b\.e|b\.tech|ph\.?d)\b|α«░α«ñα»ìα«ñα«┐α«⌐α««α»ì|α«òα«▓α»ìα«▓α»éα«░α«┐|α«¬α«▓α»ìα«òα«▓α»êα«òα»ìα«òα«┤α«òα««α»ì|α«╡α«│α«╛α«òα««α»ì|α«¬α«ƒα«┐α«¬α»ìα«¬α»ü|α«Üα»çα«░α»ìα«òα»ìα«òα»ê|α«òα«ƒα»ìα«ƒα«úα««α»ì|α«╡α«┐α«ƒα»üα«ñα«┐|α«╡α»çα«▓α»êα«╡α«╛α«»α»ìα«¬α»ìα«¬α»ü|α«¬α»çα«░α»üα«¿α»ìα«ñα»ü|α«¬α»ïα«òα»ìα«òα»üα«╡α«░α«ñα»ìα«ñα»ü/iu', $clause) === 1
            || preg_match('/\b(?:our|your|at|in|does|do)\b.{0,35}\b(?:college|university|campus|course|programme|program|degree|facility|facilities)\b/iu', $clause) === 1));

        return trim(implode(' ', $institutionClauses));
    }

    // THIS IS NEW CODE ΓÇö distinguish mixed requests from institution-only requests after retrieval. Reason: a missing Rathinam fact must not suppress the answerable general part.
    public function hasGeneralPart(string $question, string $retrievalQuestion): bool
    {
        $normalize = fn (string $value): string => mb_strtolower((string) preg_replace('/[\p{P}\p{S}\s]+/u', '', $value));

        return $normalize($question) !== $normalize($retrievalQuestion);
    }

    private function unrelatedReply(string $question, string $language): string
    {
        $isEmotional = preg_match('/\b(sad|upset|lonely|anxious|anxiety|stressed|stress|depressed|worried|overwhelmed|kashtam|kavala|manasu)\b|α«òα«╡α«▓α»ê|α«ñα»üα«òα»ìα«òα««α»ì|α«ñα«⌐α«┐α««α»ê|α««α«⌐α«àα«┤α»üα«ñα»ìα«ñα««α»ì|α«╡α«░α»üα«ñα»ìα«ñα««α»ì/iu', $question) === 1;

        if ($language === 'ta') {
            return $isEmotional
                ? 'α«¿α»Çα«Öα»ìα«òα«│α»ì α«çα«¬α»ìα«¬α«ƒα«┐ α«ëα«úα«░α»ìα«╡α«ñα»ü α«╡α«░α»üα«ñα»ìα«ñα««α«╛α«ò α«çα«░α»üα«òα»ìα«òα«┐α«▒α«ñα»ü. α«░α«ñα»ìα«ñα«┐α«⌐α««α»ì α««α«╛α«úα«╡α«░α»ì α«╡α«╛α«┤α»ìα«òα»ìα«òα»ê α«àα«▓α»ìα«▓α«ñα»ü α«╡α«│α«╛α«òα««α»ì α«¬α«▒α»ìα«▒α«┐ α«¬α»çα«Ü α«╡α«┐α«░α»üα««α»ìα«¬α«┐α«⌐α«╛α«▓α»ì, α«ëα«ñα«╡α»üα«òα«┐α«▒α»çα«⌐α»ì.'
                : 'α«¿α«╛α«⌐α»ì α«░α«ñα»ìα«ñα«┐α«⌐α««α»ì α«¬α«ƒα«┐α«¬α»ìα«¬α»üα«òα«│α»ì α««α«▒α»ìα«▒α»üα««α»ì α«╡α«│α«╛α«ò α«╡α«╛α«┤α»ìα«òα»ìα«òα»ê α«¬α«▒α»ìα«▒α«┐α«» α«òα»çα«│α»ìα«╡α«┐α«òα«│α«┐α«▓α»ì α«ëα«ñα«╡α»üα«òα«┐α«▒α»çα«⌐α»ì. α«àα«ñα«┐α«▓α»ì α«Äα«ñα»êα«¬α»ì α«¬α«▒α»ìα«▒α«┐ α«ñα»åα«░α«┐α«¿α»ìα«ñα»üα«òα»èα«│α»ìα«│ α«╡α«┐α«░α»üα««α»ìα«¬α»üα«òα«┐α«▒α»Çα«░α»ìα«òα«│α»ì?';
        }

        return $isEmotional
            ? 'IΓÇÖm sorry youΓÇÖre feeling this way. If it would help, I can talk through Rathinam student life or campus information with you.'
            : 'I can help with Rathinam courses and campus life. If you are exploring university options, what would you like to know?';
    }

    /**
     * A follow-up with no subject of its own ("and the fees?") is searched together with the previous question,
     * so it stays about the course or topic already under discussion.
     *
     * @param  Collection<int, AssistantMessage>  $history
     * @return list<RetrievedChunk>
     */
    // OLD CODE ΓÇö NOT USED NOW: retrieval did not carry lifecycle identifiers into its database/static stages.
    // private function retrieve(string $question, Collection $history): array
    private function retrieve(string $question, Collection $history, string $requestId, int $startedAt): array
    {
        $hasSubject = array_filter($this->normalizer->units($question), fn (array $unit): bool => ! $unit['concept']) !== [];

        if (! $hasSubject && $history->isNotEmpty()) {
            $chunks = $this->searchWithStaticFallback($history->last()->user_message.' '.$question, $requestId, $startedAt);

            if ($chunks !== []) {
                return $chunks;
            }
        }

        return $this->searchWithStaticFallback($question, $requestId, $startedAt);
    }

    /**
     * THIS IS NEW CODE ΓÇö retain database-first priority while falling back safely to bundled data.
     *
     * @return list<RetrievedChunk>
     */
    // OLD CODE ΓÇö NOT USED NOW: retrieval did not report which local source matched or how long it took.
    // private function searchWithStaticFallback(string $question): array
    private function searchWithStaticFallback(string $question, string $requestId, int $startedAt): array
    {
        $databaseChunks = [];
        $databaseUnavailable = false;
        $databaseStartedAt = hrtime(true);

        try {
            $databaseChunks = $this->search->search($question);
            Log::info('[assistant.lifecycle] database_retrieval_complete', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'stage_elapsed_ms' => $this->elapsedMs($databaseStartedAt), 'result_count' => count($databaseChunks)]);
        } catch (Throwable $exception) {
            // THIS IS NEW CODE ΓÇö MySQL failures are logged internally and do not abort retrieval.
            Log::warning('[assistant.lifecycle] database_retrieval_failed', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'error_type' => class_basename($exception)]);
            $databaseUnavailable = true;
        }

        if ($databaseChunks !== []) {
            return $databaseChunks;
        }

        if (! config('assistant.temporary_knowledge_mode', true)) {
            return [];
        }

        $staticStartedAt = hrtime(true);
        $staticChunks = $this->staticSearch->search($question);

        if ($staticChunks !== [] && $staticChunks[0]->title === 'Verified Hostel Facilities') {
            Log::info('[assistant.lifecycle] bundled_retrieval_complete', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'stage_elapsed_ms' => $this->elapsedMs($staticStartedAt), 'result_count' => count($staticChunks)]);

            return $staticChunks;
        }

        $htChunks = $this->hostelTransportKnowledge->search($question);
        if ($htChunks !== []) {
            return $htChunks;
        }

        if ($this->hostelTransportKnowledge->isHostelOrTransportQuestion($question)) {
            return [];
        }

        Log::info('[assistant.lifecycle] bundled_retrieval_complete', ['request_id' => $requestId, 'elapsed_ms' => $this->elapsedMs($startedAt), 'stage_elapsed_ms' => $this->elapsedMs($staticStartedAt), 'result_count' => count($staticChunks)]);

        return $staticChunks;
    }

    /** THIS IS NEW CODE ΓÇö compute monotonic timings for correlated lifecycle logs. */
    private function elapsedMs(int $startedAt): int
    {
        return (int) ((hrtime(true) - $startedAt) / 1_000_000);
    }

    /**
     * @param  Collection<int, AssistantMessage>  $history
     * @return list<array{role: 'user'|'model', text: string}>
     */
    private function turns(Collection $history, string $currentTurn): array
    {
        $turns = [];

        foreach ($history as $message) {
            $turns[] = ['role' => 'user', 'text' => $message->user_message];
            $turns[] = ['role' => 'model', 'text' => (string) $message->ai_response];
        }

        $turns[] = ['role' => 'user', 'text' => $currentTurn];

        return $turns;
    }

    // THIS IS NEW CODE ΓÇö select a matching verified sentence when Gemini is unavailable. Reason: returning a raw 600-character prefix often omitted the answer.
    private function extractiveAnswer(RetrievedChunk $chunk, string $language, string $question): string
    {
        if ($chunk->sourceType === 'knowledge_document') {
            if (preg_match('/^Answer:\s*(.+)$/m', $chunk->content, $matches) === 1) {
                return trim($matches[1]);
            }

            return $chunk->content;
        }

        // THIS IS NEW CODE ΓÇö return the complete curated hostel answer. Reason: sentence-only extraction discarded the grouped, verified facility details.
        if ($chunk->title === 'Verified Hostel Facilities') {
            return $chunk->content;
        }

        // THIS IS NEW CODE ΓÇö turn the official site's exact hostel FAQ into a concise grounded fallback. Reason: retaining the question text alone is not an answer.
        if ($chunk->sourceType === 'official_website' && preg_match('/Yes,\s*information regarding\s*[ΓÇ£"]?Hostel Facility[ΓÇ¥"]?\s+is provided\.?/iu', $chunk->content) === 1) {
            return $language === 'ta'
                ? 'α«åα««α»ì. α«╡α«┐α«ƒα»üα«ñα«┐ α«╡α«Üα«ñα«┐ α«òα»üα«▒α«┐α«ñα»ìα«ñ α«ñα«òα«╡α«▓α»ì α«╡α«┤α«Öα»ìα«òα«¬α»ìα«¬α«ƒα»üα«òα«┐α«▒α«ñα»ü.'
                : 'Yes. Information about the hostel facility is provided by Rathinam Global University.';
        }

        // OLD CODE ΓÇö NOT USED NOW: programme matching depended on SEO page titles, which are intentionally removed before retrieval context is built.
        // if ($chunk->sourceType === 'official_website' && preg_match('/B\.\?Sc\.? Computer Science/iu', $chunk->title) === 1) { ... }
        // THIS IS NEW CODE ΓÇö match the verified programme passage instead of its removed SEO title. Reason: keep native and fallback retrieval free of metadata while preserving exact course answers.
        if ($chunk->sourceType === 'official_website'
            && preg_match('/(?:B\.?Sc\.?(?: in)?|Bachelor of Science in) Computer Science/iu', $chunk->content) === 1
            && preg_match('/\b(?:irukk|irukka|iruku|is there|does .* offer|offers?)\b/iu', $question) === 1) {
            return $language === 'ta'
                ? 'α«åα««α»ì. α«░α«ñα»ìα«ñα«┐α«⌐α««α»ì α«òα»üα«│α»ïα«¬α«▓α»ì α«¬α«▓α»ìα«òα«▓α»êα«òα»ìα«òα«┤α«òα«ñα»ìα«ñα«┐α«▓α»ì B.Sc Computer Science α«¬α«ƒα«┐α«¬α»ìα«¬α»ü α«ëα«│α»ìα«│α«ñα»ü.'
                : 'Yes. Rathinam Global University offers the B.Sc Computer Science programme.';
        }

        if (in_array($chunk->sourceType, ['faq', 'official_website'], true)) {
            $marker = $language === 'ta' ? 'பதில்: ' : 'A: ';

            foreach (preg_split('/\R/u', $chunk->content) ?: [] as $line) {
                if (str_starts_with($line, $marker)) {
                    return mb_substr($line, mb_strlen($marker));
                }
            }

            foreach (preg_split('/\R/u', $chunk->content) ?: [] as $line) {
                if (str_starts_with($line, 'A: ') || str_starts_with($line, 'பதில்: ')) {
                    return preg_replace('/^(A: |பதில்: )/u', '', $line) ?? $line;
                }
            }
        }

        $units = $this->normalizer->units($question);
        $sentences = preg_split('/(?<=[.!?])\s+/u', $chunk->content) ?: [];
        $bestSentence = '';
        $bestMatches = 0;
        foreach ($sentences as $sentence) {
            $sentenceStems = $this->normalizer->stemSet($sentence);
            $matches = 0;
            foreach ($units as $unit) {
                if (array_filter($unit['stems'], fn (string $stem): bool => isset($sentenceStems[$stem])) !== []) {
                    $matches++;
                }
            }
            if ($matches > $bestMatches) {
                $bestSentence = trim($sentence);
                $bestMatches = $matches;
            }
        }
        if ($bestMatches > 0 && $bestSentence !== '') {
            return mb_substr($bestSentence, 0, 600);
        }

        return mb_substr($chunk->content, 0, 600);
    }

    private function message(string $key, string $language, ?string $contact): string
    {
        return str_replace('{contact}', (string) $contact, config("assistant.messages.{$key}.{$language}"));
    }
}
