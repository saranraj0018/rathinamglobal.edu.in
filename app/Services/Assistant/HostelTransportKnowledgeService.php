<?php

namespace App\Services\Assistant;

/**
 * Service to load, parse, and search the verified Rathinam Hostel & Transport knowledge base.
 * Source: storage/app/knowledge/hostel_transport.md (extracted from Hostel_Transport.pdf).
 */
class HostelTransportKnowledgeService
{
    /**
     * @var list<array{number: int, section: string, question: string, answer: string, keywords: list<string>, search_text: string}>|null
     */
    private static ?array $cachedFaqs = null;

    public function __construct(
        private TextNormalizer $normalizer,
    ) {}

    /**
     * Determine if a user question is related to Rathinam hostel or transport facilities.
     */
    public function isHostelOrTransportQuestion(string $query): bool
    {
        $patterns = [
            // Hostel, accommodation, staying
            '/\b(hostel|hostal|accommodation|viduthi|vidudhi)\b/iu',
            '/விடுதி|தங்குமிடம்/u',
            // Room types, occupancy, roommates, furniture
            '/\b(room|rooms|sharing|dormitory|roommate|roommates|bed|beds|furniture|cupboard|luggage)\b/iu',
            '/அறை|படுக்கை/u',
            // Facilities: wifi, hot water, bathroom
            '/\b(wi-?fi|wifi|internet|hot\s*water|geyser|warm\s*water|attached\s*bathroom|bathroom|washroom|toilet)\b/iu',
            '/இணையம்|சுடு\s*தண்ணீர்|குளியலறை/u',
            // Food, mess, dining
            '/\b(food|mess|canteen|dining|veg|non-?veg|vegetarian|housekeeping|laundry)\b/iu',
            '/சாப்பாடு|உணவு|உணவகம்|துணி/u',
            // Rules, timing, visits, attendance, safety, medical
            '/\b(curfew|in-time|out-time|study\s*hours|outing|parent\s*visit|visiting\s*hours|attendance|absent|absenteeism|warden|wardens)\b/iu',
            '/\b(cctv|surveillance|security|first-aid|medical|hospital|emergency\s*transport|ambulance)\b/iu',
            '/பாதுகாப்பு|மருத்துவம்|விதிமுறை|வருகை/u',
            // Transport, buses, routes, timings
            '/\b(transport|bus|buses|busses|van|route|routes|pickup|drop|bus\s*pass|pass|driver|drivers|fire\s*extinguisher)\b/iu',
            '/பேருந்து|போக்குவரத்து/u',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $query) === 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve matching hostel/transport FAQ chunks for a user question.
     *
     * @return list<RetrievedChunk>
     */
    public function search(string $query, int $limit = 3, float $minScore = 0.25): array
    {
        if (! $this->isHostelOrTransportQuestion($query)) {
            return [];
        }

        $units = $this->normalizer->units($query);
        if ($units === []) {
            // Check for direct regex-based concept hit if normalizer stripped words
            if (preg_match('/\b(hostel|viduthi)\b/iu', $query) === 1) {
                $faq1 = $this->faq(1);
                if ($faq1 !== null) {
                    return [new RetrievedChunk(1, 'knowledge_document', 1, $faq1['question'], "Question: {$faq1['question']}\nAnswer: {$faq1['answer']}", 1.0)];
                }
            }
            if (preg_match('/\b(transport|bus|பேருந்து)\b/iu', $query) === 1) {
                $faq24 = $this->faq(24);
                if ($faq24 !== null) {
                    return [new RetrievedChunk(24, 'knowledge_document', 24, $faq24['question'], "Question: {$faq24['question']}\nAnswer: {$faq24['answer']}", 1.0)];
                }
            }

            return [];
        }

        $queryLower = mb_strtolower($query);
        $faqs = $this->allFaqs();
        $scored = [];

        foreach ($faqs as $faq) {
            $score = $this->scoreFaq($units, $queryLower, $faq);
            if ($score >= $minScore) {
                $content = "Question: {$faq['question']}\nAnswer: {$faq['answer']}";
                $scored[] = new RetrievedChunk(
                    $faq['number'],
                    'knowledge_document',
                    $faq['number'],
                    $faq['question'],
                    $content,
                    $score
                );
            }
        }

        usort($scored, fn (RetrievedChunk $a, RetrievedChunk $b): int => $b->score <=> $a->score);

        if ($scored === []) {
            return [];
        }

        $bestScore = $scored[0]->score;
        $filtered = array_filter($scored, fn (RetrievedChunk $c): bool => $c->score >= $bestScore * 0.7);

        return array_slice(array_values($filtered), 0, $limit);
    }

    /**
     * Compute a match score between query search units and a FAQ item.
     *
     * @param  list<array{stems: list<string>, weight: int, concept: bool}>  $units
     * @param  array{number: int, section: string, question: string, answer: string, keywords: list<string>, search_text: string}  $faq
     */
    private function scoreFaq(array $units, string $queryLower, array $faq): float
    {
        // Ignore queries with subjects definitely not in the hostel/transport document
        if (preg_match('/\b(fees?|cost|tuition|charges?|rent|price|swimming|pool|helicopter|flight|airport|pets?|fridge|refrigerator|cooler)\b|கட்டணம்|வாடகை/iu', $queryLower) === 1) {
            return 0.0;
        }

        $auxiliaryWords = [
            'panna', 'pannunga', 'mudiyuma', 'kedaikuma', 'kidaikuma', 'vazhanga', 'theriyuma', 'iruka', 'irukka', 'irukku',
            'வழங்க', 'முடியுமா', 'கிடைக்குமா', 'செல்ல', 'செய்ய', 'போக', 'உள்ளதா', 'இருக்கிறதா', 'இருக்கா', 'தருகிறார்களா',
        ];

        $synonyms = [
            'உணவு' => ['food', 'unavu', 'saapadu', 'சாப்பாடு', 'சாப்ப'],
            'சாப்ப' => ['food', 'unavu', 'saapadu', 'உணவு'],
            'துணி' => ['laundry', 'clothes', 'washing', 'துவை'],
            'துவை' => ['laundry', 'washing', 'துணி'],
            'இணைய' => ['wifi', 'wi-fi', 'internet'],
        ];

        $faqStems = $this->normalizer->stemSet($faq['search_text']);
        $totalWeight = 0;
        $matchedWeight = 0;
        $totalSpecificCount = 0;
        $matchedSpecificCount = 0;

        foreach ($units as $unit) {
            $totalWeight += $unit['weight'];
            $firstStem = $unit['stems'][0] ?? '';
            $isAuxiliary = in_array($firstStem, $auxiliaryWords, true);
            $isSpecific = ! $unit['concept'] && ! $isAuxiliary;
            if ($isSpecific) {
                $totalSpecificCount++;
            }

            $isMatched = false;
            foreach ($unit['stems'] as $stem) {
                if (isset($faqStems[$stem])) {
                    $isMatched = true;
                    break;
                }
                if (isset($synonyms[$stem])) {
                    foreach ($synonyms[$stem] as $syn) {
                        if (isset($faqStems[$syn])) {
                            $isMatched = true;
                            break 2;
                        }
                    }
                }
            }

            if ($isMatched) {
                $matchedWeight += $unit['weight'];
                if ($isSpecific) {
                    $matchedSpecificCount++;
                }
            }
        }

        if ($totalWeight === 0) {
            return 0.0;
        }

        // When the question mentions specific non-auxiliary subjects, require matching coverage
        if ($totalSpecificCount > 0 && $matchedSpecificCount === 0) {
            return 0.0;
        }

        $baseScore = $matchedWeight / $totalWeight;

        // Specialized keyword/phrase boosters to ensure unambiguous FAQ targeting
        $bonus = 0.0;
        $qText = mb_strtolower($faq['question']);
        $aText = mb_strtolower($faq['answer']);

        // Wi-Fi
        if (preg_match('/\b(wi-?fi|wifi|internet)\b|இணையம்/iu', $queryLower) === 1 && $faq['number'] === 7) {
            $bonus += 0.6;
        }
        // Roommate
        if (preg_match('/\b(roommate|roommates|choose\s*room)\b/iu', $queryLower) === 1 && $faq['number'] === 23) {
            $bonus += 0.6;
        }
        // Hot water
        if (preg_match('/\b(hot\s*water|geyser|warm\s*water)\b|சுடு\s*தண்ணீர்/iu', $queryLower) === 1 && $faq['number'] === 8) {
            $bonus += 0.6;
        }
        // Bathroom / Toilet
        if (preg_match('/\b(attached|bathroom|washroom|toilet)\b|குளியலறை/iu', $queryLower) === 1 && $faq['number'] === 9) {
            $bonus += 0.6;
        }
        // Laundry / Washing clothes
        if (preg_match('/\b(laundry|washing|dhobi)\b|துணி/iu', $queryLower) === 1 && $faq['number'] === 12) {
            $bonus += 0.6;
        }
        // Housekeeping / Cleaning
        if (preg_match('/\b(housekeeping|cleaning)\b/iu', $queryLower) === 1 && $faq['number'] === 13) {
            $bonus += 0.6;
        }
        // Furniture / Bed / Chair / Table
        if (preg_match('/\b(furniture|beds?|tables?|chairs?|cupboards?|storage)\b/iu', $queryLower) === 1 && $faq['number'] === 6) {
            $bonus += 0.6;
        }
        // Sharing / Room types (2-sharing, 4-sharing)
        if (preg_match('/\b(type|types|category|categories|sharing|dormitory)\b/iu', $queryLower) === 1 && $faq['number'] === 4) {
            $bonus += 0.5;
        }
        // Room capacity (how many students)
        if (preg_match('/\b(how\s*many|students|capacity|stay)\b/iu', $queryLower) === 1 && $faq['number'] === 5) {
            $bonus += 0.5;
        }
        // Food / Veg / Non-veg
        if ((preg_match('/\b(food|mess|veg|non-?veg|vegetarian|saapadu|unavu)\b/iu', $queryLower) === 1 || preg_match('/உணவு|சாப்பாடு/u', $queryLower) === 1)
            && preg_match('/\b(outside|delivery|order|zomato|swiggy)\b/iu', $queryLower) === 0
            && $faq['number'] === 10) {
            $bonus += 0.6;
        }
        // Food quality / Hygiene
        if (preg_match('/\b(quality|hygiene|inspection)\b/iu', $queryLower) === 1 && $faq['number'] === 11) {
            $bonus += 0.6;
        }
        // Outside food / Delivery
        if (preg_match('/\b(outside|delivery|order|zomato|swiggy)\b/iu', $queryLower) === 1 && $faq['number'] === 22) {
            $bonus += 0.7;
        }
        // Study hours
        if (preg_match('/\b(study\s*hours|study\s*time)\b/iu', $queryLower) === 1 && $faq['number'] === 14) {
            $bonus += 0.6;
        }
        // In-time / Out-time
        if (preg_match('/\b(in-time|out-time|gate\s*timing)\b/iu', $queryLower) === 1 && $faq['number'] === 15) {
            $bonus += 0.5;
        }
        // Weekends / Sunday outing
        if (preg_match('/\b(weekend|weekends|sunday|outing|go\s*home)\b/iu', $queryLower) === 1 && $faq['number'] === 16) {
            $bonus += 0.6;
        }
        // Parents visit
        if (preg_match('/\b(parents?|visitors?|visiting)\b/iu', $queryLower) === 1 && $faq['number'] === 17) {
            $bonus += 0.6;
        }
        // Safety in hostel
        if (preg_match('/\b(safety|security|warden)\b/iu', $queryLower) === 1
            && preg_match('/\b(bus|buses|transport|driver|gps|van|பேருந்து)\b/iu', $queryLower) === 0
            && $faq['number'] === 18) {
            $bonus += 0.6;
        }
        // Attendance
        if (preg_match('/\b(attendance|roll\s*call)\b/iu', $queryLower) === 1 && $faq['number'] === 19) {
            $bonus += 0.6;
        }
        // Absent / Inform parents
        if (preg_match('/\b(absent|absenteeism|inform\s*parents)\b/iu', $queryLower) === 1 && $faq['number'] === 20) {
            $bonus += 0.6;
        }
        // Medical / Hospital / First-aid
        if (preg_match('/\b(medical|hospital|doctor|first-aid|ambulance)\b/iu', $queryLower) === 1 && $faq['number'] === 21) {
            $bonus += 0.6;
        }
        // Transport general
        if (preg_match('/\b(transport|bus\s*facility|buses)\b/iu', $queryLower) === 1 && $faq['number'] === 24) {
            $bonus += 0.5;
        }
        // Routes / Areas covered
        if (preg_match('/\b(routes?|areas?|stops?|coverage)\b/iu', $queryLower) === 1 && $faq['number'] === 25) {
            $bonus += 0.6;
        }
        // Morning pickup timings (6:45 AM, 8:05 AM)
        if (preg_match('/\b(morning|pickup|pick\s*up|morning\s*timing|kaalai)\b/iu', $queryLower) === 1 && $faq['number'] === 26) {
            $bonus += 0.6;
        }
        // Reach campus time (8:45 AM)
        if (preg_match('/\b(reach|arrival|reach\s*campus|reach\s*college|reach\s*time)\b/iu', $queryLower) === 1 && $faq['number'] === 27) {
            $bonus += 0.6;
        }
        // Evening drop timings (4:45 PM, 5:00 PM)
        if (preg_match('/\b(evening|drop|return|drop\s*timing|maalai)\b/iu', $queryLower) === 1 && $faq['number'] === 28) {
            $bonus += 0.6;
        }
        // Bus pass
        if (preg_match('/\b(pass|bus\s*pass|ticket)\b/iu', $queryLower) === 1 && $faq['number'] === 29) {
            $bonus += 0.6;
        }
        // Bus safety (GPS, CCTV, fire extinguisher, drivers)
        if (preg_match('/\b(bus|buses|transport|van|பேருந்து)\b/iu', $queryLower) === 1
            && preg_match('/\b(safety|gps|cctv|fire\s*extinguisher|driver|drivers|features?)\b/iu', $queryLower) === 1
            && $faq['number'] === 30) {
            $bonus += 0.7;
        }

        return min(1.0, $baseScore + $bonus);
    }

    /**
     * Clear in-memory cached FAQs.
     */
    public static function clearCache(): void
    {
        self::$cachedFaqs = null;
    }

    /**
     * Get all 30 FAQs parsed from storage/app/knowledge/hostel_transport.md.
     *
     * @return list<array{number: int, section: string, question: string, answer: string, keywords: list<string>, search_text: string}>
     */
    public function allFaqs(): array
    {
        if (self::$cachedFaqs !== null) {
            return self::$cachedFaqs;
        }

        $path = storage_path('app/knowledge/hostel_transport.md');
        if (! file_exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        if ($content === false) {
            return [];
        }

        $lines = explode("\n", $content);
        $faqs = [];
        $currentSection = 'General';
        $currentFaq = null;

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (str_starts_with($trimmed, '## ')) {
                $currentSection = trim(substr($trimmed, 3));

                continue;
            }

            if (preg_match('/^###\s*Q(\d+)\.\s*(.+)$/u', $trimmed, $matches) === 1) {
                if ($currentFaq !== null) {
                    $currentFaq['search_text'] = "{$currentFaq['question']} {$currentFaq['answer']} ".implode(' ', $currentFaq['keywords'])." {$currentFaq['section']}";
                    $faqs[] = $currentFaq;
                }

                $currentFaq = [
                    'number' => (int) $matches[1],
                    'section' => $currentSection,
                    'question' => trim($matches[2]),
                    'answer' => '',
                    'keywords' => [],
                    'search_text' => '',
                ];

                continue;
            }

            if ($currentFaq !== null && preg_match('/^\*\*Answer:\*\*\s*(.+)$/u', $trimmed, $matches) === 1) {
                $currentFaq['answer'] = trim($matches[1]);

                continue;
            }

            if ($currentFaq !== null && preg_match('/^\*\*Keywords:\*\*\s*(.+)$/u', $trimmed, $matches) === 1) {
                $keywords = array_map('trim', explode(',', $matches[1]));
                $currentFaq['keywords'] = array_values(array_filter($keywords));

                continue;
            }
        }

        if ($currentFaq !== null) {
            $currentFaq['search_text'] = "{$currentFaq['question']} {$currentFaq['answer']} ".implode(' ', $currentFaq['keywords'])." {$currentFaq['section']}";
            $faqs[] = $currentFaq;
        }

        self::$cachedFaqs = $faqs;

        return $faqs;
    }

    /**
     * Build the session-scoped, voice-friendly facts sent with native Live setup.
     * Search keywords are included as understanding cues and must never be spoken.
     */
    public function liveSessionContext(): string
    {
        $faqs = $this->allFaqs();
        if ($faqs === []) {
            return '';
        }

        $lines = [
            'Verified Rathinam Global University hostel and transport information.',
            'Match each topic and its question cues even when students use English, broken English, slang, shorthand, incomplete sentences, Tanglish, or Tamil. Natural forms include the original question, short fragments, mixed-language forms ending in “irukka?” or “available ah?”, and Tamil phrasing such as “இதுகுறித்து சொல்ல முடியுமா?” or “இருக்கா?”. Keywords are matching cues, not content to read aloud.',
            'Answer only with the verified answer attached to the matching topic. Do not infer other university policies, facilities, fees, routes, timings, staff names, or contact details.',
            'If a university-specific detail is not stated here, say naturally in the student’s language that you do not have confirmed information and suggest checking with the hostel or transport office. Never guess.',
            '',
        ];

        foreach ($faqs as $faq) {
            $lines[] = "Topic: {$faq['section']} — {$faq['question']}";
            $lines[] = 'Question cues: '.implode('; ', $faq['keywords']);
            $lines[] = "Verified answer: {$faq['answer']}";
            $lines[] = '';
        }

        return trim(implode("\n", $lines));
    }

    /**
     * Retrieve a specific FAQ by number (1 to 30).
     *
     * @return array{number: int, section: string, question: string, answer: string, keywords: list<string>, search_text: string}|null
     */
    public function faq(int $number): ?array
    {
        foreach ($this->allFaqs() as $faq) {
            if ($faq['number'] === $number) {
                return $faq;
            }
        }

        return null;
    }
}
