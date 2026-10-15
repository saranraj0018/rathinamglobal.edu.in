<section class="h-auto md:h-[100vh] banner">

    @include('partials.nav')

    <!-- ===== MAIN CONTENT: [Left Circles] + [Right Stats] ===== -->
    <div class="flex items-start gap-0 px-2 md:px-8 lg:px-12 xl:px-16 pt-2 md:pt-6 pb-6 md:pb-0">

        <!-- -- LEFT SIDEBAR: 3 Circles (vertical, both mobile & desktop) -- -->
        <div class="flex flex-col items-center gap-3 md:gap-6 w-[72px] md:w-[110px] flex-shrink-0 relative z-10 pt-1 md:pt-4">
            <a href="#ranking-excellence" aria-label="Jump to Ranking Excellence section" onclick="document.getElementById('ranking-excellence').scrollIntoView({behavior:'smooth'}); return false;" class="text-white bg-[#ffffff1c] backdrop-blur-md rounded-full w-14 md:w-20 h-14 md:h-20 border border-zinc-50 flex flex-col items-center justify-center floating-card float-delay-1 cursor-pointer hover:bg-[#ffffff30] transition-all">
                <span class="badge flex items-center justify-center" aria-hidden="true"></span>
                <p class="text-[5px] md:text-[8px] text-center leading-tight mt-1">RANKING<br>EXCELLENCE</p>
            </a>
            <a href="{{ route('rgu-way') }}" target="_blank" rel="noopener" aria-label="RGU Way - Visit Admissions" class="text-white bg-[#ffffff1c] backdrop-blur-md rounded-full w-14 md:w-20 h-14 md:h-20 border border-zinc-50 flex flex-col items-center justify-center floating-card float-delay-4 cursor-pointer hover:bg-[#ffffff30] transition-all">
                <span class="lightning flex items-center justify-center" aria-hidden="true"></span>
                <p class="text-[5px] md:text-[8px] text-center leading-tight mt-1">RGU WAY</p>
            </a>
            <a href="https://admissions.rathinamcollege.edu.in/?utm_source=footer&utm_medium=button&utm_campaign=Admission&utm_term=Apply+now%2C+footer%2C+Admission" target="_blank" rel="noopener" aria-label="Admissions Open - Apply Now" class="text-white bg-[#ffffff1c] backdrop-blur-md rounded-full w-14 md:w-20 h-14 md:h-20 border border-zinc-50 flex flex-col items-center justify-center floating-card float-delay-4 cursor-pointer hover:bg-[#ffffff30] transition-all">
                <span class="PaperRocket flex items-center justify-center" aria-hidden="true"></span>
                <p class="text-[5px] md:text-[8px] text-center leading-tight mt-1">ADMISSION<br>OPEN</p>
            </a>
        </div>
        <!-- -- END LEFT SIDEBAR -- -->


        <!-- -- RIGHT: Stats Area -- -->
        <div class="flex-1 min-w-0 relative z-10">

            
            <div class="md:hidden relative x-5psj71au">

                <!-- CENTER TIP: 1st in Tamil Nadu Under UGC 2023 -->
                <div class="absolute text-center x-19o9kxmu">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">Under UGC 2023</p>
                    <p class="stat-value text-[14px] font-black text-white leading-tight whitespace-nowrap x-ctop216d">1st in</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">TAMIL NADU</p>
                    <div class="mx-auto mt-1 w-[1px] h-[400px] bg-white/40 relative">
                        <span class="absolute bottom-[380px] left-1/2 -translate-x-1/2 w-[9px] h-[9px] rounded-full bg-white shadow-[0_0_0_5px_rgba(255,255,255,0.18),0_0_0_13px_rgba(255,255,255,0.09),0_0_32px_12px_rgba(255,255,255,0.65)] animate-pulse"></span>
                    </div>
                </div>

                <!-- ROW 1 LEFT: QS I-GAUGE PLATINUM -->
                <div class="absolute text-center x-l2e5nx2u">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">EXCELLENCE</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">AICTE</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">APPROVED</p>
                    <div class="mx-auto mt-1 w-[1px] h-[280px] bg-white/30 relative">
                        <span class="absolute bottom-[268px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

                

                <!-- ROW 1 RIGHT: NAAC A++ -->
                <div class="absolute text-center x-o0h3ju4x">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">QS I-Gauge</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">PLATINUM</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">Rank</p>
                    <div class="mx-auto mt-1 w-[1px] h-[280px] bg-white/30 relative">
                        <span class="absolute bottom-[268px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

                

                <!-- ROW 2 LEFT: NIRF RANKING 9TH -->
                <div class="absolute text-center x-2t2zi4jt">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">NAAC</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">A++</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">Accredited</p>
                    <div class="mx-auto mt-1 w-[1px] h-[180px] bg-white/30 relative">
                        <span class="absolute bottom-[170px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

                

                <!-- ROW 2 RIGHT: NIRF INNOVATION TOP 50 -->
                <div class="absolute text-center x-1k9udzv8">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">NIRF Ranking</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">9TH</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">Year in a Row</p>
                    <div class="mx-auto mt-1 w-[1px] h-[180px] bg-white/30 relative">
                        <span class="absolute bottom-[170px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

               

                <!-- ROW 3 LEFT: GLOBAL NETWORK 100+ -->
                <div class="absolute text-center stat-edge-left x-5oxjqcq3">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">NIRF Innovation</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">TOP 50</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">In India</p>
                    <div class="mx-auto mt-1 w-[1px] h-[60px] bg-white/30 relative">
                        <span class="absolute bottom-[50px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

                

                <!-- ROW 3 RIGHT: GLOBAL REACH 1000+ -->
                <div class="absolute text-center x-2r3mk9r5">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">Global Network</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">100+</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-tight">Global Partners</p>
                    <div class="mx-auto mt-1 w-[1px] h-[60px] bg-white/30 relative">
                        <span class="absolute bottom-[50px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

                <!-- ROW 4 LEFT: INDIAS FIRST -->
                <div class="absolute text-center stat-edge-left x-182unhkj">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none">India's</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">FIRST</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-tight">Industry<br>Integrated<br>Institute</p>
                    <div class="mx-auto mt-1 w-[1px] h-[70px] bg-white/30 relative">
                        <span class="absolute bottom-[50px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

                <!-- ROW 4 RIGHT: IN-CAMPUS ATAL -->
                <div class="absolute text-center x-29913yo2">
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-none whitespace-nowrap">In-Campus</p>
                    <p class="stat-value text-[13px] font-black text-white leading-tight x-2fvr1wdl">ATAL</p>
                    <p class="uppercase text-gray-300 stat-label text-[8px] font-bold tracking-wide leading-tight">Incubation<br>Centre</p>
                    <div class="mx-auto mt-1 w-[1px] h-[70px] bg-white/30 relative">
                        <span class="absolute bottom-[50px] left-1/2 -translate-x-1/2 w-[7px] h-[7px] rounded-full bg-white shadow-[0_0_0_4px_rgba(255,255,255,0.12),0_0_0_10px_rgba(255,255,255,0.07),0_0_26px_8px_rgba(255,255,255,0.5)] animate-pulse"></span>
                    </div>
                </div>

            </div>
            <!-- ===================== END MOBILE STATS ===================== -->


            <!-- ===================== DESKTOP STATS ===================== -->
            <div class="hidden md:grid md:grid-cols-9 gap-x-2 lg:gap-x-3 xl:gap-x-5 pb-36 pt-4">

                <!-- Col 1 - 1st in Tamil Nadu | mt-0 | line 288px -->
                <div class="relative text-center mt-0">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">Under UGC 2023</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">1st in</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-tight">TAMIL NADU</p>
                    <div class="rising-wrap mt-2 x-16vhphxi">
                        <div class="rising-line rd-1"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>

                <!-- Col 2 - QS PLATINUM | mt-20 | line 208px -->
                <div class="relative text-center mt-20">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">EXCELLENCE</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">AICTE</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">APPROVED</p>
                    <div class="rising-wrap mt-2 x-2ky8hwwh">
                        <div class="rising-line rd-2"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>


                

                <!-- Col 3 - NAAC A++ | mt-6 | line 264px -->
                <div class="relative text-center mt-6">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">QS I-Gauge</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">PLATINUM</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">Rank</p>
                    <div class="rising-wrap mt-2 x-111fint9">
                        <div class="rising-line rd-3"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>


                <!-- Col 4 - NIRF 9TH | mt-16 | line 224px -->
                <div class="relative text-center mt-16">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">NAAC</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">A++</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">Accredited</p>
                    <div class="rising-wrap mt-2 x-21dxtybe">
                        <div class="rising-line rd-4"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>

            

                <!-- Col 5 - NIRF TOP 50 | mt-2 | line 280px -->
                <div class="relative text-center mt-2">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">NIRF Ranking</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">9TH</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">Year in a Row</p>
                    <div class="rising-wrap mt-2 x-27a8b9uf">
                        <div class="rising-line rd-5"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>


                <!-- Col 6 - Global Network 100+ | mt-24 | line 192px -->
                <div class="relative text-center mt-24">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">NIRF Innovation</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">TOP 50</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">In India</p>
                    <div class="rising-wrap mt-2 x-1p4nzbyr">
                        <div class="rising-line rd-6"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>


                 

                <!-- Col 7 - Global Reach 1000+ | mt-10 | line 248px -->
                <div class="relative text-center mt-10">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">Global Network</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">100+</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-tight">Global Partners</p>
                    <div class="rising-wrap mt-2 x-1e11mqo4">
                        <div class="rising-line rd-7"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>

                <!-- Col 8 - Indias FIRST | mt-28 | line 176px -->
                <div class="relative text-center mt-28">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">India's</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">FIRST</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-tight">Industry<br>Integrated<br>Institute</p>
                    <div class="rising-wrap mt-2 x-1e11mqo4">
                        <div class="rising-line rd-8"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>

                <!-- Col 9 - In-Campus ATAL | mt-14 | line 232px -->
                <div class="relative text-center mt-0">
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-none">In-Campus</p>
                    <p class="text-lg lg:text-2xl xl:text-3xl font-black text-white leading-tight x-3pl9lpzx">ATAL</p>
                    <p class="uppercase text-gray-300 text-[9px] lg:text-[11px] font-bold tracking-wide leading-tight">Incubation<br>Centre</p>
                    <div class="rising-wrap mt-2 x-16vhphxi">
                        <div class="rising-line rd-9"></div>
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-3 h-3 rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12),0_0_0_14px_rgba(255,255,255,0.07),0_0_36px_12px_rgba(255,255,255,0.55)] animate-pulse"></span>
                    </div>
                </div>

            </div>
            <!-- ===================== END DESKTOP STATS ===================== -->

        </div>
        <!-- -- END RIGHT STATS -- -->

    </div>
    <!-- ===== END MAIN CONTENT ===== -->

</section>

<script>
    const badge = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 15a7 7 0 1 0 0-14 7 7 0 0 0 0 14z"></path><path d="M8.21 13.89 7 23l5-3 5 3-1.21-9.12"></path></svg>`;
    document.querySelectorAll('.badge').forEach(el => el.innerHTML = badge);

    const lightning = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"></path></svg>`;
    document.querySelectorAll('.lightning').forEach(el => el.innerHTML = lightning);

    const PaperRocket = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.9)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13"></path><path d="M22 2L15 22 11 13 2 9l20-7z"></path></svg>`;
    document.querySelectorAll('.PaperRocket').forEach(el => el.innerHTML = PaperRocket);
</script>


