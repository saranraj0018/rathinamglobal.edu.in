{{-- Full-screen Looker Studio embed. $dashboard: [embed, height]. --}}
@extends('layouts.base')

@section('title', 'Looker Studio Dashboard')

@push('head')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .dashboard-container {
            width: 100%;
            height: 100vh;
        }

        .dashboard-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }
    </style>
@endpush

@section('body')
    <div class="dashboard-container">
        <iframe
            @if ($dashboard['height']) width="600" height="{{ $dashboard['height'] }}" @endif
            src="{{ $dashboard['embed'] }}"
            frameborder="0" style="border:0" allowfullscreen
            sandbox="allow-storage-access-by-user-activation allow-scripts allow-same-origin allow-popups allow-popups-to-escape-sandbox"></iframe>
    </div>
@endsection
