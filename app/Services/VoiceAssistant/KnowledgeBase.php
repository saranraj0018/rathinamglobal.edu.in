<?php

namespace App\Services\VoiceAssistant;

use App\Support\ContentRepository;
use Illuminate\Support\Str;

/**
 * Approved, public content the voice assistant may answer from: the FAQ,
 * the school pages, resources/data/voice-assistant.php and every other page's
 * content file (see SiteContent). Read-only — the
 * assistant has no way to change it, and nothing private is indexed.
 *
 * With an AI provider, the assistant picks entries from catalogue(). Without
 * one, search() ranks them by word overlap weighted by rarity. Callers only
 * depend on the returned entry shape.
 *
 * @phpstan-type Entry array{id: string, category: string, title: string, question: string, answer: string, answer_ta?: string, also_asked?: array<int, string>, route?: string, url: string}
 * @phpstan-type Match array{entry: Entry, score: int, coverage: float}
 */
class KnowledgeBase
{
    private const QUESTION_WEIGHT = 3;

    private const ALSO_ASKED_WEIGHT = 2;

    private const ANSWER_WEIGHT = 1;

    /**
     * Degree names inside school data files ("B.Sc Computer Science", "MBA ...").
     */
    private const DEGREE_PATTERN = '/^(?:[BM]\.\s?(?:Sc|E|Tech|Com|A|Des|Voc|Arch|Pharm|Lib|Ed)\b|BBA|MBA|BCA|MCA|BPT|MPT|B\.?Des|Ph\.?\s?D)/u';

    /**
     * @var array<int, Entry>|null
     */
    private ?array $entries = null;

    /**
     * @var array<int, array{question: array<int, string>, also: array<int, string>, answer: array<int, string>}>
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
     * The question is first normalised (queryTerms: filler dropped, spelling variants and
     * aliases mapped), then each remaining word is weighted by how rare it is in the content
     * (inverse document frequency), so generic words count for little and a topic word for a
     * lot; a word found nowhere (an unknown spelling) is ignored. A word in an entry's
     * question outweighs one in its alternative wordings, which outweighs one in its answer.
     * Scores are in tenths of a point so they stay integers.
     *
     * @return array<int, Match>
     */
    public function search(string $query, int $limit = 8): array
    {
        $queryTerms = $this->queryTerms($query);
        $terms = array_map('strval', array_keys($queryTerms));
        $entries = $this->entries();
        $weights = [];
        $frequency = array_fill_keys($terms, 0);

        foreach ($entries as $position => $entry) {
            foreach ($terms as $term) {
                $weights[$position][$term] = match (true) {
                    $this->containsTerm($this->index[$position]['question'], $term) => self::QUESTION_WEIGHT,
                    $this->containsTerm($this->index[$position]['also'], $term) => self::ALSO_ASKED_WEIGHT,
                    $this->containsTerm($this->index[$position]['answer'], $term) => self::ANSWER_WEIGHT,
                    default => 0,
                };
                $frequency[$term] += $weights[$position][$term] > 0 ? 1 : 0;
            }
        }

        $rarity = [];
        $unmatchedRarity = 0.0;

        foreach ($frequency as $term => $count) {
            if ($count > 0) {
                $rarity[$term] = log(count($entries) / $count);
            } elseif ($queryTerms[$term] && preg_match('/^\p{Tamil}/u', (string) $term) !== 1) {
                // A Latin-script word the visitor wrote that is found nowhere (an unknown topic or spelling)
                // counts against the match. A Tamil word cannot be matched against English content, and a
                // word an alias added is only a hint, so neither does.
                $unmatchedRarity += log(count($entries));
            }
        }

        $totalRarity = array_sum($rarity) + $unmatchedRarity;

        if ($rarity === [] || $totalRarity <= 0) {
            return [];
        }

        $matches = [];

        foreach ($entries as $position => $entry) {
            $score = 0.0;
            $matched = 0.0;

            foreach ($rarity as $term => $value) {
                $score += $weights[$position][$term] * $value;
                $matched += $weights[$position][$term] > 0 ? $value : 0;
            }

            if ($score > 0) {
                $matches[] = ['entry' => $entry, 'score' => (int) round($score * 10), 'coverage' => $matched / $totalRarity];
            }
        }

        usort($matches, fn (array $a, array $b): int => $b['score'] <=> $a['score'] ?: $b['coverage'] <=> $a['coverage']);

        return array_slice($matches, 0, $limit);
    }

