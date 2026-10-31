@extends('admin.layout')
@section('title', $document->exists ? 'Edit document' : 'New document')
@section('content')
    <h1>{{ $document->exists ? 'Edit document' : 'New document' }}</h1>
    <form method="post" enctype="multipart/form-data" class="card" action="{{ $document->exists ? route('admin.documents.update', $document) : route('admin.documents.store') }}">
        @csrf
        @if ($document->exists) @method('PUT') @endif
        @foreach ($errors->all() as $message)<div class="error">{{ $message }}</div>@endforeach
        <label>Title</label><input type="text" name="title" value="{{ old('title', $document->title) }}" required>
        <div class="row">
            <div><label>Category</label><select name="category">@foreach (\App\Models\KnowledgeDocument::CATEGORIES as $c)<option @selected(old('category', $document->category) === $c)>{{ $c }}</option>@endforeach</select></div>
            <div><label>Language</label><select name="language"><option value="en" @selected(old('language', $document->language) === 'en')>English</option><option value="ta" @selected(old('language', $document->language) === 'ta')>Tamil</option></select></div>
            <div><label>Status</label><select name="status"><option value="draft" @selected(old('status', $document->status) === 'draft')>Draft</option><option value="published" @selected(old('status', $document->status) === 'published')>Published</option></select></div>
        </div>
        <label>Content</label><textarea name="content" style="min-height:280px">{{ old('content', $document->content) }}</textarea>
        <label>Upload PDF, DOCX or TXT (text is extracted and added to the content)</label><input type="file" name="file" accept=".pdf,.docx,.txt">
        <label>Keywords</label><input type="text" name="keywords" value="{{ old('keywords', $document->keywords) }}">
        @if ($document->exists)<p class="hint">Created by {{ $document->creator?->name ?? 'unknown' }}, last updated by {{ $document->updater?->name ?? 'unknown' }}.</p>@endif
        <p><button>Save</button> <a class="btn alt" href="{{ route('admin.documents.index') }}">Cancel</a></p>
    </form>
@endsection
