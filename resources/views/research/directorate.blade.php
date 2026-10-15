@extends('layouts.research')

@section('page-title', 'About Directorate')
@section('page-description', 'Directorate of Research – Ph.D Programmes, led by Dr. S. Balasubramanian, Rathinam Global (Deemed to be University).')

@section('content')
<!-- ════════════════ HERO / DIRECTOR PROFILE ════════════════ -->
<section class="relative overflow-hidden bg-[#080810] pt-14 pb-16 sm:pt-20 sm:pb-24">
  <div class="r-blob bg-violet-700/30 h-96 w-96 -top-28 -left-20"></div>
  <div class="r-blob bg-sky-600/25 h-80 w-80 top-0 right-0"></div>
  <div class="absolute inset-0 r-hero-grid pointer-events-none"></div>
  <div class="absolute top-0 inset-x-0 h-[2px] r-grad-bg"></div>

  <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="mb-8 flex items-center gap-2 text-xs text-white/40">
      <a href="{{ route('research.index') }}" class="hover:text-white/80">Research</a><span>/</span><span class="text-violet-300">About Directorate</span>
    </nav>

    <div class="grid lg:grid-cols-[1fr_300px] gap-10 lg:gap-14 items-center">
      <div class="r-reveal is-in order-2 lg:order-1">
        <div class="r-eyebrow text-violet-300 mb-4"><span class="h-1.5 w-1.5 rounded-full bg-violet-400 animate-pulse"></span> Directorate of Research · Ph.D Programmes</div>
        <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-white leading-[1.08]">Dr. S. Balasubramanian</h1>
        <p class="mt-3 text-lg font-semibold text-white/70">Director – Ph.D Programmes</p>
        <div class="mt-4 flex flex-wrap gap-2">
          <span class="r-chip border-white/15 bg-white/[0.05] text-white/75">M.Sc.</span>
          <span class="r-chip border-white/15 bg-white/[0.05] text-white/75">Ph.D. (Cell Biology, Basel)</span>
          <span class="r-chip border-white/15 bg-white/[0.05] text-white/75">10 Yrs Research · 9 Yrs Admin</span>
        </div>
        <p class="mt-5 max-w-xl text-base leading-7 text-white/55">Rathinam Global (Deemed to be University), Coimbatore — leading high-quality interdisciplinary research, national &amp; international collaborations, and doctoral programmes.</p>

        <!-- Profile contact (incl. directorate email) -->
        <div class="mt-7 flex flex-wrap gap-3">
          <a href="tel:+919487704190" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/[0.05] px-4 py-2.5 text-sm font-medium text-white/80 hover:bg-white/10 transition">
            <i data-lucide="phone" class="h-4 w-4 text-violet-300"></i> +91-9487704190
          </a>
          <a href="mailto:director.rp@rathinam.in" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/[0.05] px-4 py-2.5 text-sm font-medium text-white/80 hover:bg-white/10 transition">
            <i data-lucide="mail" class="h-4 w-4 text-violet-300"></i> director.rp@rathinam.in
          </a>
        </div>
      </div>
      <div class="r-reveal is-in order-1 lg:order-2 mx-auto lg:mx-0">
        <div class="relative w-[230px] sm:w-[260px]">
          <div class="absolute -inset-3 rounded-3xl bg-gradient-to-br from-violet-600/40 to-sky-500/30 blur-xl"></div>
          <img src="{{ storage_asset('research/assets/director.webp') }}" alt="Dr. S. Balasubramanian, Director – Ph.D Programmes" class="relative w-full rounded-3xl border border-white/15 bg-slate-100 object-cover shadow-2xl">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ ABOUT THE DIRECTORATE ════════════════ -->
<section class="bg-white py-16 sm:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-10 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> About the Directorate</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Advancing research &amp; innovation</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="r-card p-7 r-reveal">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-600 to-violet-500 text-white shadow-lg mb-5"><i data-lucide="building-2" class="h-6 w-6"></i></div>
        <h3 class="text-lg font-extrabold text-slate-900 mb-3">Establishment &amp; Background</h3>
        <p class="text-sm leading-7 text-slate-600">The Directorate of Ph.D Programmes at Rathinam Global University, Coimbatore, is led by Dr. S. Balasubramanian — a distinguished researcher with <strong>10 years of research</strong>, <strong>10 years of teaching</strong> and <strong>9 years of administrative</strong> experience.</p>
      </div>
      <div class="r-card p-7 r-reveal d1">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-600 to-sky-500 text-white shadow-lg mb-5"><i data-lucide="target" class="h-6 w-6"></i></div>
        <h3 class="text-lg font-extrabold text-slate-900 mb-3">Objectives</h3>
        <p class="text-sm leading-7 text-slate-600">To promote and facilitate high-quality interdisciplinary research, foster collaborations with national and international agencies, and support faculty and student researchers in advancing science and innovation.</p>
      </div>
      <div class="r-card p-7 r-reveal d2">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-500 text-white shadow-lg mb-5"><i data-lucide="list-checks" class="h-6 w-6"></i></div>
        <h3 class="text-lg font-extrabold text-slate-900 mb-3">Functions</h3>
        <p class="text-sm leading-7 text-slate-600">Oversees research project grants, Ph.D. scholar guidance, publication output, innovation initiatives and strategic partnerships with government funding bodies including <strong>DBT, DST, ICSSR, TNSCST</strong> and others.</p>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ RESEARCH HIGHLIGHTS ════════════════ -->
