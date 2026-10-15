<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * AICTE Extension of Approval (EOA) letters, one PDF per academic year.
 */
class ExtensionOfApprovalController extends Controller
{
    private const FIRST_YEAR = 2010;

    private const LAST_YEAR = 2025;

    public function __invoke(): View
    {
        $disk = Storage::disk('public');
        $approvals = [];

        foreach (range(self::FIRST_YEAR, self::LAST_YEAR) as $year) {
            $path = "assets/EOA/EOA-{$year}.pdf";
            $approvals[$year] = $disk->exists($path) ? storage_asset($path) : null;
        }

        return view('eoa.index', ['approvals' => $approvals]);
    }
}
