<!-- FILE: partials/projected outcomes.php -->


<section id="outcomes" class="relative py-32 overflow-hidden x-2j54d21u"
        >

    <!-- Background glows -->
    <div class="absolute w-[600px] h-[600px] rounded-full pointer-events-none x-1qa1aipt"
        
         aria-hidden="true"></div>
    <div class="absolute w-[500px] h-[500px] rounded-full pointer-events-none x-yy3md8bn"
        
         aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <div class="reveal-up text-center mb-20">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border mb-8 x-2lq30uz8"
                >
                <span class="w-1.5 h-1.5 rounded-full x-1ocpl70d"></span>
                <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase">Transformation Agenda</span>
            </div>
            <h2 class="font-outfit font-black text-5xl lg:text-7xl text-white leading-tight mb-6 tracking-tighter">
                Projected&nbsp;
                <span class="x-27tx2ehx">
                    Outcomes
                </span>
            </h2>
            <p class="text-slate-400 text-lg lg:text-xl max-w-3xl mx-auto leading-relaxed font-inter">
                The RGU Way doesn't just prepare you for a job — it prepares you for a life of
                <span class="text-white font-semibold">impact, leadership</span>, and global significance.
            </p>
        </div>

        <!-- Outcome Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">
            @foreach ($outcomes as $i => $o)            <div class="reveal-up delay-{!! $i * 100 !!} group relative rounded-3xl p-8 border overflow-hidden cursor-default transition-all duration-700 hover:scale-[1.02] hover:-translate-y-1 outcome-card"
                 style="background: {!! $o['bg'] !!}; border-color: {!! $o['border'] !!}; border-top: 2px solid {!! $o['color'] !!};"
                 onmouseenter="this.querySelector('.outcome-fill').style.width='100%'; this.style.boxShadow='0 20px 60px {!! $o['color'] !!}20'; this.querySelector('.outcome-icon').style.transform='rotate(12deg) scale(1.1)';"
                 onmouseleave="this.querySelector('.outcome-fill').style.width='25%'; this.style.boxShadow='none'; this.querySelector('.outcome-icon').style.transform='none';">

                <!-- Top glow -->
                <div class="absolute top-0 left-0 right-0 h-px opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                     style="background: linear-gradient(90deg,transparent,{!! $o['color'] !!},transparent);"
                     aria-hidden="true"></div>

                <!-- Stat + icon row -->
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="font-outfit font-black text-4xl lg:text-5xl" style="color: {!! $o['color'] !!};">{!! $o['stat'] !!}</div>
                        <div class="text-slate-500 text-[10px] font-bold font-inter uppercase tracking-[0.2em] mt-0.5">{!! $o['statLabel'] !!}</div>
                    </div>
                    <div class="outcome-icon w-12 h-12 rounded-2xl flex items-center justify-center transition-transform duration-300"
                         style="background: {!! $o['color'] !!}18; border: 1px solid {!! $o['color'] !!}30;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                             stroke="{!! $o['color'] !!}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             aria-hidden="true">
                            {!! $o['icon'] !!}                        </svg>
                    </div>
                </div>

                <h3 class="font-outfit font-bold text-xl text-white mb-3">{!! $o['title'] !!}</h3>
                <p class="text-slate-400 text-sm font-inter leading-relaxed">{!! $o['desc'] !!}</p>

                <!-- Progress bar -->
                <div class="mt-6 h-0.5 rounded-full overflow-hidden x-1vtnkabh" aria-hidden="true">
                    <div class="outcome-fill h-full rounded-full transition-all duration-500"
                         style="width: 25%; background: {!! $o['color'] !!};"></div>
                </div>
            </div>
            @endforeach        </div>

        <!-- Summary Banner -->
        <div class="reveal-up delay-700 rounded-3xl border p-10 lg:p-14 text-center x-16arw0p5"
            >
            <h3 class="font-outfit font-black text-3xl lg:text-4xl text-white mb-4">
                One Journey.&nbsp;
                <span class="x-27tx2ehx">
                    Five Transformations.
                </span>
            </h3>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto mb-10 font-inter leading-relaxed">
                Every element of the RGU Way is designed to compound — creating a graduate comprehensively ready for the world.
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach ($outcomes as $o)                <div class="px-5 py-2.5 rounded-2xl text-xs font-bold font-inter tracking-wide transition-all duration-300 hover:scale-105"
                     style="background: {!! $o['bg'] !!}; color: {!! $o['color'] !!}; border: 1px solid {!! $o['border'] !!};">
                    {!! $o['title'] !!}                </div>
                @endforeach            </div>
        </div>

    </div>
</section>
