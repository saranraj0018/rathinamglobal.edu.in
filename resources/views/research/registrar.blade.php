@extends('layouts.research')

@section('page-title', 'Registrar')
@section('page-description', 'Office of the Registrar — Dr. C. Krishnaraj, Rathinam Global (Deemed to be University).')

@section('content')
<!-- ════════════════ HERO / PROFILE ════════════════ -->
<section class="relative overflow-hidden bg-[#080810] pt-14 pb-16 sm:pt-20 sm:pb-24">
  <div class="r-blob bg-violet-700/30 h-96 w-96 -top-28 -left-20"></div>
  <div class="r-blob bg-sky-600/25 h-80 w-80 top-0 right-0"></div>
  <div class="absolute inset-0 r-hero-grid pointer-events-none"></div>
  <div class="absolute top-0 inset-x-0 h-[2px] r-grad-bg"></div>

  <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <nav class="mb-8 flex items-center gap-2 text-xs text-white/40">
      <a href="{{ route('research.index') }}" class="hover:text-white/80">Research</a><span>/</span><span class="text-violet-300">Registrar</span>
    </nav>

    <div class="r-reveal is-in max-w-4xl">
      <div class="r-eyebrow text-violet-300 mb-4"><span class="h-1.5 w-1.5 rounded-full bg-violet-400 animate-pulse"></span> Office of the Registrar</div>
      <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-white leading-[1.08]">Dr. C. Krishnaraj</h1>
      <p class="mt-3 text-lg font-semibold text-white/70">Registrar</p>
      <div class="mt-4 flex flex-wrap gap-2">
        <span class="r-chip border-white/15 bg-white/[0.05] text-white/75">M.E.</span>
        <span class="r-chip border-white/15 bg-white/[0.05] text-white/75">Ph.D.</span>
        <span class="r-chip border-white/15 bg-white/[0.05] text-white/75">22+ Years Experience</span>
      </div>
      <p class="mt-5 max-w-xl text-base leading-7 text-white/55">Rathinam Global (Deemed to be University), Coimbatore — academic governance, regulatory compliance, quality assurance and institutional development.</p>

      <div class="mt-7 flex flex-wrap gap-3">
        <a href="tel:+919942999430" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/[0.05] px-4 py-2.5 text-sm font-medium text-white/80 hover:bg-white/10 transition">
          <i data-lucide="phone" class="h-4 w-4 text-violet-300"></i> +91 99429 99430
        </a>
        <a href="mailto:Registrar@rathinam.in" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/[0.05] px-4 py-2.5 text-sm font-medium text-white/80 hover:bg-white/10 transition">
          <i data-lucide="mail" class="h-4 w-4 text-violet-300"></i> Registrar@rathinam.in
        </a>
        <a href="mailto:Registrar@rathinamtechzone.com" class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/[0.05] px-4 py-2.5 text-sm font-medium text-white/80 hover:bg-white/10 transition">
          <i data-lucide="mail" class="h-4 w-4 text-violet-300"></i> Registrar@rathinamtechzone.com
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ REGISTRAR'S PERSPECTIVE ════════════════ -->
<section class="bg-white py-16 sm:py-20 border-b border-slate-100">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-10 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> A Message from the Registrar</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Registrar&rsquo;s Perspective</h2>
    </div>

    <div class="grid lg:grid-cols-[1fr_320px] gap-10 lg:gap-14 items-start">
      <!-- message -->
      <div class="r-reveal order-2 lg:order-1 space-y-5 text-[15px] leading-8 text-slate-700">
        <p>As we embark on a journey of higher education, we must remember that it is not just about textbooks and assignments, but also about excelling in every aspect of life. The world around us is in a constant state of transformation, and it is imperative that we equip ourselves with the necessary skills and knowledge to adapt and thrive in this rapidly changing landscape.</p>

        <p>At our institution, we are committed to providing our students with a holistic education that not only hones their technical abilities but also instills in them the values and principles necessary to succeed as compassionate and ethical professionals. Our unique approach, rooted in the principles of Design Thinking, empowers our students to think critically, creatively, and empathetically, ensuring that they are not just proficient in their chosen fields but also equipped to make a positive impact on society.</p>

        <p>We believe that education is not just a means to an end but a lifelong pursuit, and we encourage our students to keep their passion for learning alive by embracing the concept of &ldquo;JUST LOVE YOURSELF&rdquo;. By prioritizing personal growth, celebrating life&rsquo;s moments, and nurturing our conscience, we can create a better future for ourselves and those around us. Let us come together and embrace this journey of self-discovery and transformation.</p>

     
      </div>

      <!-- photo -->
      <div class="r-reveal d1 order-1 lg:order-2 mx-auto lg:mx-0 lg:sticky lg:top-24">
        <div class="relative w-[240px] sm:w-[280px]">
          <div class="absolute -inset-3 rounded-3xl bg-gradient-to-br from-violet-500/25 to-sky-400/20 blur-xl"></div>
          <img src="{{ storage_asset('research/assets/registrar.webp') }}" alt="Dr. C. Krishnaraj, Registrar"
            class="relative w-full rounded-3xl border border-slate-200 object-cover shadow-xl">
        </div>
        <div class="mt-5 text-center">
          <p class="text-lg font-bold text-slate-900">Dr. C. Krishnaraj</p>
          <p class="text-sm font-semibold text-violet-700">Registrar, Rathinam Global <br>(Deemed to be University)</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ ABOUT ════════════════ -->
