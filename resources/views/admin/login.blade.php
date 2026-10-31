@extends('admin.layout')
@section('title', 'Sign in')
@section('content')
    <form method="post" action="{{ route('admin.login.store') }}" class="card" style="max-width:380px;margin:60px auto">
        @csrf
        <h1>Administrator sign in</h1>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email')<div class="error">{{ $message }}</div>@enderror
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
        <label><input type="checkbox" name="remember" value="1"> Remember me</label>
        <p><button>Sign in</button></p>
    </form>
@endsection
