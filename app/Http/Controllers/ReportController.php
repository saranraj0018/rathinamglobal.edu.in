<?php

namespace App\Http\Controllers;

use App\Support\ContentRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Internal reporting area (/report): the dashboard map and the embedded
 * Looker Studio dashboards listed in resources/data/reports.php.
 */
class ReportController extends Controller
{
    private const JOB_DESCRIPTION = 'reports/job-description.html';

    public function index(): View
    {
        return view('reports.index');
    }

    public function show(string $group, string $dashboard, ContentRepository $content): View
    {
        $entry = $content->get('reports')[$group][$dashboard] ?? null;

        abort_if($entry === null, 404);

        return view('reports.dashboard', ['dashboard' => $entry]);
    }

    /**
     * "University Leadership – Deans & JD Tiles": a self-contained HTML export
     * (≈5 MB with inlined images), served as-is from the private disk.
     */
    public function jobDescription(): BinaryFileResponse
    {
        $disk = Storage::disk('local');

        abort_unless($disk->exists(self::JOB_DESCRIPTION), 404);

        return response()->file($disk->path(self::JOB_DESCRIPTION), [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }
}