<section class="bg-[#0b1020] py-16 sm:py-20 relative overflow-hidden">
  <div class="r-blob bg-violet-700/20 h-80 w-80 top-0 right-1/4"></div>
  <div class="absolute top-0 inset-x-0 h-[2px] r-grad-bg"></div>
  <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-10 r-reveal">
      <p class="r-eyebrow text-violet-300 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-400"></span> Research Highlights</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">Publications &amp; impact</h2>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
      @foreach ($stats as $s)
<div class="rounded-2xl border border-white/10 bg-white/[0.04] backdrop-blur p-5 r-reveal"><div class="flex items-center gap-2 text-white/40 mb-2"><i data-lucide="{!! $s[2] !!}" class="h-4 w-4"></i></div><div class="text-3xl font-black text-white leading-none">{!! $s[0] !!}</div><div class="mt-1.5 text-[11px] font-medium uppercase tracking-wider text-white/45">{!! $s[1] !!}</div></div>
@endforeach    </div>
    <p class="mt-6 max-w-3xl text-sm leading-7 text-white/50">Selected publications span high-impact journals including <em class="text-white/70">Cancer Research, PLoS ONE, Cell Death &amp; Disease, Soft Matter, Clinical Anatomy</em> and <em class="text-white/70">Biophysical Journal</em> — covering glioma biology, Notch signalling, cancer stem cells, genomics and nanobiotechnology.</p>
  </div>
</section>

<!-- ════════════════ RESEARCH PROJECTS ════════════════ -->
<section class="bg-white py-16 sm:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-10 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> Research Projects</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Grants secured &amp; facilitated</h2>
    </div>

    @foreach ($grantTables as $table)
<div class="mb-9 r-reveal"><h3 class="text-lg font-extrabold text-slate-900 mb-4">{!! $table['title'] !!}</h3><div class="overflow-x-auto rounded-xl border border-slate-200"><table class="w-full text-sm x-276kgcy2"><thead class="bg-slate-900 text-slate-100"><tr><th class="px-4 py-3 text-left font-semibold">Type</th><th class="px-4 py-3 text-center font-semibold">No.</th><th class="px-4 py-3 text-left font-semibold">Funding Agencies</th><th class="px-4 py-3 text-right font-semibold">Amount (₹)</th></tr></thead><tbody class="divide-y divide-slate-100">
@foreach ($table['rows'] as $r)
<tr><td class="px-4 py-3 font-semibold text-slate-700">{!! $r[0] !!}</td><td class="px-4 py-3 text-center text-slate-600">{!! $r[1] !!}</td><td class="px-4 py-3 text-slate-600">{!! $r[2] !!}</td><td class="px-4 py-3 text-right"><span class="r-amount">₹{!! $r[3] !!}</span></td></tr>
@endforeach
<tr class="bg-emerald-50/70"><td class="px-4 py-3 font-black text-emerald-800" colspan="3">Total</td><td class="px-4 py-3 text-right font-black text-emerald-800">₹{!! $table['total'] !!}</td></tr></tbody></table></div></div>
    @endforeach
    <!-- Individual Research Project -->
    <div class="r-reveal">
      <h3 class="text-lg font-extrabold text-slate-900 mb-4">Individual Research Project</h3>
      <div class="overflow-x-auto rounded-xl border border-slate-200">
        <table class="w-full text-sm x-276kgcy2">
          <thead class="bg-slate-900 text-slate-100"><tr><th class="px-4 py-3 text-left font-semibold">Project Title</th><th class="px-4 py-3 text-left font-semibold">Agency</th><th class="px-4 py-3 text-right font-semibold">Amount (₹)</th><th class="px-4 py-3 text-left font-semibold">Duration</th></tr></thead>
          <tbody class="divide-y divide-slate-100">
            <tr><td class="px-4 py-3 text-slate-700">Developing Portable Composite Household Foldscope Kit for Improved Sanitation and Human Health</td><td class="px-4 py-3 text-slate-600">DBT, Govt. of India</td><td class="px-4 py-3 text-right"><span class="r-amount">₹8,00,000</span></td><td class="px-4 py-3 text-slate-600 whitespace-nowrap">Mar 2018 – Sep 2019</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ GUIDANCE + AWARDS ════════════════ -->
<section class="bg-[#f8fafc] py-16 sm:py-20 border-y border-slate-100">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-8">
    <!-- Research Guidance -->
    <div class="r-reveal">
      <h2 class="text-2xl font-black text-slate-900 mb-5">Research Guidance</h2>
      <div class="grid grid-cols-3 gap-4">
        @foreach ($guidance as $g)
