<!-- FILE: partials/happening at rgu.php -->


<section id="happening" class="relative py-32 overflow-hidden x-1rx1uw2h">

    <!-- Background glow -->
    <div class="absolute w-[500px] h-[500px] rounded-full pointer-events-none x-l335cr96"
        
         aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="reveal-up grid lg:grid-cols-2 gap-12 items-end mb-14">
            <div>
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border mb-6 x-2omslifq"
                    >
                    <span class="w-1.5 h-1.5 rounded-full x-16kttyb5"></span>
                    <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase">Live & Upcoming</span>
                </div>
                <h2 class="font-outfit font-black text-5xl lg:text-7xl leading-none text-white">
                    Happening&nbsp;
                    <span class="x-mn5kbrf0">
                        @ RGU
                    </span>
                </h2>
            </div>
            <div>
                <p class="text-slate-400 text-lg leading-relaxed font-inter mb-5">
                    From global summits to hackathons, leadership expeditions to cultural fests — the campus is always alive with opportunity.
                </p>
                <!-- Filter pills -->
                <div class="flex flex-wrap gap-2" id="event-filters" role="group" aria-label="Filter events by type">
                    @foreach ($filters as $f)                    <button
                        class="filter-btn {!! $f === 'All' ? 'active' : '' !!}"
                        data-filter="{{ $f }}"
                        aria-pressed="{!! $f === 'All' ? 'true' : 'false' !!}">
                        {{ $f }}                    </button>
                    @endforeach                </div>
            </div>
        </div>

        <!-- Event Cards -->
        <div id="events-grid" class="reveal-up grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($events as $ev)            <article class="event-card group rounded-3xl border p-7 relative overflow-hidden cursor-default transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1"
                     data-tag="{{ $ev['tag'] }}"
                     style="background: {!! $ev['color'] !!}07; border-color: {!! $ev['color'] !!}25;"
                     onmouseenter="this.style.boxShadow='0 20px 60px {!! $ev['color'] !!}18'"
                     onmouseleave="this.style.boxShadow='none'">

                <!-- Top edge glow -->
                <div class="absolute top-0 left-0 right-0 h-px opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                     style="background: linear-gradient(90deg,transparent,{!! $ev['color'] !!},transparent);"
                     aria-hidden="true"></div>

                <!-- Icon + tag row -->
                <div class="flex items-start justify-between mb-5">
                    <div class="w-11 h-11 rounded-2xl flex items-center justify-center"
                         style="background: {!! $ev['color'] !!}15; border: 1px solid {!! $ev['color'] !!}30;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="{!! $ev['color'] !!}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            {!! $ev['icon'] !!}                        </svg>
                    </div>
                    <span class="text-[10px] font-inter font-bold px-2.5 py-1 rounded-full"
                          style="background: {!! $ev['color'] !!}15; color: {!! $ev['color'] !!}; border: 1px solid {!! $ev['color'] !!}30;">
                        {{ $ev['tag'] }}                    </span>
                </div>

                <!-- Meta -->
                <p class="text-[10px] font-inter font-bold uppercase tracking-wider mb-2" style="color: {!! $ev['color'] !!};">{{ $ev['category'] }}</p>
                <h4 class="font-outfit font-bold text-white text-lg leading-tight mb-3">{{ $ev['title'] }}</h4>
                <p class="text-slate-400 text-sm font-inter leading-relaxed">{{ $ev['desc'] }}</p>

                <!-- Date row -->
                <div class="mt-5 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full" style="background: {!! $ev['color'] !!};" aria-hidden="true"></div>
                    <span class="text-[11px] text-slate-500 font-inter font-semibold">{{ $ev['date'] }}</span>
                </div>
            </article>
            @endforeach        </div>

    </div>
</section>
