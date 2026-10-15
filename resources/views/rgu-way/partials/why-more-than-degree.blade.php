<!-- FILE: partials/why more than degree.php -->


<section id="why" class="relative py-28 overflow-hidden x-1rx1uw2h">

    <!-- Background glow blobs -->
    <div class="absolute w-[400px] h-[400px] rounded-full pointer-events-none x-1ihfzq27"
        
         aria-hidden="true"></div>

    <!-- Grid texture overlay -->
    <div class="absolute inset-0 pointer-events-none grid-texture" aria-hidden="true"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-6">

        <!-- Section Header -->
        <div class="reveal-up text-center mb-20">
            <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border mb-6 x-1jtmqsb4"
                >
                <span class="w-1.5 h-1.5 rounded-full x-2j2mglol"></span>
                <span class="text-[10px] font-inter font-bold tracking-[0.28em] uppercase">The Question</span>
            </div>
            <h2 class="font-outfit font-black text-4xl lg:text-6xl text-white leading-tight mb-6">
                Why do students need&nbsp;
                <span class="x-27qyjn2k">
                    more than just a degree?
                </span>
            </h2>
            <p class="text-slate-400 text-xl max-w-3xl mx-auto leading-relaxed font-inter">
                The future belongs to students who can
                <span class="text-white font-semibold">adapt, lead, communicate,</span> and
                <span class="text-white font-semibold">perform</span> in real environments.
                RGU Way is built to develop exactly that.
            </p>
        </div>

        <!-- Pillar Cards Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5 mb-20">
            @foreach ($pillars as $i => $p)            <div class="reveal-up delay-{!! $i * 120 !!} group rounded-3xl p-8 text-center border transition-all duration-700 hover:scale-[1.03] hover:-translate-y-1 cursor-default card-hover"
                 style="background: {!! $p['bg'] !!}; border-color: {!! $p['border'] !!}; border-top: 2px solid {!! $p['color'] !!};"
                 onmouseenter="this.style.boxShadow='0 20px 60px {!! $p['color'] !!}20'"
                 onmouseleave="this.style.boxShadow='none'">

                <!-- Icon -->
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5 transition-transform duration-300 group-hover:scale-110"
                     style="background: {!! $p['color'] !!}18; border: 1px solid {!! $p['color'] !!}30;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
                         stroke="{!! $p['color'] !!}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $p['icon'] !!}                    </svg>
                </div>

                <h3 class="font-outfit font-black text-2xl mb-3" style="color: {!! $p['color'] !!};">{!! $p['title'] !!}</h3>
                <p class="text-slate-400 text-sm font-inter leading-relaxed">{!! $p['desc'] !!}</p>
            </div>
            @endforeach        </div>

        <!-- Quote Banner -->
        <div class="reveal-scale delay-500 relative rounded-3xl overflow-hidden border x-16arw0p5"
            >

            <!-- BG watermark text -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none" aria-hidden="true">
                <span class="font-outfit font-black leading-none text-white tracking-tighter x-2ohqk6kd"
                     >RGU</span>
            </div>

            <!-- Top gradient border line -->
            <div class="absolute top-0 left-0 right-0 h-px x-7im9klez"
                
                 aria-hidden="true"></div>

            <!-- Quote content -->
            <div class="relative z-10 p-10 lg:p-16 text-center">
                <blockquote class="font-outfit font-bold text-2xl lg:text-4xl leading-relaxed text-white">
                    "A degree opens the door.&nbsp;
                    <span class="x-y613o5j2">
                        The RGU Way
                    </span>
                    &nbsp;makes you ready for what's on the other side."
                </blockquote>
                <div class="mt-6 flex items-center justify-center gap-4">
                    <div class="h-px w-16 rounded-full x-234oi025"></div>
                    <cite class="text-slate-500 text-sm font-inter tracking-widest uppercase not-italic">Rathinam Global University</cite>
                    <div class="h-px w-16 rounded-full x-17msz2pz"></div>
                </div>
            </div>
        </div>

    </div>
</section>
