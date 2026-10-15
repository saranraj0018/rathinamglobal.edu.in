<!-- FILE: partials/life at rgu.php -->


<section id="life" class="relative py-32 overflow-hidden x-1iinqwah"
        >

    <!-- Background glow -->
    <div class="absolute w-[600px] h-[600px] rounded-full pointer-events-none x-1vtjx1ur"
        
         aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Header row -->
        <div class="reveal-up grid lg:grid-cols-2 gap-12 items-end mb-16">
            <div>
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border mb-6 x-vki7xc9x"
                    >
                    <span class="w-1.5 h-1.5 rounded-full x-1rjmphzq"></span>
                    <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase">The Campus Experience</span>
                </div>
                <h2 class="font-outfit font-black text-5xl lg:text-7xl leading-none text-white">
                    Life @&nbsp;
                    <span class="x-27qyjn2k">
                        RGU
                    </span>
                </h2>
            </div>
            <div>
                <p class="text-slate-400 text-lg leading-relaxed font-inter">
                    Life at RGU extends far beyond classrooms — a vibrant, global community where students learn, grow, explore, and lead every single day.
                </p>
                <a href="#explore-campus"
                   class="mt-5 inline-flex items-center gap-2 font-inter font-bold text-sm transition-all duration-300 hover:gap-4 x-26w5thcp"
                  >
                    Explore Campus Life <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>

        <!-- Bento Grid -->
        <div class="reveal-up delay-200 grid grid-cols-2 lg:grid-cols-3 gap-4 mb-14">
            @foreach ($bento as $item)            <div class="group rounded-3xl border p-7 flex flex-col justify-end min-h-[160px] relative overflow-hidden cursor-default transition-all duration-300 hover:scale-[1.02] hover:-translate-y-1 {!! $item['span'] !!}"
                 style="background: {!! $item['bg'] !!}; border-color: {!! $item['border'] !!};">

                <!-- Top edge glow on hover -->
                <div class="absolute top-0 left-0 right-0 h-px opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                     style="background: linear-gradient(90deg,transparent,{!! $item['c'] !!},transparent);"
                     aria-hidden="true"></div>

                <!-- Icon -->
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center mb-4"
                     style="background: {!! $item['c'] !!}18; border: 1px solid {!! $item['c'] !!}30;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                         stroke="{!! $item['c'] !!}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         aria-hidden="true">
                        {!! $item['icon'] !!}                    </svg>
                </div>

                <h4 class="font-outfit font-bold text-white text-lg leading-tight">{!! $item['label'] !!}</h4>
                <p class="text-slate-500 text-xs font-inter mt-1">{!! $item['sub'] !!}</p>
            </div>
            @endforeach        </div>

        <!-- Pill highlights row -->
        <div class="reveal-up delay-400 flex flex-wrap gap-3">
            @foreach ($highlights as $h)            <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full border transition-all duration-300 hover:scale-105"
                 style="background: {!! $h['bg'] !!}; border-color: {!! $h['c'] !!}30; color: {!! $h['c'] !!};">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    {!! $h['icon'] !!}                </svg>
                <span class="text-xs font-inter font-bold">{!! $h['label'] !!}</span>
            </div>
            @endforeach        </div>

    </div>
</section>