<div class="r-card p-5 text-center"><div class="text-3xl font-black text-violet-700">{!! $g[0] !!}</div><div class="mt-1 text-xs text-slate-500">{!! $g[1] !!}</div></div>
@endforeach      </div>
      <h2 class="text-2xl font-black text-slate-900 mt-10 mb-5">Academic Qualifications</h2>
      <div class="overflow-x-auto rounded-xl border border-slate-200">
        <table class="w-full text-sm x-ur7kneaf">
          <thead class="bg-slate-900 text-slate-100"><tr><th class="px-4 py-3 text-left font-semibold">Degree</th><th class="px-4 py-3 text-left font-semibold">Branch</th><th class="px-4 py-3 text-left font-semibold">University</th><th class="px-4 py-3 text-left font-semibold">Year</th></tr></thead>
          <tbody class="divide-y divide-slate-100">
            @foreach ($qualifications as $r)
<tr><td class="px-4 py-3 font-bold text-slate-800">{!! $r[0] !!}</td><td class="px-4 py-3 text-slate-600">{!! $r[1] !!}</td><td class="px-4 py-3 text-slate-600">{!! $r[2] !!}</td><td class="px-4 py-3 text-slate-600">{!! $r[3] !!}</td></tr>
@endforeach          </tbody>
        </table>
      </div>
    </div>
    <!-- Awards -->
    <div class="r-reveal d1">
      <h2 class="text-2xl font-black text-slate-900 mb-5">Awards &amp; Recognition</h2>
      <div class="overflow-x-auto rounded-xl border border-slate-200">
        <table class="w-full text-sm x-2twk3r3o">
          <thead class="bg-slate-900 text-slate-100"><tr><th class="px-4 py-3 text-left font-semibold">Award / Honour</th><th class="px-4 py-3 text-left font-semibold">Agency / Institute</th><th class="px-4 py-3 text-left font-semibold">Year</th></tr></thead>
          <tbody class="divide-y divide-slate-100">
            @foreach ($awards as $r)
<tr><td class="px-4 py-3 font-semibold text-slate-700">{!! $r[0] !!}</td><td class="px-4 py-3 text-slate-600">{!! $r[1] !!}</td><td class="px-4 py-3 text-slate-600 whitespace-nowrap">{!! $r[2] !!}</td></tr>
@endforeach          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ MAJOR ACHIEVEMENTS ════════════════ -->
<section class="bg-white py-16 sm:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-10 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> Major Achievements</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Institution-building &amp; leadership</h2>
    </div>
    <div class="grid lg:grid-cols-2 gap-6">
      <div class="r-card p-7 sm:p-8 r-reveal">
        <h3 class="text-lg font-extrabold text-slate-900 mb-4">As Principal</h3>
        <ul class="space-y-3">
          @foreach ($asPrincipal as $a)
<li class="flex items-start gap-2.5 text-sm text-slate-600"><svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-violet-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{!! $a !!}</span></li>
@endforeach        </ul>
      </div>
      <div class="r-card p-7 sm:p-8 r-reveal d1">
        <h3 class="text-lg font-extrabold text-slate-900 mb-4">As Dean R&amp;D</h3>
        <ul class="space-y-3">
          @foreach ($asDean as $a)
<li class="flex items-start gap-2.5 text-sm text-slate-600"><svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-violet-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{!! $a !!}</span></li>
@endforeach        </ul>
        <div class="mt-5 grid grid-cols-3 gap-3">
          @foreach ($deanOutcomes as $g)
<div class="rounded-xl bg-violet-50/60 border border-violet-100 p-4 text-center"><div class="text-2xl font-black text-violet-700">{!! $g[0] !!}</div><div class="mt-1 text-[11px] text-slate-500">{!! $g[1] !!}</div></div>
@endforeach        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ CONTACT ════════════════ -->
<section class="bg-[#f8fafc] py-16 sm:py-20 border-t border-slate-100">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="r-card p-7 sm:p-9 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> Contact</p>
      <h2 class="text-2xl font-black text-slate-900 mb-6">Reach the Directorate</h2>
      <div class="grid sm:grid-cols-3 gap-5">
        <div class="flex items-start gap-3"><span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-700"><i data-lucide="map-pin" class="h-5 w-5"></i></span><div><div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Address</div><p class="text-sm leading-6 text-slate-600">31, L.N. Nagar, Nehru Nagar West, Kalapatti, Coimbatore – 641 048, Tamil Nadu, India</p></div></div>
        <div class="flex items-start gap-3"><span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-700"><i data-lucide="phone" class="h-5 w-5"></i></span><div><div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Phone</div><a href="tel:+919487704190" class="text-sm text-slate-600 hover:text-violet-700">+91-9487704190</a></div></div>
        <div class="flex items-start gap-3"><span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-violet-50 text-violet-700"><i data-lucide="mail" class="h-5 w-5"></i></span><div><div class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Email</div><a href="mailto:director.rp@rathinam.in" class="text-sm text-slate-600 hover:text-violet-700">director.rp@rathinam.in</a></div></div>
      </div>
    </div>
  </div>
</section>
@endsection
