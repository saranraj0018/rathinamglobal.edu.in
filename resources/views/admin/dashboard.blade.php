@extends('admin.layout')
@section('title', 'Analytics')
@section('content')
    <h1>Assistant analytics</h1>
    <div class="grid">
        @foreach ([
            'Total questions' => $totalQuestions, 'Conversations' => $totalConversations, 'Unanswered' => $unanswered,
            'AI failures' => $failures, 'Helpful' => $positive, 'Not helpful' => $negative,
            'Gemini calls' => $geminiCalls, 'Prompt tokens' => $promptTokens, 'Output tokens' => $completionTokens,
        ] as $label => $value)
            <div class="card stat"><b>{{ number_format($value) }}</b><span>{{ $label }}</span></div>
        @endforeach
    </div>
    <div class="two">
        <div class="card">
            <h2>Most asked questions</h2>
            <table>@forelse ($topQuestions as $row)<tr><td>{{ $row->question }}</td><td>{{ $row->total }}</td></tr>@empty<tr><td class="hint">No questions yet.</td></tr>@endforelse</table>
        </div>
        <div class="card">
            <h2>Questions by language</h2>
            <table>@forelse ($byLanguage as $language => $total)<tr><td>{{ ['ta' => 'Tamil', 'en' => 'English', 'tanglish' => 'Tanglish'][$language] ?? $language }}</td><td>{{ $total }}</td></tr>@empty<tr><td class="hint">No data yet.</td></tr>@endforelse</table>
            <h2>AI failure reasons</h2>
            <table>@forelse ($failureReasons as $reason => $total)<tr><td>{{ $reason }}</td><td>{{ $total }}</td></tr>@empty<tr><td class="hint">None.</td></tr>@endforelse</table>
        </div>
    </div>
    <p><a class="btn" href="{{ route('admin.unanswered') }}">Review unanswered questions</a></p>
@endsection
