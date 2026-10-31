<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssistantConversation;
use App\Models\AssistantFeedback;
use App\Models\AssistantMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $messages = AssistantMessage::query();

        return view('admin.dashboard', [
            'totalQuestions' => $messages->count(),
            'totalConversations' => AssistantConversation::count(),
            'unanswered' => AssistantMessage::where('status', AssistantMessage::STATUS_UNANSWERED)->whereNull('resolved_at')->count(),
            'failures' => AssistantMessage::where('status', AssistantMessage::STATUS_FAILED)->count(),
            'positive' => AssistantFeedback::where('rating', '>', 0)->count(),
            'negative' => AssistantFeedback::where('rating', '<', 0)->count(),
            'promptTokens' => (int) AssistantMessage::sum('prompt_tokens'),
            'completionTokens' => (int) AssistantMessage::sum('completion_tokens'),
            'geminiCalls' => AssistantMessage::whereNotNull('prompt_tokens')->count(),
            'byLanguage' => AssistantMessage::query()->select('detected_language', DB::raw('count(*) as total'))
                ->groupBy('detected_language')->orderByDesc('total')->pluck('total', 'detected_language'),
            'topQuestions' => AssistantMessage::query()->select(DB::raw('min(user_message) as question'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('lower(trim(user_message))'))->orderByDesc('total')->limit(10)->get(),
            'failureReasons' => AssistantMessage::where('status', AssistantMessage::STATUS_FAILED)
                ->select('error_reason', DB::raw('count(*) as total'))->groupBy('error_reason')->pluck('total', 'error_reason'),
        ]);
    }
}
