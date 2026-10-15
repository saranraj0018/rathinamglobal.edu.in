<section class="my-12 container mx-auto px-4 sm:px-6 lg:px-8">
  <div class="x-mtv7ng87">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="x-1w32usjh">
      <path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58A2.78 2.78 0 0 0 3.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"></path>
      <path d="M9.75 15.02l5.75-3.02-5.75-3.02v6.04z"></path>
    </svg>Rathinam TV
  </div>

  <!-- Swiper CSS+JS are loaded once globally from index.php. -->

  {{-- YouTube videos render as click-to-load facades; the iframe loads only after a click. --}}
  <div class="relative w-full overflow-hidden">
    <div class="swiper rathinamTvSlider w-full">
      <div class="swiper-wrapper">
        @foreach ($tvVideos as $vid)
        <div class="swiper-slide m-2">
          <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-xl">
            <button type="button"
                    class="lite-yt absolute inset-0 w-full h-full flex items-center justify-center cursor-pointer border-0 p-0 x-b1618h5k"
                    data-ytid="{{ $vid }}"
                    aria-label="Play YouTube video"
                   >
              <img src="https://i.ytimg.com/vi/{{ $vid }}/hqdefault.jpg"
                   alt="Rathinam TV video"
                   width="480" height="360" loading="lazy" decoding="async"
                   class="w-full h-full object-cover">
              <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                <svg width="68" height="48" viewBox="0 0 68 48" xmlns="http://www.w3.org/2000/svg">
                  <path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="#f00"/>
                  <path d="M45 24L27 14v20" fill="#fff"/>
                </svg>
              </span>
            </button>
          </div>
        </div>
        @endforeach      </div>

      <div class="swiper-pagination mt-6"></div>
    </div>
  </div>

  <script>
    // Click-to-load YouTube facade: only when the user clicks Play do we inject the iframe.
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.lite-yt');
      if (!btn) return;
      var id = btn.dataset.ytid;
      var iframe = document.createElement('iframe');
      iframe.setAttribute('frameborder', '0');
      iframe.setAttribute('allow', 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture');
      iframe.setAttribute('allowfullscreen', '');
      iframe.setAttribute('title', 'YouTube video player');
      iframe.style.cssText = 'position:absolute;inset:0;width:100%;height:100%;border:0;';
      iframe.src = 'https://www.youtube-nocookie.com/embed/' + id + '?autoplay=1&rel=0&modestbranding=1';
      btn.replaceWith(iframe);
    });

    // Init Swiper after the global bundle (loaded with defer) is ready.
    document.addEventListener('DOMContentLoaded', function () {
      if (typeof Swiper === 'undefined') return;
      new Swiper('.rathinamTvSlider', {
        slidesPerView: 3, loop: true,
        autoplay: { delay: 4000, disableOnInteraction: false },
        pagination: { el: '.rathinamTvSlider .swiper-pagination', clickable: true },
        speed: 900,
        breakpoints: { 0: { slidesPerView: 1 }, 768: { slidesPerView: 3 } },
      });
    });
  </script>

  <style>
    .swiper-pagination { display: flex; justify-content: center; gap: 8px; }
    .swiper-pagination-bullet {
      width: 8px; height: 8px; background: #cbd5e1; opacity: 0.7;
      border-radius: 999px; transition: all 0.3s ease;
    }
    .swiper-pagination-bullet-active {
      width: 28px;
      background: linear-gradient(to right, #a855f7, #38bdf8);
      opacity: 1;
    }
  </style>
</section>
