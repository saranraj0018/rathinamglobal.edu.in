@extends('admin.layout')
@section('title', 'Settings')
@section('content')
    <h1>Assistant settings</h1>
    <form method="post" action="{{ route('admin.settings.update') }}" class="card">
        @csrf @method('PUT')
        <label for="contact">Verified admissions contact</label>
        <textarea id="contact" name="admissions_contact" required>{{ old('admissions_contact', $contact) }}</textarea>
        @error('admissions_contact')<div class="error">{{ $message }}</div>@enderror
        <p class="hint">Shown to visitors whenever the assistant has no verified answer. Include phone number, email or page link.</p>
        <p><button>Save</button></p>
    </form>
@endsection
