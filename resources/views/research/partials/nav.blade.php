{{-- Research portal navbar. $active: home | directorate | registrar (set by the controller). --}}
<nav class="r-nav sticky top-0 z-50 bg-white/85 backdrop-blur-xl border-b border-black/5">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 lg:h-[72px]">

      <!-- Logo -->
      <a href="{{ route('research.index') }}" class="flex items-center gap-3 flex-shrink-0 min-w-0 mr-3">
        <img src="{{ storage_asset('assets/images/logo.webp') }}" alt="Rathinam Global University" class="h-8 lg:h-9 w-auto max-w-[230px] sm:max-w-[290px] object-contain object-left">
        <span class="hidden 2xl:block h-7 w-px bg-slate-200"></span>
        
      </a>

      <!-- Desktop links -->
      <div class="hidden xl:flex items-center gap-5 2xl:gap-7">
        <a href="{{ route('research.index') }}" class="r-link text-sm font-medium text-slate-600 hover:text-violet-700 transition {{ ($active ?? '') === 'home' ? 'is-active' : '' }}">Home</a>

        <a href="{{ route('home') }}" class="r-link text-sm font-medium text-slate-500 hover:text-violet-700 transition">RGU Home</a>

        <a href="https://payment.rathinam.global/login"
           target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 whitespace-nowrap rounded-xl bg-gradient-to-r from-violet-600 to-sky-500 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-violet-500/25 hover:scale-105 transition-transform">
          Apply for Ph.D.
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </a>
      </div>

      <!-- Hamburger -->
      <button id="r-mob-btn" class="xl:hidden p-2 rounded-xl border border-slate-200 text-slate-600" aria-label="Open menu">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>
    </div>

    <!-- Mobile menu -->
    <div id="r-mob-menu" class="xl:hidden hidden pb-5 pt-1 space-y-1 border-t border-slate-100">
      <a href="{{ route('research.index') }}" class="block rounded-xl px-3 py-2.5 text-sm font-medium {{ ($active ?? '') === 'home' ? 'bg-violet-50 text-violet-700' : 'text-slate-700 hover:bg-slate-50' }}">Home</a>
      


      <a href="{{ route('research.directorate') }}" class="block rounded-xl px-3 py-2.5 text-sm font-medium {{ ($active ?? '') === 'directorate' ? 'bg-violet-50 text-violet-700' : 'text-slate-700 hover:bg-slate-50' }}">About Directorate</a>
      <a href="{{ route('research.registrar') }}" class="block rounded-xl px-3 py-2.5 text-sm font-medium {{ ($active ?? '') === 'registrar' ? 'bg-violet-50 text-violet-700' : 'text-slate-700 hover:bg-slate-50' }}">Registrar</a>
      <a href="{{ route('home') }}" class="block rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">RGU Home</a>
      <a href="{{ route('home') }}?utm_source=research&utm_medium=navmobile&utm_campaign=phd" target="_blank" rel="noopener"
         class="mt-2 block rounded-xl bg-gradient-to-r from-violet-600 to-sky-500 px-3 py-3 text-center text-sm font-bold text-white">Apply for Ph.D.</a>
    </div>
  </div>
</nav>
