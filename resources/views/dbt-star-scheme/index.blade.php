@extends('layouts.section-page', [
    'accent' => 'lime',
    'breadcrumbs' => [['Home', route('home')], [$title, null]],
])

@section('main')
    <section class="rgu-sec">
        <div class="rgu-sec__wrap">
            <header class="rgu-sec__head">
                <div>
                    <span class="rgu-sec__kick rgu-sec__kick--lime">Government of India</span>
                    <h2 class="rgu-sec__title">Scheme <em class="rgu-em-lime">objectives</em></h2>
                    <p class="rgu-sec__lede">The objectives set out for the Star College Scheme at Rathinam.</p>
                </div>
            </header>

            <ol class="rgu-oblist">
                @foreach ($objectives as $objective)
                    <li>{{ $objective }}</li>
                @endforeach
            </ol>
        </div>
    </section>
@endsection
