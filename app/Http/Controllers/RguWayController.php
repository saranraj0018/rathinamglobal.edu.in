<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * "The RGU Way" landing page (/rgu-way). Section content lives in
 * resources/data/rgu-way.php; markup in resources/views/rgu-way/partials.
 */
class RguWayController extends Controller
{
    public function __invoke(ContentRepository $content): View
    {
        return view('rgu-way.index', $content->viewData('rgu-way'));
    }
}
