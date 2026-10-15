<!-- FILE: partials/core brand promise.php -->


<section id="core-promise" class="relative py-32 overflow-hidden x-1rx1uw2h">

    <!-- Grid texture -->
    <div class="absolute inset-0 pointer-events-none grid-texture" aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <div class="reveal-up text-center mb-20">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border mb-8 x-vki7xc9x"
                >
                <span class="w-1.5 h-1.5 rounded-full x-1rjmphzq"></span>
                <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase">The RGU Way</span>
            </div>
            <h2 class="font-outfit font-black text-5xl lg:text-7xl leading-tight mb-6 tracking-tighter text-white">
                Built for&nbsp;
                <span class="x-2loa7bvs">
                    Global Readiness
                </span>
            </h2>
            <p class="text-slate-400 text-lg lg:text-xl max-w-3xl mx-auto leading-relaxed font-inter">
                RGU Way ensures students begin building their profile from
                <span class="text-white font-bold">semester one</span>
                — every element designed to stack, compound, and transform.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach ($cards as $card)            <div class="reveal-up delay-{!! $card['delay'] !!} group relative rounded-3xl p-7 border overflow-hidden cursor-default transition-all duration-700 hover:scale-[1.02] hover:-translate-y-1"
                 style="background: {!! $card['bg'] !!}; border-color: {!! $card['border'] !!};"
                 onmouseenter="this.style.boxShadow='0 20px 60px {!! $card['color'] !!}20'"
                 onmouseleave="this.style.boxShadow='none'">

                <!-- Top edge glow (visible on hover via CSS group) -->
                <div class="absolute top-0 left-0 right-0 h-px opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                     style="background: linear-gradient(90deg,transparent,{!! $card['color'] !!},transparent);"
                     aria-hidden="true"></div>

                <!-- Icon box -->
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-5"
                     style="background: {!! $card['color'] !!}18; border: 1px solid {!! $card['color'] !!}30;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                         stroke="{!! $card['color'] !!}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         aria-hidden="true">
                        {!! $card['icon'] !!}                    </svg>
                </div>

                <!-- Text -->
                <h3 class="font-outfit font-bold text-xl text-white mb-1">{!! $card['title'] !!}</h3>
                <p class="text-[11px] font-inter font-bold uppercase tracking-wider mb-4" style="color: {!! $card['color'] !!};">{!! $card['sub'] !!}</p>
                <p class="text-slate-400 text-sm font-inter leading-relaxed">{!! $card['desc'] !!}</p>

                <!-- Bottom accent bar -->
                <div class="absolute bottom-0 left-0 right-0 h-0.5 scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"
                     style="background: linear-gradient(90deg,{!! $card['color'] !!},transparent);"
                     aria-hidden="true"></div>
            </div>
            @endforeach        </div>

    </div>
</section>
