<?php

namespace App\Services\VoiceAssistant;

use App\Support\ContentRepository;

/**
 * Approved, public content the voice assistant may answer from: the FAQ,
 * the school pages, resources/data/voice-assistant.php and every other page's
 * content file (see SiteContent). Read-only — the
 * assistant has no way to change it, and nothing private is indexed.
 *
 * Retrieval is keyword scoring, which suits a few hundred entries. For a
 * larger document set, replace search() with an embedding index; callers
 * only depend on the returned entry shape.
 *
 * @phpstan-type Entry array{id: string, category: string, title: string, question: string, answer: string, url: string}
 * @phpstan-type Match array{entry: Entry, score: int, coverage: float}
 */
class KnowledgeBase
{
    private const QUESTION_WEIGHT = 3;

    private const ANSWER_WEIGHT = 1;

    private const STOPWORDS = [
        'a', 'about', 'an', 'and', 'any', 'are', 'at', 'be', 'by', 'can', 'could', 'do', 'does', 'for',
        'from', 'give', 'have', 'has', 'how', 'i', 'in', 'is', 'it', 'its', 'know', 'like', 'me', 'my',
        'of', 'on', 'or', 'our', 'please', 'tell', 'that', 'the', 'their', 'there', 'this', 'to', 'us',
        'want', 'was', 'we', 'what', 'when', 'which', 'who', 'why', 'will', 'with', 'would', 'you', 'your',
        'rathinam', 'rgu', 'rgi', 'university', 'college', 'institution', 'get', 'need', 'some', 'much', 'many',
        'available', 'offer', 'offered', 'offers', 'provide', 'provided', 'currently', 'any', 'does', 'did',
    ];

    /**
     * Degree names inside school data files ("B.Sc Computer Science", "MBA ...").
     */
    private const DEGREE_PATTERN = '/^(?:[BM]\.\s?(?:Sc|E|Tech|Com|A|Des|Voc|Arch|Pharm|Lib|Ed)\b|BBA|MBA|BCA|MCA|BPT|MPT|B\.?Des|Ph\.?\s?D)/u';

    /**
     * @var array<int, Entry>|null
     */
    private ?array $entries = null;

    /**
     * @var array<int, array{question: array<int, string>, answer: array<int, string>}>
     */
    private array $index = [];

    /**
     * @var array<string, array<int, string>>
     */
    private array $programmes = [];

    public function __construct(private ContentRepository $content, private SiteContent $site) {}

    /**
     * Best-matching entries for a question, highest score first.
     *
     * @return array<int, Match>
     */
    public function search(string $query, int $limit = 8): array
    {
        $terms = $this->queryTerms($query);

        if ($terms === []) {
            return [];
        }

        $matches = [];

        foreach ($this->entries() as $position => $entry) {
            $score = 0;
            $matched = 0;

            foreach ($terms as $term) {
                $weight = match (true) {
                    $this->containsTerm($this->index[$position]['question'], $term) => self::QUESTION_WEIGHT,
                    $this->containsTerm($this->index[$position]['answer'], $term) => self::ANSWER_WEIGHT,
                    default => 0,
                };

                $score += $weight;
                $matched += $weight > 0 ? 1 : 0;
            }

            if ($score > 0) {
                $matches[] = ['entry' => $entry, 'score' => $score, 'coverage' => $matched / count($terms)];
            }
        }

        usort($matches, fn (array $a, array $b): int => $b['score'] <=> $a['score'] ?: $b['coverage'] <=> $a['coverage']);

        return array_slice($matches, 0, $limit);
    }

    /**
     * General entries used when a question matches nothing specific (for
     * example a Tamil question with no known keyword), so the AI still has
     * approved material to answer from.
     *
     * @return array<int, Entry>
     */
    public function overview(): array
    {
        return array_values(array_filter(
            $this->entries(),
            fn (array $entry): bool => in_array($entry['category'], ['About', 'Contact', 'Academics'], true) && str_starts_with($entry['id'], 'fact-'),
        ));
    }

    /**
     * @return array{phone: string, email: string, admissions_url: string}
     */
    public function contact(): array
    {
        return $this->content->get('voice-assistant')['contact'];
    }

    /**
     * The assistant personas a visitor can choose to talk to, keyed by id.
     *
     * @return array<string, array{name: array<string, string>, role: array<string, string>, voice: 'female'|'male', image: string, focus: string, greeting: array<string, string>, suggestions: array<string, array<int, string>>}>
     */
    public function personas(): array
    {
        return $this->content->get('voice-assistant')['personas'];
    }

    public function message(string $key, string $language): string
    {
        $messages = $this->content->get('voice-assistant')['messages'];

        return $messages[$language][$key] ?? $messages['en'][$key];
    }

    /**
     * @return array<int, Entry>
     */
    public function entries(): array
    {
        if ($this->entries !== null) {
            return $this->entries;
        }

        // Curated entries first: they win ties and keep their place when questions repeat.
        $entries = [...$this->factEntries(), ...$this->faqEntries(), ...$this->schoolEntries(), ...$this->site->entries()];

        // The FAQ repeats a few questions across categories; keep the first.
        $unique = [];

        foreach ($entries as $entry) {
            $unique[mb_strtolower($entry['question'])] ??= $entry;
        }

        $this->entries = array_values($unique);
        $this->index = array_map(fn (array $entry): array => [
            'question' => $this->words($entry['question']),
            'answer' => $this->words($entry['title'].' '.$entry['answer'].' '.$entry['category']),
        ], $this->entries);

        return $this->entries;
    }

