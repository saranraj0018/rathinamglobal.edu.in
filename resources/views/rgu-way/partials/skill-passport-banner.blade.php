<!-- FILE: partials/skill passport banner.php -->


<section id="skill-passport" class="relative py-28 overflow-hidden x-1m1nx4v8"
        >

    <!-- Grid texture -->
    <div class="absolute inset-0 pointer-events-none grid-texture" aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <div class="reveal-up text-center mb-16">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border mb-6 x-vki7xc9x"
                >
                <span class="w-1.5 h-1.5 rounded-full x-1rjmphzq"></span>
                <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase">Track · Prove · Grow</span>
            </div>
            <h2 class="font-outfit font-black text-4xl lg:text-5xl text-white">Your RGU Journey, Measured.</h2>
        </div>

        <!-- Two-panel card -->
        <div class="skill-passport-card reveal-scale rounded-3xl border overflow-hidden x-2grhakh0"
            >

            <!-- Top accent stripe (5 colors) -->
            <div class="h-1 flex" aria-hidden="true">
                @foreach (['#a855f7','#38bdf8','#a3e635','#f472b6','#fb923c'] as $c)                <div class="flex-1" style="background: {!! $c !!};"></div>
                @endforeach            </div>

            <!-- Panels -->
            <div class="grid lg:grid-cols-2 gap-0">

                <!-- ── Panel 1: Global Skill Passport ── -->
                <div class="p-10 lg:p-12 border-b lg:border-b-0 lg:border-r x-2nclm3ny"
                    >

                    <!-- Panel header -->
                    <div class="flex items-start gap-4 mb-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 x-he34m69u"
                            >
                            <!-- Globe icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                                 stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="2" y1="12" x2="22" y2="12"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-black text-2xl text-white leading-tight">Global Skill Passport</h3>
                            <span class="text-lg font-black x-fpcu1giw">100%</span>
                        </div>
                    </div>

                    <!-- Progress bars -->
                    <div class="rounded-2xl p-5 mb-6 border space-y-4 x-43w59aq7"
                        >
                        @foreach ($passportBars as $bar)                        <div>
                            <div class="flex justify-between text-[10px] font-bold font-inter mb-1.5 tracking-wider x-2gs0jml5"
                                >
                                <span>{{ $bar['label'] }}</span>
                                <span style="color: {!! $bar['color'] !!};">{!! $bar['pct'] !!}%</span>
                            </div>
                            <div class="h-1.5 rounded-full overflow-hidden x-1b2g8uep">
                                <div class="progress-bar" data-width="{!! $bar['pct'] !!}" style="background: {!! $bar['color'] !!};"></div>
                            </div>
                        </div>
                        @endforeach                    </div>

                    <p class="text-slate-400 text-sm font-inter leading-relaxed">
                        A living digital credential — recording every certification, internship, exposure, and milestone accumulated throughout your RGU journey.
                    </p>
                    <a href="#" class="mt-4 inline-flex items-center gap-2 text-sm font-inter font-bold x-1vm7ftr3">
                        Learn more →
                    </a>
                </div>

                <!-- ── Panel 2: Growth Card ── -->
                <div class="p-10 lg:p-12">

                    <!-- Panel header -->
                    <div class="flex items-start gap-4 mb-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 x-2r7qck6y"
                            >
                            <!-- BarChart icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                                 stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <line x1="18" y1="20" x2="18" y2="10"/>
                                <line x1="12" y1="20" x2="12" y2="4"/>
                                <line x1="6"  y1="20" x2="6"  y2="14"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-outfit font-black text-2xl text-white leading-tight">Growth Card</h3>
                            <span class="text-lg font-black x-2f0hfc3i">100%</span>
                        </div>
                    </div>

                    <!-- Growth progress bars -->
                    <div class="rounded-2xl p-5 mb-6 border space-y-4 x-ga2l23u8"
                        >

                        <!-- Live indicator row -->
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[10px] font-bold tracking-[0.2em] uppercase font-inter x-2f0hfc3i">Metrics Tracking</span>
                            <div class="w-2 h-2 rounded-full x-1rjmphzq"></div>
                        </div>

                        @foreach ($growthBars as $bar)                        <div>
                            <div class="flex justify-between text-[10px] font-bold font-inter mb-1.5">
                                <span class="text-slate-400">{{ $bar['label'] }}</span>
                                <span style="color: {!! $bar['color'] !!};">{!! $bar['pct'] !!}%</span>
                            </div>
                            <div class="h-2 rounded-full overflow-hidden x-1b2g8uep">
                                <div class="progress-bar" data-width="{!! $bar['pct'] !!}" style="background: {!! $bar['color'] !!};"></div>
                            </div>
                        </div>
                        @endforeach                    </div>

                    <p class="text-slate-400 text-sm font-inter leading-relaxed">
                        Your personal progress tracker — a semester-by-semester snapshot measuring how far you've come and where you're headed.
                    </p>
                    <a href="#" class="mt-4 inline-flex items-center gap-2 text-sm font-inter font-bold x-26w5thcp">
                        Explore Metrics →
                    </a>
                </div>
            </div>

            <!-- Bottom bar -->
            <div class="px-10 lg:px-12 py-5 flex items-center justify-between border-t x-15lo15h6"
                >
                <p class="text-slate-500 text-xs font-inter">Together, the Skill Passport and Growth Card form your complete RGU transformation record.</p>
                <div class="flex gap-2" aria-hidden="true">
                    @foreach (['#a855f7','#38bdf8','#a3e635'] as $c)                    <div class="w-2 h-2 rounded-full" style="background: {!! $c !!};"></div>
                    @endforeach                </div>
            </div>
        </div>

    </div>
</section>
