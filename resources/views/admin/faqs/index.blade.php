@extends('admin.layout')
@section('title', 'FAQs')
@section('content')
    <h1>FAQs <a class="btn" href="{{ route('admin.faqs.create') }}" style="float:right">New FAQ</a></h1>
    <form method="get" class="card row">
        <div><label>Search</label><input type="search" name="q" value="{{ request('q') }}"></div>
        <div><label>Category</label><select name="category"><option value="">All</option>@foreach ($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name_en }}</option>@endforeach</select></div>
        <div><label>Status</label><select name="status"><option value="">All</option>@foreach (['published', 'draft', 'disabled'] as $s)<option @selected(request('status') === $s)>{{ $s }}</option>@endforeach</select></div>
        <div><button>Filter</button></div>
    </form>
    <div class="card">
        <table>
            <tr><th>Question</th><th>Category</th><th>Status</th><th></th></tr>
            @forelse ($faqs as $faq)
                <tr>
                    <td>{{ \Illuminate\Support\Str::limit($faq->question_en ?: $faq->question_ta, 110) }}</td>
                    <td>{{ $faq->category?->name_en }}</td>
                    <td>@if (! $faq->is_active)<span class="badge">disabled</span>@elseif ($faq->published_at)<span class="badge ok">published</span>@else<span class="badge warn">draft</span>@endif</td>
                    <td><a href="{{ route('admin.faqs.edit', $faq) }}">Edit</a>
                        <form class="inline" method="post" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Delete this FAQ?')">@csrf @method('DELETE') <button class="danger">Delete</button></form></td>
                </tr>
            @empty
                <tr><td colspan="4" class="hint">No FAQs found.</td></tr>
            @endforelse
        </table>
        {{ $faqs->links() }}
    </div>
    <form method="post" action="{{ route('admin.faqs.import') }}" enctype="multipart/form-data" class="card">
        @csrf
        <h2>Bulk import (CSV)</h2>
        <p class="hint">Header row: category, question_en, answer_en, question_ta, answer_ta, keywords, variations. Imported FAQs are published immediately.</p>
        <input type="file" name="file" accept=".csv,.txt" required>
        @error('file')<div class="error">{{ $message }}</div>@enderror
        <p><button>Import</button></p>
    </form>
@endsection