    /**
     * @return array<int, Entry>
     */
    private function factEntries(): array
    {
        return array_map(fn (array $fact): array => [
            'id' => 'fact-'.$fact['id'],
            'category' => $fact['category'],
            'title' => $fact['title'],
            'question' => $fact['question'],
            'answer' => $fact['answer'],
            'url' => isset($fact['route']) ? route($fact['route']) : (string) ($fact['url'] ?? route('home')),
        ], $this->content->get('voice-assistant')['facts']);
    }

    /**
     * @return array<int, Entry>
     */
    private function faqEntries(): array
    {
        $entries = [];

        foreach ($this->content->get('faqs') as $category) {
            foreach ($category['items'] as $number => $item) {
                $entries[] = [
                    'id' => 'faq-'.$category['id'].'-'.$number,
                    'category' => $this->plain($category['title']),
                    'title' => $this->plain($category['title']),
                    'question' => $this->plain($item['q']),
                    'answer' => $this->plain($item['a']),
                    'url' => route('faq').'#'.$category['id'],
                ];
            }
        }

        return $entries;
    }

    /**
     * One "programmes" and one "specialisations" entry per school page.
     *
     * @return array<int, Entry>
     */
    private function schoolEntries(): array
    {
        $entries = [];

        foreach ($this->content->get('voice-assistant')['schools'] as $slug => $name) {
            if (! $this->content->has('schools/'.$slug)) {
                continue;
            }

            $data = $this->content->get('schools/'.$slug);
            $programmes = array_flip($this->schoolProgrammes($slug));
            $specialisations = [];

            foreach ($data['skills'] ?? [] as $skill) {
                if (isset($skill['title'], $skill['desc'])) {
                    $specialisations[] = $this->plain($skill['title']).' ('.$this->plain($skill['desc']).')';
                }
            }

            $url = route('schools.show', $slug);

            if ($programmes !== []) {
                $entries[] = [
                    'id' => 'school-'.$slug.'-programmes',
                    'category' => 'Programmes',
                    'title' => $name.' programmes',
                    'question' => 'Which programmes and courses does the '.$name.' offer?',
                    'answer' => 'The '.$name.' lists these programmes: '.implode('; ', array_keys($programmes)).'.',
                    'url' => $url,
                ];
            }

            if ($specialisations !== []) {
                $entries[] = [
                    'id' => 'school-'.$slug.'-specialisations',
                    'category' => 'Programmes',
                    'title' => $name.' specialisations',
                    'question' => 'What specialisations and skills does the '.$name.' cover?',
                    'answer' => 'Specialisations at the '.$name.' include '.implode('; ', $specialisations).'.',
                    'url' => $url,
                ];
            }
        }

        return $entries;
    }

    /**
     * Degree names listed on a school's page, e.g. "B.E Mechanical Engineering".
     *
     * @return array<int, string>
     */
    public function schoolProgrammes(string $slug): array
    {
        if (isset($this->programmes[$slug])) {
            return $this->programmes[$slug];
        }

        if (! $this->content->has('schools/'.$slug)) {
            return [];
        }

        $data = $this->content->get('schools/'.$slug);
        $programmes = [];

        array_walk_recursive($data, function (mixed $value, int|string $key) use (&$programmes): void {
            foreach ([$value, $key] as $candidate) {
                if (is_string($candidate) && preg_match(self::DEGREE_PATTERN, $this->plain($candidate)) === 1) {
                    $programmes[$this->plain($candidate)] = true;
                }
            }
        });

        return $this->programmes[$slug] = array_keys($programmes);
    }

    /**
     * Search terms for a question: stopwords dropped, synonyms and Tamil
     * keywords mapped onto the English vocabulary of the content.
     *
     * @return array<int, string>
     */
    private function queryTerms(string $query): array
    {
        $aliases = $this->content->get('voice-assistant')['aliases'];
        $terms = [];

        foreach ($this->words($query) as $word) {
            $mapped = null;

            foreach ($aliases as $alias => $replacements) {
                if ($word === $alias || (preg_match('/^\p{Tamil}/u', $word) === 1 && str_starts_with($word, $alias))) {
                    $mapped = $replacements;
                    break;
                }
            }

            if ($mapped !== null) {
                array_push($terms, ...$mapped);
            } elseif (preg_match('/^\p{Tamil}/u', $word) !== 1 && ! in_array($word, self::STOPWORDS, true) && mb_strlen($word) > 1) {
                // An unmapped Tamil word cannot match English content, so it does not count against coverage.
                $terms[] = $word;
            }
        }

        return array_values(array_unique($terms));
    }

    /**
     * @param  array<int, string>  $words
     */
    private function containsTerm(array $words, string $term): bool
    {
        foreach ($words as $word) {
            if ($word === $term) {
                return true;
            }

            // Plural / suffix forms: "admission" ~ "admissions", but not "host" ~ "hostel".
            [$shorter, $longer] = mb_strlen($word) < mb_strlen($term) ? [$word, $term] : [$term, $word];

            if (mb_strlen($shorter) >= 5 && mb_strlen($longer) - mb_strlen($shorter) <= 2 && str_starts_with($longer, $shorter)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Lowercase words; \p{M} keeps Tamil vowel signs attached to their letters.
     *
     * @return array<int, string>
     */
    private function words(string $text): array
    {
        $words = preg_split('/[^\p{L}\p{M}\p{N}.]+/u', mb_strtolower($text), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        // Dots are dropped so "B.Sc", "BSc" and "bsc" are the same word.
        return array_values(array_unique(array_filter(array_map(fn (string $word): string => str_replace('.', '', $word), $words))));
    }

    private function plain(string $html): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }
}
