<!-- FILE: partials/hero.php -->

<section id="hero" class="relative min-h-screen flex flex-col overflow-hidden x-1rx1uw2h">

    <!-- ── CINEMATIC REVEAL BARS ── -->
    <div class="cine-top"    id="cine-top"    aria-hidden="true"></div>
    <div class="cine-bottom" id="cine-bottom" aria-hidden="true"></div>

    <!-- ── BACKGROUND VIDEO ── -->
    <div class="absolute inset-0 overflow-hidden">
        <video
            id="hero-video"
            autoplay muted loop playsinline
            class="absolute w-full h-full object-cover x-28ln99lr"
           
        >
            <source src="{{ storage_asset('rgu-way/assets/images/bgvideo.mp4') }}" type="video/mp4" />
        </video>
    </div>

    <!-- ── CURSOR SPOTLIGHT ── -->
    <div id="hero-spotlight" class="absolute inset-0 pointer-events-none z-10 x-191o35t1"
        >
    </div>

    <!-- ── COLOR GRADE ── -->
    <div class="absolute inset-0 pointer-events-none z-10 x-1nekhsmo"
        
         aria-hidden="true"></div>

    <!-- ── SCAN LINE ── -->
    <div class="scan-line" aria-hidden="true"></div>

    <!-- ── FILM GRAIN ── -->
    <div class="absolute inset-0 pointer-events-none z-10 opacity-[0.032] x-1w5c97zv"
        
         aria-hidden="true"></div>

    <!-- ── MAIN CONTENT ── -->
    <div class="relative z-30 flex-1 flex flex-col justify-center max-w-7xl mx-auto w-full px-6 pt-28 pb-6">
        <div class="grid lg:grid-cols-12 gap-10 xl:gap-16 items-center">

            <!-- LEFT – Headline column -->
            <div class="lg:col-span-7 space-y-7">

                <!-- Eyebrow pill -->
                <div class="hero-fade-up-1 inline-flex items-center gap-2.5 px-4 py-2 rounded-full border border-white/[0.14] backdrop-blur-md x-1hzmhkqx"
                    >
                    <span class="w-1.5 h-1.5 rounded-full x-1rjmphzq"></span>
                    <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase text-white/60">
                        Deemed to be University · Tamil Nadu
                    </span>
                </div>

                <!-- H1 -->
                <h1 class="hero-fade-up-2 font-outfit font-black leading-[1.1] md:leading-[0.9]">
                    <span class="block text-[clamp(1.8rem,6.2vw,5.4rem)] mb-1 x-155vfnnx"
                         >
                        Where Students
                    </span>
                    <span class="block text-[clamp(2.2rem,7.8vw,7rem)] text-white hero-glow-pulse x-rb1863cy"
                         >
                        Transform
                    </span>
                    <span class="block text-[clamp(1.8rem,5.8vw,5.2rem)] mt-1 x-17ithnnv"
                         >
                        Into Leaders.
                    </span>
                </h1>

                <!-- Subheading -->
                <p class="hero-fade-up-3 text-white/55 text-lg font-inter leading-relaxed max-w-lg">
                    Rathinam Global University's signature model — every semester
                    adds <span class="text-white font-semibold">measurable, stacked value</span>.
                    Not just a degree. A full transformation.
                </p>

                <!-- CTA Buttons -->
                <div class="hero-fade-up-4 flex flex-wrap gap-4">
                    <a href="#rgu-way"
                       class="group relative px-8 py-4 rounded-2xl font-outfit font-bold text-base text-white overflow-hidden inline-flex items-center gap-2 transition-all duration-300 x-1s7q9og1"
                      >
                        Explore the RGU Way
                        <span class="group-hover:translate-x-1 transition-transform duration-300" aria-hidden="true">→</span>
                    </a>
                    <a href="#apply"
                       class="group px-8 py-4 rounded-2xl font-outfit font-bold text-base border text-white backdrop-blur-md hover:bg-white/10 transition-all duration-300 inline-flex items-center gap-2 x-t3n1xdbx"
                      >
                        Apply Now
                        <span class="group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-300" aria-hidden="true">↗</span>
                    </a>
                </div>

                <!-- Floating Tags -->
                <div class="hero-fade-up-5 flex flex-wrap gap-2.5">
                    <span class="tag-float-0 text-[11px] font-inter font-bold px-3.5 py-1.5 rounded-full x-193h7ej3"
                         >
                        ✦ Global Readiness
                    </span>
                    <span class="tag-float-1 text-[11px] font-inter font-bold px-3.5 py-1.5 rounded-full x-245q1dt3"
                         >
                        ✦ Career Readiness
                    </span>
                    <span class="tag-float-2 text-[11px] font-inter font-bold px-3.5 py-1.5 rounded-full x-cqvubgtm"
                         >
                        ✦ Future Readiness
                    </span>
                </div>
            </div>

            <!-- RIGHT – Glass stats card -->
            <div class="lg:col-span-5 hero-fade-r">
                <div class="rounded-3xl p-7 xl:p-8 space-y-6 x-1bnss2ix"
                    >

                    <!-- Logo inside card -->
                    <div class="rounded-2xl p-3 overflow-hidden x-1d5va7yz">
                        <img src="{{ storage_asset('rgu-way/assets/images/logo.webp') }}" alt="Rathinam Global University logo" class="w-full h-14 object-contain" />
                    </div>

                    <!-- Formula row -->
                    <div>
                        <p class="text-white/40 text-[10px] font-bold tracking-[0.28em] uppercase mb-3 font-inter">The RGU Formula</p>
                        <div class="flex items-center flex-wrap gap-2">
                            <span class="text-[11px] font-inter font-bold px-3 py-1.5 rounded-full x-4ms7m349">Global</span>
                            <span class="text-sm font-bold font-outfit x-1segtw7a">+</span>
                            <span class="text-[11px] font-inter font-bold px-3 py-1.5 rounded-full x-272ugeqy">Career</span>
                            <span class="text-sm font-bold font-outfit x-1segtw7a">+</span>
                            <span class="text-[11px] font-inter font-bold px-3 py-1.5 rounded-full x-2fnws3y6">Future</span>
                            <span class="text-sm font-bold font-outfit x-1segtw7a">=</span>
                            <span class="text-[11px] font-inter font-bold px-3 py-1.5 rounded-full x-pw03lvfq">RGU Way</span>
                        </div>
                    </div>

                    <div class="h-px x-1vtnkabh"></div>

                    <!-- Stats grid -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-center p-4 rounded-2xl flex flex-col items-center x-v59kdvmj"
                            >
                            <span class="hero-counter text-3xl xl:text-4xl font-black font-outfit tabular-nums x-2f0hfc3i" data-target="6" data-suffix="">0</span>
                            <p class="text-white/45 text-[11px] mt-1.5 font-inter leading-snug">Global Certifications</p>
                        </div>
                        <div class="text-center p-4 rounded-2xl flex flex-col items-center x-v59kdvmj"
                            >
                            <span class="hero-counter text-3xl xl:text-4xl font-black font-outfit tabular-nums x-1ud3831p" data-target="2" data-suffix="">0</span>
                            <p class="text-white/45 text-[11px] mt-1.5 font-inter leading-snug">Internships / Year</p>
                        </div>
                        <div class="text-center p-4 rounded-2xl flex flex-col items-center x-v59kdvmj"
                            >
                            <span class="hero-counter text-3xl xl:text-4xl font-black font-outfit tabular-nums x-2f0hfc3i" data-target="100" data-suffix="%">0</span>
                            <p class="text-white/45 text-[11px] mt-1.5 font-inter leading-snug">Career Readiness</p>
                        </div>
                        <div class="text-center p-4 rounded-2xl flex flex-col items-center x-v59kdvmj"
                            >
                            <span class="hero-counter text-3xl xl:text-4xl font-black font-outfit tabular-nums x-10ex1de9" data-target="40" data-suffix="+">0</span>
                            <p class="text-white/45 text-[11px] mt-1.5 font-inter leading-snug">Global Partners</p>
                        </div>
                    </div>

                    <!-- CTA inside card -->
                    <a href="#apply"
                       class="block w-full text-center py-3.5 rounded-2xl font-outfit font-bold text-sm text-black transition-all duration-300 hover:brightness-110 hover:scale-[1.02] x-1noaoa4o"
                      >
                        Start Your Transformation →
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- ── SCROLLING TICKER ── -->
    <div class="relative z-30 border-t overflow-hidden x-ts9p5zoh"
        >
        <div class="ticker-track flex py-3" aria-hidden="true">
            <!-- Two copies for seamless loop -->
            @foreach ([1, 2] as $copy)
                @foreach ($tickerItems as $item)
                    <span class="inline-flex items-center gap-2 text-white/40 text-xs font-bold uppercase tracking-[0.18em] mx-8 font-inter whitespace-nowrap">{{ $item }}<span class="x-lime45">◆</span></span>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- ── SCROLL INDICATOR ── -->
    <div class="absolute bottom-20 left-1/2 -translate-x-1/2 z-30 flex flex-col items-center gap-2" aria-hidden="true">
        <span class="text-white/25 text-[10px] font-inter tracking-[0.3em] uppercase">Scroll</span>
        <div class="relative w-5 h-9 rounded-full flex justify-center items-start pt-2 x-tagazixu"
            >
            <div class="scroll-dot w-1 h-2.5 rounded-full x-2bkzzrpf"></div>
        </div>
    </div>

</section>
