@extends('layouts.research')

@section('page-title', 'Research Overview')
@section('page-description', 'Research, doctoral programmes, innovation and R&D metrics at Rathinam Global University (RGU), Coimbatore.')

@section('content')
<!-- Popup modal for site-load image -->


<!-- ════════════════ HERO ════════════════ -->
<section class="relative overflow-hidden bg-[#080810] min-h-[92vh] flex items-center">
  <div class="r-blob bg-violet-700/30 h-[520px] w-[520px] -top-32 -left-24"></div>
  <div class="r-blob bg-sky-600/25 h-[460px] w-[460px] -bottom-28 -right-20"></div>
  <div class="r-blob bg-fuchsia-600/15 h-[280px] w-[280px] top-1/3 right-1/3"></div>
  <div class="absolute inset-0 r-hero-grid pointer-events-none"></div>
  <div class="absolute top-0 inset-x-0 h-[2px] r-grad-bg"></div>

  <div class="relative z-10 px-4 sm:px-6 lg:px-8 py-24">
    <!-- left -->
    <div class="col-span-12 r-reveal is-in text-center">
      <div class="r-eyebrow text-violet-300 mb-6 text-center">
        <span class="h-1.5 w-1.5 rounded-full bg-violet-400 animate-pulse"></span>
        Directorate of Research, Development &amp; Innovation
      </div>
      <h1 class="text-4xl sm:text-5xl lg:text-[3.6rem] font-black text-white leading-[1.06] tracking-tight text-center">
        Advancing <span class="r-grad-text">Knowledge,</span>
        Innovation &amp; Impact
      </h1>
      <p class="mt-6 text-base sm:text-lg leading-8 text-white/55 text-center">
        Rathinam Global (Deemed to be University) offers dynamic, Doctoral Programmes (Ph.D.)
        that cultivate scholarly excellence, ethical inquiry and interdisciplinary knowledge creation —
        in alignment with <strong class="text-white/80">UGC Regulations 2022</strong>,
        <strong class="text-white/80">NHEQF 2023</strong> and <strong class="text-white/80">NEP 2020</strong>.
      </p>
      <div class="mt-9 flex flex-col sm:flex-row gap-4 justify-center items-center">
        <a href="https://payment.rathinam.global/login" target="_blank" rel="noopener"
          class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-sky-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-violet-500/30 hover:scale-105 transition-transform">
          Apply for Ph.D. <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14M13 6l6 6-6 6" />
          </svg>
        </a>

        <a href="{{ storage_asset('research/assets/Final-Ph.D-Brouchure.pdf') }}" target="_blank" rel="noopener"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-lime-400 to-emerald-400 px-7 py-3.5 text-sm font-bold text-[#0a0a14] shadow-[0_8px_32px_rgba(163,230,53,0.35)] hover:scale-105 transition-transform">
          Download Brochure <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
        </a>

      </div>
      <!-- trust badges -->
      <div class="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 text-white/40 text-xs font-semibold uppercase tracking-wider justify-center">
        <span>UGC 2022</span><span class="h-1 w-1 rounded-full bg-white/20"></span>
        <span>NHEQF 2023</span><span class="h-1 w-1 rounded-full bg-white/20"></span>
        <span>NEP 2020</span><span class="h-1 w-1 rounded-full bg-white/20"></span>
        <span>NAAC A++</span>
      </div>
    </div>

    <!-- right: floating metric cards -->
  </div>
</section>

<!-- ════════════════ INTRO STRIP ════════════════ -->
<section class="bg-white border-b border-slate-100">
  <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-14 text-center r-reveal">
    <p class="text-lg sm:text-xl leading-9 text-slate-600">
      The University fosters a vibrant ecosystem that empowers research scholars to address contemporary
      <span class="font-semibold text-slate-900">academic, scientific, technological, industrial, environmental and societal</span>
      challenges through impactful research and innovation.
    </p>
  </div>
</section>

<!-- ════════════════ WHY Ph.D. AT RGU ════════════════ -->
<section class="bg-[#f8fafc] py-16 sm:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-12 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> Why Pursue <span class="x-27liev22">Ph.D.</span> at RGU</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Research excellence with global standards</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      @foreach ($why as $i => $w)
        <div class="r-card p-7 r-reveal d{!! $i + 1 !!}">
          <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br {!! $w[1] !!} text-white shadow-lg mb-5"><i data-lucide="{!! $w[0] !!}" class="h-6 w-6"></i></div>
          <h3 class="text-lg font-extrabold text-slate-900 mb-4">{!! $w[2] !!}</h3>
          <ul class="space-y-2.5">
            @foreach ($w[3] as $li)
              <li class="flex items-start gap-2.5 text-sm text-slate-600">
                <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-violet-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="20 6 9 17 4 12" />
                </svg>
                <span>{!! $li !!}</span>
              </li>
            @endforeach          </ul>
        </div>
      @endforeach    </div>
  </div>
</section>

<section class="px-4 sm:px-6 lg:px-8 py-10 sm:py-20">
  <div class="text-center max-w-2xl mx-auto r-reveal">
    <p class="r-eyebrow text-violet-300 mb-3 justify-center"><span class="h-1.5 w-1.5 rounded-full bg-violet-400"></span> Research at a Glance</p>
    <h2 class="text-3xl sm:text-4xl font-black tracking-tight">Salient Features of the Ph.D. Programme</h2>
  </div>
  <div class="grid grid-cols-10 gap-3 mt-3">
    @foreach ($highlights as $highlight)
      <div class="col-span-10 md:col-span-2 flex gap-3 r-card rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
        <span class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl {!! $highlight[1] !!}">
          <i data-lucide="{!! $highlight[0] !!}" class="h-5 w-5"></i>
        </span>
        <p class="text-xs font-medium text-slate-900 leading-6">
          {!! $highlight[2] !!}        </p>
      </div>
    @endforeach  </div>

</section>

<!-- ════════════════ Research Clusters ════════════════ -->
<section class="bg-[#f8fafc] py-16 sm:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-12 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> Future-Focused Research Ecosystems</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Next-Generation Innovation Clusters</h2>
      <p class="mt-4 text-slate-600">Advancing breakthrough ideas through collaborative research across science, technology, design, sustainability, and human development.</p>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ($clusters as $cluster)
        <article class="r-card rounded-3xl border border-slate-200/60 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg">
          <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-50 text-violet-700 mb-4">
            <i data-lucide="{!! $cluster[0] !!}" class="h-5 w-5"></i>
          </div>
          <p class="text-base font-semibold text-slate-900 leading-7">{!! $cluster[1] !!}</p>
        </article>
      @endforeach    </div>
  </div>
</section>

<!-- ════════════════ RESEARCH AT A GLANCE ════════════════ -->
<section class="relative overflow-hidden bg-[#0b1020] py-16 sm:py-24">
  <div class="r-blob bg-violet-700/20 h-80 w-80 top-0 left-1/4"></div>
  <div class="absolute top-0 inset-x-0 h-[2px] r-grad-bg"></div>
  <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-2xl mx-auto mb-12 r-reveal">
      <p class="r-eyebrow text-violet-300 mb-3 justify-center"><span class="h-1.5 w-1.5 rounded-full bg-violet-400"></span> Research at a Glance</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">Measurable Research Momentum</h2>
      <p class="mt-4 text-white/55">Cumulative research output and impact recorded by the Directorate of Research, Development &amp; Innovation.</p>

    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4">
      @foreach ($glance as $g)
        <div class="group rounded-2xl border border-white/10 bg-white/[0.04] backdrop-blur p-5 transition r-reveal">
          <div class="{!! $g[0] === 'count' ? 'text-3xl sm:text-4xl' : 'text-xl sm:text-2xl' !!} font-black text-white leading-tight break-words" {!! $g['count_attributes'] !!}>
            {!! $g[0] === 'count' ? '0' : $g[1] !!}          </div>
          <div class="mt-2 text-sm font-bold text-white/90">{!! $g[3] !!}</div>
          <div class="text-xs text-white/45">{!! $g[4] !!}</div>
        </div>
      @endforeach    </div>

  </div>
</section>

<!-- ════════════════ EMERGING THEMES ════════════════ -->
<section class="bg-[#f8fafc] py-16 sm:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="rounded-3xl bg-gradient-to-br from-violet-600 to-sky-500 p-8 sm:p-12 text-white relative overflow-hidden r-reveal">
      <div class="absolute -top-16 -right-10 h-60 w-60 rounded-full bg-white/10 blur-2xl"></div>
      <p class="r-eyebrow text-white/70 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-white"></span> Research Areas &amp; Emerging Themes</p>
      <h2 class="text-2xl sm:text-3xl font-black tracking-tight mb-7 max-w-2xl">The University actively promotes research in</h2>
      <div class="flex flex-wrap gap-2.5">
        @foreach ($themes as $t)
<span class="rounded-full border border-white/25 bg-white/10 px-4 py-2 text-sm font-medium backdrop-blur">{!! $t !!}</span>
@endforeach      </div>
    </div>
  </div>
</section>

<!-- ════════════════ PROGRAMME MODES ════════════════ -->
<section class="bg-white py-16 sm:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-12 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> Flexible <span class="x-27liev22">Ph.D.</span> Programme Modes</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Multiple pathways for doctoral research</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      @foreach ($modes as $i => $m)
        <div class="r-card p-7 r-reveal d{!! $i + 1 !!}">
          <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br {!! $m[2] !!} text-white shadow-lg mb-5"><i data-lucide="{!! $m[1] !!}" class="h-6 w-6"></i></div>
          <h3 class="text-lg font-extrabold text-slate-900 mb-4">{!! $m[0] !!}</h3>
          <ul class="space-y-2.5">
            @foreach ($m[3] as $li)
              <li class="flex items-start gap-2.5 text-sm text-slate-600"><span class="mt-1.5 h-1.5 w-1.5 flex-shrink-0 rounded-full bg-violet-500"></span><span>{!! $li !!}</span></li>
            @endforeach          </ul>
        </div>
      @endforeach    </div>

  </div>
</section>

<section class="bg-slate-50">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mt-12 grid gap-8 lg:grid-cols-1">


      <article class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-8 shadow-xl">
        <div class="flex items-start gap-4 mb-6">
          <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-50 text-sky-700 shadow-sm">
            <i data-lucide="sparkles" class="h-6 w-6"></i>
          </div>
          <div>
            <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-semibold">Research Environment</p>
            <h3 class="mt-3 text-3xl font-black text-slate-900">A modern ecosystem for discovery</h3>
          </div>
        </div>
        <p class="max-w-xl text-sm leading-7 text-slate-600 mb-8">RGU nurtures research through labs, collaborations, events, resources and entrepreneurship support designed for emerging scholars.</p>
        <div class="grid gap-4 sm:grid-cols-2">
          @foreach ($environmentItems as $item)
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 transition hover:border-slate-300">
              <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-violet-600 text-white shadow-sm">
                <i data-lucide="{!! $item[0] !!}" class="h-5 w-5"></i>
              </div>
              <p class="mt-4 text-sm leading-6 text-slate-700">{!! $item[1] !!}</p>
            </div>
          @endforeach        </div>
      </article>
    </div>
  </div>
</section>










<section class="bg-slate-50">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mt-12 grid gap-8 lg:grid-cols-1">
      <article class="relative overflow-hidden rounded-[2rem] border border-orange-200 bg-gradient-to-br from-orange-500 via-orange-500 to-orange-400 p-8 text-white shadow-2xl">
        <div class="absolute -right-16 top-8 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
        <div class="relative z-10">
          <div class="flex items-center gap-3 mb-6">
            <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-white/15 text-white shadow-sm">
              <i data-lucide="handshake" class="h-6 w-6"></i>
            </div>
            <div>
              <p class="text-xs uppercase tracking-[0.3em] text-orange-100 font-semibold">Additional Support</p>
              <h3 class="mt-3 text-3xl font-black">Comprehensive Support For Research Excellence</h3>
            </div>
          </div>
                    <div class="grid gap-4 grid-cols-1 lg:grid-cols-3">
          @foreach ($supportItems as $item)
            <div class="flex items-start gap-4 rounded-3xl bg-white/10 p-4 transition hover:bg-white/20">
              <span class="mt-1 flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white shadow-sm">
                <i data-lucide="{!! $item[0] !!}" class="h-5 w-5"></i>
              </span>
              <p class="text-sm leading-6 text-white/95">{!! $item[1] !!}</p>
            </div>
          @endforeach          </div>
        </div>
      </article>

    </div>
  </div>
</section>



<!-- ════════════════ DISCIPLINES ════════════════ -->






<!-- ════════════════ ADMISSION PROCESS ════════════════ -->
<section class="bg-white py-16 sm:py-24">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-12 gap-12">
    <div class="lg:col-span-5 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> Admission Process</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Transparent &amp; merit-based selection</h2>
      <p class="mt-4 text-slate-600">Admissions open twice every year — the <strong class="text-slate-900">June–July</strong> and <strong class="text-slate-900">December–January</strong> sessions.</p>
      <div class="mt-7 rounded-2xl border border-violet-100 bg-violet-50/60 p-6">
        <h4 class="text-sm font-extrabold text-violet-800 mb-3">Entrance Examination Structure</h4>
        <ul class="space-y-2 text-sm text-slate-600">
          <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span> 50% Research Methodology</li>
          <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span> 50% Subject Specialization</li>
          <li class="flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span> Followed by Presentation &amp; Interview</li>
        </ul>
        <p class="mt-4 text-xs text-slate-500"><strong class="text-slate-700">RPET exemption</strong> for UGC/CSIR-NET-JRF, GATE, DBT-JRF, ICMR-JRF, INSPIRE, SET/SLET &amp; equivalent qualifiers.</p>
      </div>
    </div>
    <div class="lg:col-span-7 r-reveal d1">
      <ol class="relative border-l-2 border-violet-100 ml-3 space-y-7">
        @foreach ($steps as $i => $s)
          <li class="ml-7">
            <span class="absolute -left-[14px] flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 to-sky-500 text-white text-xs font-black shadow">{!! $i + 1 !!}</span>
            <h4 class="text-base font-extrabold text-slate-900">{!! $s[0] !!}</h4>
            <p class="mt-1 text-sm text-slate-600 leading-6">{!! $s[1] !!}</p>
          </li>
        @endforeach      </ol>
    </div>
  </div>
</section>
@endsection