    /**
     * One numbered line per entry ("12. Hostel Wi-Fi — Is Wi-Fi available in the hostel?"), the
     * list the AI chooses from. Numbers are positions in entries() plus one.
     *
     * @return array<int, string>
     */
    public function catalogue(): array
    {
        $lines = [];

        foreach ($this->entries() as $position => $entry) {
            $question = $entry['question'] === $entry['title'] ? '' : ' — '.Str::limit($entry['question'], 110, '…');
            $alternatives = isset($entry['also_asked']) ? ' (also asked: '.implode(' | ', $entry['also_asked']).')' : '';
            $lines[] = ($position + 1).'. '.Str::limit($entry['title'], 90, '…').$question.$alternatives;
        }

        return $lines;
    }

    /**
     * The entries behind catalogue() numbers; unknown numbers are ignored.
     *
     * @param  array<int, int>  $numbers
     * @return array<int, Entry>
     */
    public function entriesNumbered(array $numbers): array
    {
        $entries = $this->entries();

        return array_values(array_filter(array_map(fn (int $number): ?array => $entries[$number - 1] ?? null, $numbers)));
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
        $entries = [...$this->factEntries(), ...$this->faqEntries(), ...$this->schoolEntries(), ...$this->degreeEntries(), ...$this->site->entries()];

        // The FAQ repeats a few questions across categories; keep the first.
        $unique = [];

        foreach ($entries as $entry) {
            $unique[mb_strtolower($entry['question'])] ??= $entry;
        }

        $this->entries = array_values($unique);
        $this->index = array_map(fn (array $entry): array => [
            'question' => $this->words($entry['question']),
            'also' => $this->words(implode(' ', $entry['also_asked'] ?? [])),
            'answer' => $this->words($entry['title'].' '.$entry['answer'].' '.($entry['answer_ta'] ?? '').' '.$entry['category'].' '.$this->routeWords($entry['route'] ?? null)),
        ], $this->entries);

        return $this->entries;
    }

    /**
     * @return array<int, Entry>
     */
    private function factEntries(): array
    {
        return array_map(fn (array $fact): array => array_filter([
            'id' => 'fact-'.$fact['id'],
            'category' => $fact['category'],
            'title' => $fact['title'],
            'question' => $fact['question'],
            'answer' => $fact['answer'],
            'answer_ta' => $fact['answer_ta'] ?? null,
            'also_asked' => $fact['also_asked'] ?? null,
            'route' => $fact['route'] ?? null,
            'url' => isset($fact['route']) ? route($fact['route']) : (string) ($fact['url'] ?? route('home')),
        ], fn (mixed $value): bool => $value !== null), $this->content->get('voice-assistant')['facts']);
    }

