{{-- The photo set is rendered twice so the -50% marquee animation loops without a gap. --}}
<section class="py-16 bg-[#080810] border-y border-white/10 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8 text-center">
        <h2 class="font-['Sora',sans-serif] text-xl sm:text-2xl font-extrabold text-white">
            Global Immersion &amp; MoU Signings
        </h2>
    </div>
    <div class="flex overflow-hidden">
        <div class="animate-marquee gap-6 px-4">
            @foreach ([...$gallery, ...$gallery] as $photo)
                <div class="w-80 h-52 rounded-2xl border border-white/15 overflow-hidden shrink-0 shadow-2xl transition duration-300 hover:scale-105" @if ($loop->index >= count($gallery)) aria-hidden="true" @endif>
                    <img src="{{ storage_asset($photo) }}" alt="Global immersion event {{ $loop->index % count($gallery) + 1 }}" loading="lazy" decoding="async" class="w-full h-full object-cover">
                </div>
            @endforeach
        </div>
    </div>
</section>
