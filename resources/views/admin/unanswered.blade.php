@extends('admin.layout')
@section('title', 'Unanswered questions')
@section('content')
    <h1>Unanswered questions</h1>
    <div class="card">
        <table>
            <tr><th>Question</th><th>Language</th><th>Asked</th><th></th></tr>
            @forelse ($messages as $message)
                <tr>
                    <td>{{ $message->user_message }}</td><td>{{ $message->detected_language }}</td><td>{{ $message->created_at->diffForHumans() }}</td>
                    <td><a class="btn" href="{{ route('admin.faqs.create', ['question' => $message->user_message, 'from_message' => $message->id]) }}">Create FAQ</a>
                        <form class="inline" method="post" action="{{ route('admin.unanswered.dismiss', $message) }}">@csrf <button class="alt">Dismiss</button></form></td>
                </tr>
            @empty
                <tr><td colspan="4" class="hint">Nothing to review.</td></tr>
            @endforelse
        </table>
        {{ $messages->links() }}
    </div>
@endsection