<section class="bg-white py-16 sm:py-20">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mb-10 r-reveal">
      <p class="r-eyebrow text-violet-700 mb-3"><span class="h-1.5 w-1.5 rounded-full bg-violet-600"></span> About the Registrar</p>
      <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900">Leadership in academic governance</h2>
    </div>
    <div class="grid md:grid-cols-3 gap-6">
      <div class="r-card p-7 r-reveal">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-600 to-violet-500 text-white shadow-lg mb-5"><i data-lucide="building-2" class="h-6 w-6"></i></div>
        <h3 class="text-lg font-extrabold text-slate-900 mb-3">Background</h3>
        <p class="text-sm leading-7 text-slate-600">An accomplished academic administrator with over <strong>22 years</strong> of experience in higher education, research, teaching and institutional governance. Expertise spans NBA accreditation, NAAC processes, academic administration, curriculum development and research supervision.</p>
      </div>
      <div class="r-card p-7 r-reveal d1">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-600 to-sky-500 text-white shadow-lg mb-5"><i data-lucide="target" class="h-6 w-6"></i></div>
        <h3 class="text-lg font-extrabold text-slate-900 mb-3">Objectives</h3>
        <p class="text-sm leading-7 text-slate-600">To strengthen academic governance, ensure regulatory compliance, facilitate quality-assurance initiatives, and support the University's mission of excellence in education, research, innovation and industry collaboration.</p>
      </div>
      <div class="r-card p-7 r-reveal d2">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-500 text-white shadow-lg mb-5"><i data-lucide="list-checks" class="h-6 w-6"></i></div>
        <h3 class="text-lg font-extrabold text-slate-900 mb-3">Functions</h3>
        <ul class="space-y-2 text-sm text-slate-600">
          @foreach ($functions as $f)
          <li class="flex items-start gap-2"><span class="mt-1.5 h-1.5 w-1.5 flex-shrink-0 rounded-full bg-violet-500"></span><span>{!! $f !!}</span></li>
          @endforeach        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ════════════════ RESEARCH PROFILE STATS ════════════════ -->

<!-- ════════════════ QUALIFICATIONS & EXPERIENCE ════════════════ -->

<!-- ════════════════ ACHIEVEMENTS & MEMBERSHIPS ════════════════ -->
<section class="bg-[#f8fafc] py-16 sm:py-20 border-y border-slate-100">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-8">
    <div class="r-card p-7 sm:p-8 r-reveal">
      <h2 class="text-2xl font-black text-slate-900 mb-5">Major Achievements</h2>
      <ul class="space-y-3">
        @foreach ($contributions as $a)
<li class="flex items-start gap-2.5 text-sm text-slate-600"><svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-violet-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg><span>{!! $a !!}</span></li>
@endforeach      </ul>
      <div class="mt-6 rounded-xl bg-emerald-50/70 border border-emerald-100 p-4 text-sm text-slate-600">
        <strong class="text-emerald-800">Grants &amp; Funding:</strong> Secured grants from AICTE, SERB, MSME, TNSCST, Institution of Engineers and ISTE — supporting research projects, conferences, FDPs and innovation activities.
      </div>
    </div>
    <div class="r-card p-7 sm:p-8 r-reveal d1">
      <h2 class="text-2xl font-black text-slate-900 mb-5">Professional Memberships</h2>
      <div class="flex flex-wrap gap-2.5">
        @foreach ($memberships as $m)
<span class="r-chip border-slate-200 bg-white text-slate-600">{!! $m !!}</span>
@endforeach      </div>
    </div>
  </div>
</section>

<!-- ════════════════ GOVT GRANTS TABLE ════════════════ -->
@endsection
