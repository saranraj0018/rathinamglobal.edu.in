<?php

namespace Tests\Feature\Assistant;

use App\Services\Assistant\TextNormalizer;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TextNormalizerTest extends TestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function languages(): array
    {
        return [
            'english' => ['What is the BCA fee?', 'en'],
            'tamil' => ['BCA கட்டணம் என்ன?', 'ta'],
            'tanglish' => ['BCA fees evlo irukku', 'tanglish'],
            'tanglish hostel' => ['hostel vasathi irukka', 'tanglish'],
        ];
    }

    #[DataProvider('languages')]
    public function test_detects_language(string $text, string $expected): void
    {
        $this->assertSame($expected, (new TextNormalizer)->detectLanguage($text));
    }

    public function test_equivalent_spellings_become_the_same_search_unit(): void
    {
        $normalizer = new TextNormalizer;
        $english = $normalizer->units('fees')[0]['stems'];

        $this->assertSame($english, $normalizer->units('kattanam')[0]['stems']);
        $this->assertSame($english, $normalizer->units('கட்டணம்')[0]['stems']);
        $this->assertSame($english, $normalizer->units('கட்டணத்தை')[0]['stems'], 'inflected Tamil form');
    }

    public function test_the_visitor_text_is_not_rewritten(): void
    {
        $units = (new TextNormalizer)->units('BCA kattanam evlo');

        $this->assertSame(['bca'], $units[0]['stems']);
        $this->assertCount(3, $units);
    }
}
