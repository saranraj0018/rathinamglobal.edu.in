<?php

namespace App\Services\Assistant;

/**
 * Language detection and query normalisation for Tamil, English and Tanglish
 * (Tamil written in English letters).
 *
 * Normalisation never rewrites what the visitor said: it only turns a text
 * into search units. Each unit is a set of interchangeable spellings of one
 * idea ("fees" = kattanam = கட்டணம்), so a Tanglish question can match an
 * English or Tamil FAQ without anything being translated.
 */
class TextNormalizer
{
    public const TAMIL = 'ta';

    public const ENGLISH = 'en';

    public const TANGLISH = 'tanglish';

    /**
     * Interchangeable spellings of the same concept (English, Tanglish, Tamil).
     *
     * @var array<string, list<string>>
     */
    private const CONCEPTS = [
        'fees' => ['fee', 'fees', 'cost', 'tuition', 'kattanam', 'katanam', 'kattana', 'katthanam', 'கட்டணம்', 'கட்டண', 'செலவு'],
        'course' => ['course', 'courses', 'program', 'programme', 'programs', 'programmes', 'degree', 'padippu', 'padipu', 'padippugal', 'paadam', 'படிப்பு', 'படிப்புகள்', 'பாடம்', 'பாடப்பிரிவு'],
        'admission' => ['admission', 'admissions', 'apply', 'application', 'enroll', 'enrol', 'join', 'serkkai', 'sarkai', 'serkai', 'sergai', 'சேர்க்கை', 'சேர'],
        'eligibility' => ['eligibility', 'eligible', 'qualification', 'qualifications', 'criteria', 'thaguthi', 'thagudhi', 'thaguti', 'தகுதி'],
        'placement' => ['placement', 'placements', 'job', 'jobs', 'recruiter', 'recruiters', 'salary', 'package', 'velai', 'velaivaaippu', 'velaivaipu', 'வேலை', 'வேலைவாய்ப்பு'],
        'hostel' => ['hostel', 'hostal', 'accommodation', 'viduthi', 'vidudhi', 'விடுதி'],
        'scholarship' => ['scholarship', 'scholarships', 'upakarasambalam', 'ubakarasambalam', 'உதவித்தொகை'],
        'facility' => ['facility', 'facilities', 'amenities', 'vasathi', 'vasadhi', 'vasathigal', 'வசதி', 'வசதிகள்'],
        'contact' => ['contact', 'phone', 'mobile', 'email', 'address', 'thodarbu', 'tholaipesi', 'mugavari', 'தொடர்பு', 'தொலைபேசி', 'முகவரி'],
        'date' => ['date', 'deadline', 'when', 'kadaisi', 'thethi', 'theti', 'தேதி', 'கடைசி'],
        'location' => ['location', 'where', 'enga', 'engae', 'idam', 'இடம்', 'எங்கே'],
        'howmuch' => ['evlo', 'evvalavu', 'evalo', 'எவ்வளவு', 'எவ்ளோ'],
        'transport' => ['transport', 'bus', 'busses', 'pasu', 'பேருந்து'],
    ];

    /** Words used only when writing Tamil in English letters. */
    private const TANGLISH_MARKERS = [
        'enna', 'evlo', 'evvalavu', 'irukku', 'iruku', 'irukka', 'iruka', 'venum', 'vendum', 'epdi', 'eppadi', 'sollunga',
        'sollu', 'pannunga', 'panna', 'padippu', 'kattanam', 'serkkai', 'sarkai', 'velai', 'viduthi', 'thaguthi', 'engey',
        'enga', 'unga', 'ungal', 'yenna', 'yeppadi', 'irukkum', 'kudu', 'kudunga', 'theriyuma', 'solunga', 'illa', 'ennanu',
        'eppo', 'epo', 'edhu', 'enakku', 'nanga', 'naan', 'ungalukku', 'vanakkam', 'nandri', 'sari', 'padikka',
    ];

