<?php

if (! function_exists('storage_asset')) {
    /**
     * Public URL for an image, PDF or video on the "public" storage disk
     * (served via the public/storage symlink).
     */
    function storage_asset(string $path): string
    {
        $encoded = implode('/', array_map('rawurlencode', explode('/', ltrim($path, '/'))));

        return asset('storage/'.$encoded);
    }
}

if (! function_exists('versioned_asset')) {
    /**
     * URL for a stylesheet or script in public/ with a ?v=<mtime> stamp,
     * because the web server caches them for a year.
     */
    function versioned_asset(string $path): string
    {
        $path = ltrim($path, '/');
        $modified = @filemtime(public_path($path));

        return asset($path).($modified !== false ? '?v='.$modified : '');
    }
}
