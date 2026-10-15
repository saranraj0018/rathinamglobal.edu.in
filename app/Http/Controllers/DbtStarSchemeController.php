<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\View\View;

/**
 * DBT Star College Scheme (/dbt-star-scheme), from resources/data/dbt-star-scheme.php.
 */
class DbtStarSchemeController extends Controller
{
    public function __invoke(ContentRepository $content): View
    {
        return view('dbt-star-scheme.index', $content->viewData('dbt-star-scheme'));
    }
}
