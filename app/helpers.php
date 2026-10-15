<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('storage_asset')) {
    /**
     * Public URL for a file on the "public" storage disk (served via the
     * public/storage symlink). Stylesheets and scripts get a ?v=<mtime>
     * stamp, because the web server caches them for a year.
     */
    function storage_asset(string $path): string
    {
        $path = ltrim($path, '/');
        $encoded = implode('/', array_map('rawurlencode', explode('/', $path)));
        $url = asset('storage/'.$encoded);

        if (in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), ['css', 'js'], true)) {
            $modified = @filemtime(Storage::disk('public')->path($path));

            if ($modified !== false) {
                $url .= '?v='.$modified;
            }
        }

        return $url;
    }
}
