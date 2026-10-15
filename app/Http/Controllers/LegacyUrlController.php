<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Fallback for addresses of the old core-PHP site, so bookmarks and search
 * results keep working:
 *
 *   /research/patents.php, /law/index.html, /eoa/eoa.php  -> 301 to the clean URL
 *   /assets/brouchure.pdf, /esg/images/logo-rgu.png       -> 301 to /storage/...
 *
 * Anything else is a 404.
 */
class LegacyUrlController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $path = trim(rawurldecode($request->path()), '/');

        abort_if($path === '' || str_contains($path, '..') || str_contains($path, "\0"), 404);

        $clean = preg_replace(['#(^|/)index\.(php|html?)$#i', '#\.(php|html?)$#i'], ['', ''], $path);

        if ($clean !== $path && $this->isPage($clean)) {
            return $this->redirect(url($clean), $request);
        }

        $disk = Storage::disk('public');

        if (is_file($disk->path($path))) {
            return $this->redirect(storage_asset($path), $request);
        }

        abort(404);
    }

    private function isPage(string $path): bool
    {
        try {
            $route = Route::getRoutes()->match(Request::create('/'.$path, 'GET'));
        } catch (HttpException) {
            return false;
        }

        return ! $route->isFallback;
    }

    private function redirect(string $target, Request $request): RedirectResponse
    {
        $query = $request->getQueryString();

        if ($query !== null && ! str_contains($target, '?')) {
            $target .= '?'.$query;
        }

        return redirect()->to($target, 301);
    }
}
