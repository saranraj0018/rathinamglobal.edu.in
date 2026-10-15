<!-- FILE: partials/what is rgu way.php -->


<section id="rgu-way" class="relative py-32 overflow-hidden x-2pmexn61"
        >

    <!-- Background accent blobs -->
    <div class="absolute w-[500px] h-[500px] rounded-full pointer-events-none x-nv7rymn7"
        
         aria-hidden="true"></div>
    <div class="absolute w-[400px] h-[400px] rounded-full pointer-events-none x-1e4yw59n"
        
         aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <div class="reveal-up mb-20">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border mb-6 x-2b8amk6u"
                >
                <span class="w-1.5 h-1.5 rounded-full x-ob83mum3"></span>
                <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase">The Ecosystem</span>
            </div>
            <h2 class="font-outfit font-black text-4xl lg:text-6xl xl:text-7xl leading-tight x-1d3yttt3">
                What makes&nbsp;
                <span class="x-2loa7bvs">
                    RGU Way
                </span>&nbsp;different?
            </h2>
        </div>

        <!-- Two-column content -->
        <div class="grid lg:grid-cols-2 gap-16 items-start">

            <!-- Left – Explanation text -->
            <div class="reveal-up space-y-8">
                <p class="text-slate-400 text-lg leading-relaxed font-inter">
                    The higher education market is crowded with similar claims. Most institutions communicate
                    global exposure and internships as
                    <span class="text-slate-200 font-semibold">separate, disconnected features.</span>
                </p>
                <p class="text-slate-400 text-lg leading-relaxed font-inter">
                    RGU Way presents them as one
                    <span class="font-bold x-2f0hfc3i">integrated transformation ecosystem</span>
                    — shifting the conversation from what the university offers to what the student becomes.
                </p>

                <!-- FROM → TO card -->
                <div class="rounded-2xl p-6 border x-16arw0p5"
                    >
                    <p class="text-slate-500 text-[10px] font-inter tracking-[0.28em] uppercase mb-5 font-bold">The Shift</p>
                    <div class="flex items-center gap-4">
                        <!-- FROM -->
                        <div class="flex-1 p-4 rounded-xl text-center border x-1a8aen3l"
                            >
                            <p class="text-[10px] text-slate-500 font-inter mb-2 font-bold uppercase tracking-wider">FROM</p>
                            <p class="font-outfit font-semibold text-slate-300 text-sm">"What the university offers"</p>
                        </div>

                        <!-- Arrow -->
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold text-black text-base x-1sop2cen"
                             aria-hidden="true">→</div>

                        <!-- TO -->
                        <div class="flex-1 p-4 rounded-xl text-center border x-2c52c6co"
                            >
                            <p class="text-[10px] font-inter mb-2 font-bold uppercase tracking-wider x-2f0hfc3i">TO</p>
                            <p class="font-outfit font-bold text-sm x-2f0hfc3i">"What the student becomes"</p>
                        </div>
                    </div>
                </div>

                <p class="text-slate-400 text-base leading-relaxed font-inter">
                    Every semester adds <span class="text-slate-200 font-semibold">measurable value</span>
                    — globally ready, career ready, and future ready.
                </p>
            </div>

            <!-- Right – Year timeline -->
            <div class="reveal-up delay-300 relative pl-8">

                <!-- Vertical spine -->
                <div class="absolute left-0 top-2 bottom-2 w-0.5 rounded-full x-1nn9zdnv"
                    
                     aria-hidden="true"></div>

                @foreach ($years as $yr)                <div class="relative mb-7 last:mb-0">

                    <!-- Timeline dot -->
                    <div class="absolute w-4 h-4 rounded-full border-2"
                         style="background: {!! $yr['color'] !!}; top: 12px; left: -34px; border-color: #0f0f1e; box-shadow: 0 0 0 3px {!! $yr['color'] !!}30;"
                         aria-hidden="true"></div>

                    <!-- Year card -->
                    <div class="rounded-2xl p-6 ml-4 border transition-all duration-300 hover:scale-[1.01]"
                         style="background: {!! $yr['bg'] !!}; border-color: {!! $yr['border'] !!}; border-left: 3px solid {!! $yr['color'] !!};">

                        <!-- Header row -->
                        <div class="flex items-center gap-3 mb-3">
                            <span class="text-[10px] font-inter font-bold px-2.5 py-1.5 rounded-full"
                                  style="background: {!! $yr['color'] !!}20; color: {!! $yr['color'] !!}; border: 1px solid {!! $yr['color'] !!}40;">
                                {!! $yr['sem'] !!}                            </span>
                            <h4 class="font-outfit font-bold text-slate-100 text-lg">{!! $yr['title'] !!}</h4>
                        </div>

                        <!-- Items list -->
                        <ul class="space-y-2" role="list">
                            @foreach ($yr['items'] as $item)                            <li class="flex items-center gap-2 text-sm text-slate-400 font-inter">
                                <span style="color: {!! $yr['color'] !!};" aria-hidden="true">✦</span>
                                {{ $item }}                            </li>
                            @endforeach                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
