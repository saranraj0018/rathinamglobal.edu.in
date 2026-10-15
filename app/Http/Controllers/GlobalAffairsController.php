<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * Office of Global Affairs (/global-affairs). Copy lives in
 * resources/data/global-affairs.php; markup in resources/views/global-affairs.
 */
class GlobalAffairsController extends Controller
{
    public function __invoke(ContentRepository $content): View
    {
        return view('global-affairs.index', $content->viewData('global-affairs'));
    }
}
