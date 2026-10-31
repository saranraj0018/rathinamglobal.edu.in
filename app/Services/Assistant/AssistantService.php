<?php

namespace App\Services\Assistant;

use App\Models\AssistantConversation;
use App\Models\AssistantMessage;
use App\Models\AssistantSetting;
use Illuminate\Support\Collection;

/**
 * Answers one visitor question: retrieve verified knowledge, then have Gemini
 * phrase an answer from it. With nothing relevant retrieved, Gemini is not
 * called at all and the visitor gets the "no verified information" reply, so
 * the assistant cannot invent institutional facts.
 */
class AssistantService
{
    public function __construct(
        private TextNormalizer $normalizer,
        private KnowledgeSearchService $search,
        private PromptBuilderService $prompts,
        private GeminiService $gemini,
    ) {}

    /**
     * @param  'auto'|'ta'|'en'  $languagePreference
     */
    public function ask(AssistantConversation $conversation, string $question, string $languagePreference = 'auto'): AssistantMessage
    {
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

        $chunks = $this->retrieve($question, $history);

        if ($chunks === []) {
            return AssistantMessage::create($record + [
                'ai_response' => $this->message('no_information', $language, $contact),
                'status' => AssistantMessage::STATUS_UNANSWERED,
            ]);
        }

        $record['sources'] = array_map(fn (RetrievedChunk $c): array => $c->toSource(), $chunks);

        if (! $this->gemini->isConfigured()) {
            return AssistantMessage::create($record + [
                'ai_response' => $this->extractiveAnswer($chunks[0], $language),
                'model' => 'extractive',
                'status' => AssistantMessage::STATUS_ANSWERED,
            ]);
        }

        try {
            $reply = $this->gemini->generate(
                $this->prompts->systemInstruction($language, $detected, (string) $contact),
                $this->turns($history, $this->prompts->userTurn($question, $chunks)),
            );

            return AssistantMessage::create($record + [
                'ai_response' => $reply->text,
                'model' => $reply->model,
                'prompt_tokens' => $reply->promptTokens,
                'completion_tokens' => $reply->completionTokens,
                'status' => AssistantMessage::STATUS_ANSWERED,
            ]);
        } catch (GeminiException $e) {
            // The retrieved FAQ text is already verified, so it is a safe answer when the AI service is down.
            return AssistantMessage::create($record + [
                'ai_response' => $chunks[0]->sourceType === 'faq'
                    ? $this->extractiveAnswer($chunks[0], $language)
                    : $this->message('unavailable', $language, $contact),
                'model' => 'extractive',
                'status' => AssistantMessage::STATUS_FAILED,
                'error_reason' => $e->reason,
            ]);
        }
    }

    /**
     * Tanglish and Tamil visitors get Tamil replies unless they chose English.
     */
    private function responseLanguage(string $detected, string $preference): string
    {
        if (in_array($preference, ['ta', 'en'], true)) {
            return $preference;
        }

        return $detected === TextNormalizer::ENGLISH ? 'en' : 'ta';
    }

    /**
     * A follow-up with no subject of its own ("and the fees?") is searched together with the previous question,
     * so it stays about the course or topic already under discussion.
     *
     * @param  Collection<int, AssistantMessage>  $history
     * @return list<RetrievedChunk>
     */
    private function retrieve(string $question, Collection $history): array
    {
        $hasSubject = array_filter($this->normalizer->units($question), fn (array $unit): bool => ! $unit['concept']) !== [];

        if (! $hasSubject && $history->isNotEmpty()) {
            $chunks = $this->search->search($history->last()->user_message.' '.$question);

            if ($chunks !== []) {
                return $chunks;
            }
        }

        return $this->search->search($question);
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

    private function extractiveAnswer(RetrievedChunk $chunk, string $language): string
    {
        if ($chunk->sourceType === 'faq') {
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

        return mb_substr($chunk->content, 0, 600);
    }

    private function message(string $key, string $language, ?string $contact): string
    {
        return str_replace('{contact}', (string) $contact, config("assistant.messages.{$key}.{$language}"));
    }
}
