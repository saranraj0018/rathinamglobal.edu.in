<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * Frequently asked questions (/faq), grouped by category, from
 * resources/data/faqs.php — the same file the homepage preview reads.
 */
class FaqController extends Controller
{
    public function __invoke(ContentRepository $content): View
    {
        $categories = $content->get('faqs');

        return view('faq.index', [
            'categories' => $categories,
            'structuredData' => $this->structuredData($categories),
        ]);
    }

    /**
     * schema.org FAQPage markup for search engines.
     *
     * @param  array<int, array{items: array<int, array{q: string, a: string}>}>  $categories
     * @return array<string, mixed>
     */
    private function structuredData(array $categories): array
    {
        $plain = fn (string $html): string => trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $questions = [];

        foreach ($categories as $category) {
            foreach ($category['items'] as $item) {
                $questions[] = [
                    '@type' => 'Question',
                    'name' => $plain($item['q']),
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => $plain($item['a'])],
                ];
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $questions,
        ];
    }
}
