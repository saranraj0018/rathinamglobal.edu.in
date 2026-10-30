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
 * The assistant gives the AI the whole catalogue() to choose entries from; no
 * keyword matching is done here. Callers only depend on the returned entry shape.
 *
 * @phpstan-type Entry array{id: string, category: string, title: string, question: string, answer: string, answer_ta?: string, also_asked?: array<int, string>, route?: string, url: string}
 */
class KnowledgeBase
{
    /**
     * Degree names inside school data files ("B.Sc Computer Science", "MBA ...").
     */
    private const DEGREE_PATTERN = '/^(?:[BM]\.\s?(?:Sc|E|Tech|Com|A|Des|Voc|Arch|Pharm|Lib|Ed)\b|BBA|MBA|BCA|MCA|BPT|MPT|B\.?Des|Ph\.?\s?D)/u';

    /**
     * @var array<int, Entry>|null
     */
    private ?array $entries = null;

    /**
     * @var array<string, array<int, string>>
     */
    private array $programmes = [];

    private ?string $fingerprint = null;

    public function __construct(private ContentRepository $content, private SiteContent $site) {}

    /**
     * Changes whenever any approved content (FAQ, facts, schools, pages, messages, personas) changes,
     * so cached picks and answers made from older content are never served.
     */
    public function fingerprint(): string
    {
        return $this->fingerprint ??= sha1((string) json_encode([$this->entries(), $this->content->get('voice-assistant')]));
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

        // Curated entries first: they keep their place when questions repeat.
        $entries = [...$this->factEntries(), ...$this->faqEntries(), ...$this->schoolEntries(), ...$this->degreeEntries(), ...$this->site->entries()];

        // The FAQ repeats a few questions across categories; keep the first.
        $unique = [];

        foreach ($entries as $entry) {
            $unique[mb_strtolower($entry['question'])] ??= $entry;
        }

        $this->entries = array_values($unique);

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

    private function plain(string $html): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    }
}
