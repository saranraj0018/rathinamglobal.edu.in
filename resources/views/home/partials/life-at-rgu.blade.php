<section class="py-20 my-10 md:my-14 x-22pk1x8q">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 2xl:px-16">
        <div class="grid grid-cols-12 gap-3">
            <div class="col-span-12 md:col-span-6 space-y-3">
                <div class="flex mx-auto md:mx-0 gap-2 text-[#a3e635] uppercase text-xs font-medium tracking-[0.25em] p-3 rounded-full bg-[#141913] backdrop-blur-md w-max mb-5 border border-[#ffffff14]">
                    <span class="my-auto x-2h0sly1n"></span>
                    <span>Beyond the Classroom</span>
                </div>
                <h2 class="text-center md:text-start x-1cusl7mr">Student Life at <span class="x-nhq1t8ja">Rathinam Global <br>University</span></h2>
                <p class="text-sm md:text-lg text-gray-500 font-normal text-center md:text-start">
                    University is more than a degree. It's where you discover yourself, build friendships, and develop lifelong skills.
                </p>
            </div>
            <div class="col-span-12 md:col-span-6 space-y-3">
                <div class="x-hddjz0jh">
                    <div class="x-1gozn8pu"><span class="x-2i4zc8sg">Students</span><span class="x-1w22slon">25,000+</span></div>
                    <div class="x-1gozn8pu"><span class="x-2i4zc8sg">Acre Campus</span><span class="x-1w22slon">300</span></div>
                    <div class="x-1gozn8pu"><span class="x-2i4zc8sg">Student Clubs</span><span class="x-1w22slon">40+</span></div>
                    <div class="x-2aytgs17"><span class="x-2i4zc8sg">Satisfaction</span><span class="x-1w22slon">98%</span></div>
                </div>
            </div>
        </div>
    </div>
    {{-- Each row renders twice for a seamless marquee loop (transform 0 → -50%).
         The copy is aria-hidden but keeps real alt text for crawlers. --}}
    <section class="gallery-section" aria-label="Life at RGU gallery">
        @foreach ($galleryRows as $rowIndex => $row)
        <div class="marquee {{ $rowIndex === 0 ? 'marquee-left' : 'marquee-right' }}">
            <div class="marquee-track">
                @foreach ([false, true] as $isLoopCopy)
                    @foreach ($row as [$id, $shape, $alt])
                        <div class="gallery-card {{ $shape }}"@if ($isLoopCopy) aria-hidden="true"@endif><img src="{{ storage_asset('assets/images/life/'.$id.'.webp') }}" alt="{{ $alt }}" width="{{ $galleryDimensions[$shape]['w'] }}" height="{{ $galleryDimensions[$shape]['h'] }}" loading="lazy" decoding="async"></div>
                    @endforeach
                @endforeach
            </div>
        </div>
        @endforeach
    </section>

    <style>
        .gallery-section { background:#020312; overflow:hidden; padding:40px 0; }
        .marquee { overflow:hidden; width:100%; margin-bottom:22px; }
        .marquee-track { display:flex; gap:20px; width:max-content; will-change:transform; }
        .marquee-left .marquee-track  { animation: scrollLeft  45s linear infinite; }
        .marquee-right .marquee-track { animation: scrollRight 45s linear infinite; }
        .gallery-card { flex-shrink:0; overflow:hidden; border-radius:24px; background:#111827; }
        .gallery-card img { width:100%; height:100%; object-fit:cover; display:block; }
        .gallery-card.wide   { width:380px; height:210px; }
        .gallery-card.square { width:260px; height:210px; }
        .gallery-card.tall   { width:190px; height:210px; }
        @keyframes scrollLeft  { from { transform: translateX(0); }     to { transform: translateX(-50%); } }
        @keyframes scrollRight { from { transform: translateX(-50%); } to { transform: translateX(0); } }
        @media (max-width: 768px) {
            .gallery-card.wide   { width:260px; height:160px; }
            .gallery-card.square { width:180px; height:160px; }
            .gallery-card.tall   { width:140px; height:160px; }
            .marquee-track { gap:14px; }
        }
        /* Honor reduced-motion: don't burn CPU on infinite animation. */
        @media (prefers-reduced-motion: reduce) {
            .marquee-left .marquee-track,
            .marquee-right .marquee-track { animation: none; }
        }
    </style>
</section>
