<?php

namespace App\Services\Assistant;

use App\Models\KnowledgeChunk;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Finds the knowledge chunks relevant to a question.
 *
 * Retrieval is two steps so a vector search can later replace or join the
 * first one without touching the second:
 *  1. candidates(): cheap database lookup (MySQL FULLTEXT, LIKE elsewhere);
 *  2. score(): lexical relevance of each candidate, 0-1, over Tamil, English
 *     and Tanglish search units from TextNormalizer.
 *
 * Only chunks of live content exist in the index, so inactive and unpublished
 * content is never returned.
 */
class KnowledgeSearchService
{
    private const CANDIDATE_LIMIT = 200;

    public function __construct(private TextNormalizer $normalizer) {}

    /**
     * @return list<RetrievedChunk> best first
     */
    public function search(string $query, ?int $limit = null, ?float $minScore = null): array
    {
        $limit ??= (int) config('assistant.retrieval_limit');
        $minScore ??= (float) config('assistant.min_relevance_score');
        $units = $this->normalizer->units($query);

        if ($units === []) {
            return [];
        }

        $scored = [];

        foreach ($this->candidates($units) as $chunk) {
            $score = $this->score($units, $chunk);

            if ($score >= $minScore) {
                $scored[] = new RetrievedChunk($chunk->id, $chunk->source_type, $chunk->source_id, $chunk->title, $chunk->content, $score);
            }
        }

        usort($scored, fn (RetrievedChunk $a, RetrievedChunk $b): int => $b->score <=> $a->score);

        // Drop weak hits next to a strong one: "MBA fees" must not accompany an answer about "BCA fees".
        $best = $scored[0]->score ?? 0.0;

        return array_slice(array_values(array_filter($scored, fn (RetrievedChunk $c): bool => $c->score >= $best * 0.6)), 0, $limit);
    }

    /**
     * @param  list<array{stems: list<string>, weight: int, concept: bool}>  $units
     * @return iterable<KnowledgeChunk>
     */
    private function candidates(array $units): iterable
    {
        $stems = array_values(array_unique(array_merge(...array_column($units, 'stems'))));

        $query = KnowledgeChunk::query()->where(function (Builder $where) use ($stems): void {
            if (DB::getDriverName() === 'mysql') {
                // FULLTEXT ignores short and Tamil-script words, which LIKE still catches.
                $words = array_filter($stems, fn (string $s): bool => mb_strlen($s) >= 3 && ! preg_match('/\p{Tamil}/u', $s));

                if ($words !== []) {
                    $where->orWhereRaw('MATCH(search_text) AGAINST (? IN BOOLEAN MODE)', [implode(' ', array_map(fn (string $w): string => $w.'*', $words))]);
                }

                $stems = array_diff($stems, $words);
            }

            foreach ($stems as $stem) {
                $where->orWhere('search_text', 'like', '%'.addcslashes($stem, '%_\\').'%');
            }
        });

        return $query->limit(self::CANDIDATE_LIMIT)->get();
    }

    /**
     * @param  list<array{stems: list<string>, weight: int, concept: bool}>  $units
     */
    private function score(array $units, KnowledgeChunk $chunk): float
    {
        $present = $this->normalizer->stemSet($chunk->search_text);
        $total = 0;
        $matched = 0;
        $matchedSpecific = false;
        $hasSpecific = false;

        foreach ($units as $unit) {
            $total += $unit['weight'];
            $hasSpecific = $hasSpecific || ! $unit['concept'];

            if (array_filter($unit['stems'], fn (string $stem): bool => isset($present[$stem])) !== []) {
                $matched += $unit['weight'];
                $matchedSpecific = $matchedSpecific || ! $unit['concept'];
            }
        }

        // A named subject (BCA, hostel warden...) that the chunk never mentions means it is about something else.
        if ($hasSpecific && ! $matchedSpecific) {
            return 0.0;
        }

        return $total > 0 ? $matched / $total : 0.0;
    }
}
