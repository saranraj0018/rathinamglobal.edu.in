<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * Events: the listing comes from resources/data/events.php and each event's
 * bilingual (English / Tamil) detail from resources/data/events/{slug}.php.
 */
class EventController extends Controller
{
    public function __construct(private ContentRepository $content) {}

    public function index(): View
    {
        return view('events.index', ['events' => $this->content->get('events')]);
    }

    public function show(string $event): View
    {
        $listing = collect($this->content->get('events'))->firstWhere('slug', $event);

        abort_if($listing === null || ! $this->content->has("events/{$event}"), 404);

        $detail = $this->content->get("events/{$event}");

        return view('events.show', [
            'event' => $detail,
            'listing' => $listing,
            'languages' => ['en' => $detail['en'], 'ta' => $detail['ta']],
            'logoUrl' => storage_asset('events/'.$listing['logo']),
        ]);
    }
}