    /**
     * The words of a descriptive route name ("bus-registration.create" -> "bus registration"), so a
     * question naming a page finds it even when the page text never says so. One-word names such
     * as "home" describe nothing and are skipped.
     */
    private function routeWords(?string $route): string
    {
        $name = explode('.', (string) $route)[0];

        return str_contains($name, '-') ? str_replace('-', ' ', $name) : '';
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
     * One entry per degree ("B.Sc", "MBA", ...) listing its programmes across
     * every school, so "list the B.Sc programmes" has a single complete answer.
     *
     * @return array<int, Entry>
     */
    private function degreeEntries(): array
    {
        $degrees = [];

        foreach ($this->content->get('voice-assistant')['schools'] as $slug => $name) {
            foreach ($this->schoolProgrammes($slug) as $programme) {
                // Group headings such as "B.Sc Programmes" or "B.Com — AI & ..." are not programmes themselves.
                if (preg_match('/\bProgrammes$|—/iu', $programme) === 1) {
                    continue;
                }

                $degrees[strtok($programme, ' ')][$name][] = $programme;
            }
        }

        $entries = [];

        foreach ($degrees as $degree => $schools) {
            $count = array_sum(array_map('count', $schools));
            $lists = array_map(fn (string $school, array $programmes): string => $school.': '.implode(', ', $programmes), array_keys($schools), $schools);

            $entries[] = [
                'id' => 'degree-'.Str::slug($degree),
                'category' => 'Programmes',
                'title' => $degree.' programmes',
                'question' => 'Which '.$degree.' programmes (programs or courses) are offered? Full list.',
                'answer' => sprintf('The university offers %d %s %s. %s.', $count, $degree, Str::plural('programme', $count), implode('. ', $lists)),
                'url' => route('home'),
            ];
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
     * The question as the search sees it, for debugging.
     */
    public function normalise(string $query): string
    {
        return implode(' ', array_keys($this->queryTerms($query)));
    }

    /**
     * Search terms for a question: filler words ('stopwords') dropped, synonyms and Tamil
     * keywords mapped onto the English vocabulary of the content ('aliases', 'phrases').
     * An intent word such as "where" (-> address) only counts when no topic word is left,
     * so "hostel wifi, where?" is about the hostel, not the address.
     *
     * @return array<string, bool> term => whether the visitor wrote it (false when it came from an alias or phrase)
     */
    private function queryTerms(string $query): array
    {
        $data = $this->content->get('voice-assistant');
        $stopwords = array_flip($data['stopwords']);
        $terms = [];
        $intentTerms = [];

        // Speech recognition may spell a degree letter by letter ("பி எஸ் சி"), which words() splits apart.
        $spaced = ' '.trim((string) preg_replace('/[\s.]+/u', ' ', $this->fold($query))).' ';

        foreach ($data['phrases'] as $phrase => $replacements) {
            if (str_contains($spaced, ' '.$phrase.' ')) {
                $terms = [...$terms, ...array_fill_keys($replacements, false)];
            }
        }

        foreach ($this->words($query) as $word) {
            $mapped = null;

            foreach ($data['aliases'] as $alias => $replacements) {
                if ($word === (string) $alias || (preg_match('/^\p{Tamil}/u', $word) === 1 && str_starts_with($word, (string) $alias))) {
                    $mapped = $replacements;
                    break;
                }
            }

            if ($mapped !== null && isset($stopwords[$word])) {
                $intentTerms = [...$intentTerms, ...array_fill_keys($mapped, false)];
            } elseif ($mapped !== null) {
                $terms = [...$terms, ...array_fill_keys($mapped, false)];
            } elseif (! isset($stopwords[$word]) && mb_strlen($word) > 1) {
                $terms[$word] = true;
            }
        }

        return $terms !== [] ? $terms : $intentTerms;
    }

    private function matchesTamil(string $word, string $term): bool
    {
        if (preg_match('/^\p{Tamil}/u', $word) !== 1 || preg_match('/^\p{Tamil}/u', $term) !== 1) {
            return false;
        }

        [$shorter, $longer] = mb_strlen($word) < mb_strlen($term) ? [$word, $term] : [$term, $word];

        return mb_strlen($shorter) >= 4 && str_starts_with($longer, $shorter);
    }

    /**
     * @param  array<int, string>  $words
     */
    private function containsTerm(array $words, string $term): bool
    {
        foreach ($words as $word) {
            if ($word === $term || $this->matchesTamil($word, $term)) {
                return true;
            }

            // Simple English plurals: "bus" ~ "buses", "fee" ~ "fees".
            if ($word === $term.'s' || $word === $term.'es' || $term === $word.'s' || $term === $word.'es') {
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
        $words = preg_split('/[^\p{L}\p{M}\p{N}.]+/u', $this->fold($text), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        // Dots are dropped so "B.Sc", "BSc" and "bsc" are the same word.
        return array_values(array_unique(array_filter(array_map(fn (string $word): string => str_replace('.', '', $word), $words))));
    }

    /**
     * Lowercase, with the spelling variants of 'variants' folded ("Wi-Fi" -> "wifi").
     */
    private function fold(string $text): string
    {
        return strtr(mb_strtolower($text), $this->content->get('voice-assistant')['variants']);
    }

    private function plain(string $html): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }
}