    private const STOPWORDS = [
        'the', 'is', 'are', 'a', 'an', 'of', 'in', 'on', 'at', 'to', 'for', 'and', 'or', 'what', 'about', 'tell', 'me', 'please',
        'there', 'any', 'do', 'does', 'can', 'i', 'you', 'your', 'my', 'how', 'which', 'who', 'with', 'be', 'it', 'this', 'that',
        'college', 'university', 'rathinam', 'rgu', 'enna', 'irukku', 'iruku', 'irukka', 'iruka', 'ah', 'aa', 'la', 'ku', 'kku',
        'ungal', 'unga', 'enga', 'nanga', 'sollunga', 'solunga', 'pannunga', 'venum', 'vendum', 'theriyuma', 'illa', 'ennanu',
        'என்ன', 'உள்ளது', 'இருக்கு', 'உங்கள்', 'உங்க', 'கல்லூரி', 'பற்றி', 'சொல்லுங்கள்', 'சொல்லுங்க', 'தயவுசெய்து', 'ரத்தினம்',
    ];

    private const GREETINGS = [
        'hi', 'hello', 'hey', 'hii', 'helo', 'vanakkam', 'vanakam', 'வணக்கம்', 'good morning', 'good evening', 'good afternoon',
        'thanks', 'thank you', 'nandri', 'நன்றி', 'ok', 'okay',
    ];

    public function detectLanguage(string $text): string
    {
        $letters = preg_match_all('/\p{L}/u', $text);
        $tamil = preg_match_all('/\p{Tamil}/u', $text);

        if ($letters > 0 && $tamil / $letters >= 0.3) {
            return self::TAMIL;
        }

        $words = $this->words($text);

        return array_intersect($words, self::TANGLISH_MARKERS) !== [] ? self::TANGLISH : self::ENGLISH;
    }

    public function isGreeting(string $text): bool
    {
        $clean = trim(preg_replace('/[^\p{L}\s]/u', '', mb_strtolower($text)) ?? '');

        return in_array($clean, self::GREETINGS, true);
    }

    /**
     * @return list<string>
     */
    public function words(string $text): array
    {
        preg_match_all('/[\p{L}\p{M}\p{N}]+/u', mb_strtolower($text), $matches);

        return $matches[0];
    }

    /**
     * Search units for a text: each unit is a set of stems of which any one counts as a hit.
     *
     * @return list<array{stems: list<string>, weight: int, concept: bool}>
     */
    public function units(string $text): array
    {
        $units = [];
        $seen = [];

        foreach ($this->words($text) as $word) {
            if (in_array($word, self::STOPWORDS, true) || mb_strlen($word) < 2) {
                continue;
            }

            $concept = $this->conceptOf($word);
            $key = $concept ?? $this->stem($word);

            if (isset($seen[$key])) {
                continue;
            }

            $seen[$key] = true;
            $stems = $concept !== null
                ? array_values(array_unique(array_map($this->stem(...), self::CONCEPTS[$concept])))
                : [$this->stem($word)];

            $units[] = ['stems' => $stems, 'weight' => $concept !== null ? 1 : 2, 'concept' => $concept !== null];
        }

        return $units;
    }

    /**
     * Distinct stems of every word in a text, for matching against search units.
     *
     * @return array<string, true>
     */
    public function stemSet(string $text): array
    {
        $set = [];

        foreach ($this->words($text) as $word) {
            $set[$this->stem($word)] = true;
        }

        return $set;
    }

    /**
     * Tamil words are heavily inflected (கட்டணம் / கட்டணத்தை), so their first
     * characters stand in for the word; other words are matched whole.
     */
    public function stem(string $word): string
    {
        if (preg_match('/\p{Tamil}/u', $word) && mb_strlen($word) > 5) {
            return mb_substr($word, 0, 5);
        }

        return $word;
    }

    private function conceptOf(string $word): ?string
    {
        $tamil = (bool) preg_match('/\p{Tamil}/u', $word);

        foreach (self::CONCEPTS as $concept => $variants) {
            if (in_array($word, $variants, true)) {
                return $concept;
            }

            // Inflected Tamil forms (கட்டணத்தை) share the stem of the listed word.
            if ($tamil && array_filter($variants, fn (string $v): bool => preg_match('/\p{Tamil}/u', $v) && $this->stem($v) === $this->stem($word)) !== []) {
                return $concept;
            }
        }

        return null;
    }
}
