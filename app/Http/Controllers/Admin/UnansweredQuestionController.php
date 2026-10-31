<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssistantMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UnansweredQuestionController extends Controller
{
    public function index(): View
    {
        return view('admin.unanswered', [
            'messages' => AssistantMessage::query()
                ->where('status', AssistantMessage::STATUS_UNANSWERED)->whereNull('resolved_at')
                ->latest('id')->paginate(25),
        ]);
    }

    public function dismiss(AssistantMessage $message): RedirectResponse
    {
        $message->update(['resolved_at' => now()]);

        return back()->with('status', 'Question dismissed.');
    }
}
