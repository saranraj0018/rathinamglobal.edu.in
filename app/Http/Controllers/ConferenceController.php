<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * DSACB 2027 — International Conference on Driving Sustainability through AI,
 * Climate Resilience and Behavioural Sciences (/dsacb).
 */
class ConferenceController extends Controller
{
    public function __invoke(ContentRepository $content): View
    {
        return view('dsacb.index', $content->viewData('dsacb'));
    }
}
