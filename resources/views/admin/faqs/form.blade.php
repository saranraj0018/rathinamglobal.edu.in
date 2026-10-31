@extends('admin.layout')
@section('title', $faq->exists ? 'Edit FAQ' : 'New FAQ')
@section('content')
    <h1>{{ $faq->exists ? 'Edit FAQ' : 'New FAQ' }}</h1>
    @if ($fromMessage)<div class="card hint">Answering an unanswered question asked by a visitor: “{{ $fromMessage->user_message }}”</div>@endif
    <form method="post" class="card" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}">
        @csrf
        @if ($faq->exists) @method('PUT') @endif
        @if ($fromMessage)<input type="hidden" name="from_message" value="{{ $fromMessage->id }}">@endif
        @foreach ($errors->all() as $message)<div class="error">{{ $message }}</div>@endforeach
        <label for="cat">Category</label>
        <select id="cat" name="faq_category_id"><option value="">None</option>@foreach ($categories as $c)<option value="{{ $c->id }}" @selected(old('faq_category_id', $faq->faq_category_id) == $c->id)>{{ $c->name_en }}</option>@endforeach</select>
        <div class="two">
            <div><label>Question (English)</label><textarea name="question_en" style="min-height:70px">{{ old('question_en', $faq->question_en) }}</textarea>
                <label>Answer (English)</label><textarea name="answer_en">{{ old('answer_en', $faq->answer_en) }}</textarea></div>
            <div><label>கேள்வி (Tamil)</label><textarea name="question_ta" style="min-height:70px">{{ old('question_ta', $faq->question_ta) }}</textarea>
                <label>பதில் (Tamil)</label><textarea name="answer_ta">{{ old('answer_ta', $faq->answer_ta) }}</textarea></div>
        </div>
        <label>Keywords</label><input type="text" name="keywords" value="{{ old('keywords', $faq->keywords) }}">
        <p class="hint">Comma separated, e.g. BCA fees, tuition, kattanam.</p>
        <label>Alternative question wordings</label><textarea name="variations">{{ old('variations', $faq->variations) }}</textarea>
        <p class="hint">One per line. Tanglish wordings are welcome, e.g. “BCA fees evlo”.</p>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq->is_active))> Enabled</label>
        <label><input type="checkbox" name="published" value="1" @checked(old('published', $faq->published_at !== null || ! $faq->exists))> Published (visible to the assistant)</label>
        <p><button>Save</button> <a class="btn alt" href="{{ route('admin.faqs.index') }}">Cancel</a></p>
    </form>
@endsection
