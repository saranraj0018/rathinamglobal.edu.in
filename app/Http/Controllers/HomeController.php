<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use App\Support\CriticalCss;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(ContentRepository $content, CriticalCss $criticalCss): View
    {
        $home = $content->get('home');

        return view('home.index', [
            'criticalCss' => $criticalCss->inline(),
            'tvVideos' => $home['tv_videos'],
            'galleryRows' => $home['gallery_rows'],
            'galleryDimensions' => $home['gallery_dimensions'],
            'faqPreview' => $this->faqPreview($content->get('faqs'), $home['faq_preview']),
        ]);
    }

    /**
     * @param  array<int, array{id: string, label: string, items: array<int, array{q: string, a: string}>}>  $categories
     * @param  array<int, array{0: string, 1: int}>  $picks
     * @return array<int, array{label: string, q: string, a: string}>
     */
    private function faqPreview(array $categories, array $picks): array
    {
        $byId = array_column($categories, null, 'id');
        $preview = [];

        foreach ($picks as [$categoryId, $index]) {
            if (isset($byId[$categoryId]['items'][$index])) {
                $preview[] = [
                    'label' => $byId[$categoryId]['label'],
                    'q' => $byId[$categoryId]['items'][$index]['q'],
                    'a' => $byId[$categoryId]['items'][$index]['a'],
                ];
            }
        }

        return $preview;
    }
}
