<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssistantSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', ['contact' => AssistantSetting::valueOf('admissions_contact')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(['admissions_contact' => ['required', 'string', 'max:500']]);

        AssistantSetting::put('admissions_contact', $data['admissions_contact']);

        return back()->with('status', 'Settings saved.');
    }
}
