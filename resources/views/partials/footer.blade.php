<!-- ENQUIRE NOW — Fixed Right Tab (tablet + desktop only) -->
<div id="enquire-side-tab" class="x-ht6wtrac">
  <button onclick="openEnquiryModal()"
    onmouseover="this.style.boxShadow='-4px 0 32px rgba(220,38,38,0.65)';this.style.paddingLeft='14px';"
    onmouseout="this.style.boxShadow='-4px 0 24px rgba(220,38,38,0.45)';this.style.paddingLeft='11px';" class="x-22culamq">
    Enquire Now
  </button>
</div>

<!-- ENQUIRE NOW — Floating Bottom Button (mobile only) -->
<button id="enquire-mobile-btn" onclick="openEnquiryModal()" class="x-22q3z34u">
  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
  </svg>
  Enquire Now
</button>

<!-- ENQUIRY MODAL -->
<div id="enquiry-modal"
  onclick="if(event.target===this)closeEnquiryModal()" class="x-3dzycby9">

  <div class="x-2m3fi0t3">

    <!-- Modal Header -->
    <div class="x-j3om5xs7">
      <div>
        <p class="x-20k70nna">Rathinam Global University</p>
        <h3 class="x-cnzxyrlb">Enquire Now</h3>
      </div>
      <button onclick="closeEnquiryModal()" class="x-1w5owrgf">&times;</button>
    </div>

    <!-- NoPaperForms Widget Injection -->
    <div class="x-2knjytrs">
      <div class="npf_wgts x-17n4txue" data-w="03dcaa376b356afbd9099493e858e7e6"></div>
    </div>

  </div>
</div>

<style>
  /* ── Enquire Now: side tab on tablet+, floating pill on mobile ── */
  #enquire-side-tab   { display: block; }
  #enquire-mobile-btn { display: none;  }

  @media (max-width: 639px) {
    #enquire-side-tab              { display: none !important; }
    #enquire-mobile-btn            { display: flex !important; }
  }

  /* Enquiry modal responsive sizing */
  #enquiry-modal > div {
    min-height: min(600px, 85vh);
    max-height: 92vh;
  }
  @media (max-width: 480px) {
    #enquiry-modal > div {
      margin: 0 !important;
      border-radius: 20px 20px 0 0 !important;
      min-height: 78vh !important;
      max-height: 92vh !important;
      width: 100% !important;
      max-width: 100% !important;
    }
    #enquiry-modal {
      align-items: flex-end !important;
    }
  }

  /* ── Break NPF's internal fixed-height scroll container ── */
  #enquiry-modal .npf_wgts,
  #enquiry-modal .npf_wgts > div,
  #enquiry-modal .npf_wgts > div > div,
  #enquiry-modal .npf_wgts > div > div > div {
    width: 100% !important;
    max-height: none !important;
    height: auto !important;
    overflow: visible !important;
    min-height: 0 !important;
  }
  /* If NPF uses an iframe, force it tall */
  #enquiry-modal .npf_wgts iframe {
    width: 100% !important;
    min-height: 520px !important;
    height: 520px !important;
    border: none !important;
    display: block !important;
  }
</style>
<script>
  /* ── Force-expand any NPF internal scrollable box ── */
  function fixNPFHeight() {
    var wgt = document.querySelector('#enquiry-modal .npf_wgts');
    if (!wgt) return;

    /* 1. Expand overflow-locked descendants */
    wgt.querySelectorAll('*').forEach(function(el) {
      var cs = window.getComputedStyle(el);
      var ov = cs.overflow + cs.overflowY;
      if ((ov.indexOf('auto') !== -1 || ov.indexOf('hidden') !== -1) &&
           el.scrollHeight > el.clientHeight + 4) {
        el.style.setProperty('height',     el.scrollHeight + 32 + 'px', 'important');
        el.style.setProperty('max-height', 'none',                       'important');
        el.style.setProperty('overflow',   'visible',                    'important');
      }
    });

    /* 2. If NPF injected an iframe, auto-size it */
    wgt.querySelectorAll('iframe').forEach(function(f) {
      f.style.setProperty('width',      '100%',   'important');
      f.style.setProperty('min-height', '520px',  'important');
      f.style.setProperty('height',     '520px',  'important');
      f.style.setProperty('border',     'none',   'important');
      /* try same-origin read */
      f.addEventListener('load', function() {
        try {
          var h = f.contentDocument.documentElement.scrollHeight || 520;
          f.style.setProperty('height', h + 'px', 'important');
        } catch(e) {}
      }, { once: true });
    });
  }

  /* Watch for NPF to inject anything into the widget div */
  (function() {
    var wgt = document.querySelector('#enquiry-modal .npf_wgts');
    if (!wgt) return;
    new MutationObserver(function() { setTimeout(fixNPFHeight, 80); })
        .observe(wgt, { childList: true, subtree: true, attributes: true });
  })();

  var __npfLoaded = false;
  function loadNPF() {
    if (__npfLoaded) return;
    __npfLoaded = true;
    var s = document.createElement('script');
    s.src = 'https://widgets.nopaperforms.com/emwgts.js';
    s.async = true;
    document.body.appendChild(s);
  }

  function openEnquiryModal() {
    document.getElementById('enquiry-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    loadNPF();
    /* Run fixNPFHeight at staggered intervals to catch lazy-rendered content */
    [100, 400, 900, 1800, 3000].forEach(function(ms) {
      setTimeout(fixNPFHeight, ms);
    });
  }

  function closeEnquiryModal() {
    document.getElementById('enquiry-modal').style.display = 'none';
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEnquiryModal();
  });
</script>

<!-- BACK TO TOP — floats above the WhatsApp button on every page -->
<button id="back-to-top-btn" type="button" aria-label="Back to top"
  
   onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 12px 32px rgba(126,34,206,0.65)';"
   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 24px rgba(126,34,206,0.45)';"
   onclick="window.scrollTo({top:0,behavior:'smooth'});" class="x-1cogzvtp">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="19" x2="12" y2="5"></line>
        <polyline points="5 12 12 5 19 12"></polyline>
    </svg>
</button>
<script>
(function(){
    var btn = document.getElementById('back-to-top-btn');
    if (!btn) return;
    function toggle(){
        var show = window.scrollY > 320;
        btn.style.display = show ? 'flex' : 'none';
        // double-RAF so the transition fires after display switches
        if (show) requestAnimationFrame(function(){
            requestAnimationFrame(function(){ btn.style.opacity = '1'; btn.style.transform = 'translateY(0)'; });
        });
        else { btn.style.opacity = '0'; btn.style.transform = 'translateY(8px)'; }
    }
    window.addEventListener('scroll', toggle, { passive:true });
    toggle();
})();
</script>

<!-- Mobile spacing: keep BTT clear of the bottom Enquire-Now pill -->
<style>
@media (max-width: 639px){
    #back-to-top-btn{ bottom: 96px !important; right: 28px !important; width: 56px !important; height: 56px !important; }
}
</style>

<!-- WhatsApp Floating Button -->
<a href="https://api.whatsapp.com/send?phone=918448448909&text=Hi%2C+I+would+like+to+connect+with+you"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Chat on WhatsApp"
  
   onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 6px 32px rgba(37,211,102,0.6)';"
   onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 24px rgba(37,211,102,0.45)';" class="x-m2u01i0a">
    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="white">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>

<!-- CTA Section -->
<section class="bg-[#080810] py-12 md:py-16">
  <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 text-center">
    
    <div class="relative overflow-hidden rounded-3xl border border-purple-500/20 bg-gradient-to-br from-purple-500/10 to-sky-400/10 px-6 py-10 sm:px-10 sm:py-14">
      
      <!-- Top Gradient Line -->
      <div class="absolute inset-x-0 top-0 h-[2px] bg-gradient-to-r from-transparent via-purple-500 via-sky-400 to-transparent"></div>

      <h2 class="font-sora text-3xl sm:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-slate-50">
        Ready to Begin Your Journey?
      </h2>

      <p class="mx-auto mt-5 max-w-2xl font-dm text-sm sm:text-base leading-7 text-white/75">
        Applications for the 2026–27 academic year are open. Secure your place at RGU before seats fill up.
      </p>

      <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
        
        <!-- Apply Button -->
        <a
          href="https://admissions.rathinamcollege.edu.in/"
          class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-lime-400 to-emerald-400 px-7 py-3 text-sm font-extrabold text-[#0a0a14] shadow-[0_8px_32px_rgba(163,230,53,0.35)] transition duration-300 hover:scale-105"
        >
          Apply Online Now →
        </a>

        <!-- Call Button -->
        <a
          href="tel:8448448909"
          class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/20 bg-transparent px-6 py-3 text-sm font-bold text-white/80 transition duration-300 hover:border-white/40 hover:bg-white/5"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.62 2 2 0 0 1 3.6 1.44h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.83-1.83a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
          </svg>

          Call Admissions
        </a>

        <!-- Download Brochure Button -->
        <a
          href="{{ storage_asset('assets/brouchure.pdf') }}"
          target="_blank"
          rel="noopener noreferrer"
          class="inline-flex items-center justify-center gap-2 rounded-xl border border-purple-500/40 bg-purple-500/10 px-6 py-3 text-sm font-bold text-purple-300 transition duration-300 hover:border-purple-400/60 hover:bg-purple-500/20 hover:text-purple-200"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
            <polyline points="7 10 12 15 17 10"/>
            <line x1="12" y1="15" x2="12" y2="3"/>
          </svg>
          Download Brochure
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer id="contact" class="border-t border-white/5 bg-[#050508]">
  
  <!-- Top Color Bar -->
  <div class="flex h-[3px]">
    <div class="flex-1 bg-purple-500"></div>
    <div class="flex-1 bg-sky-400"></div>
    <div class="flex-1 bg-lime-400"></div>
    <div class="flex-1 bg-pink-400"></div>
    <div class="flex-1 bg-orange-400"></div>
  </div>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-14">
    
    <!-- Grid -->
    <div class="grid gap-12 pb-12 
      grid-cols-1 
      sm:grid-cols-2 
      lg:grid-cols-[280px_1fr_1fr_260px]">

      <!-- Brand -->
      <div>
        <div class="mb-5 inline-flex items-center rounded-xl bg-white/95 px-4 py-2 shadow-lg">
          <img
            src="{{ storage_asset('assets/images/logo-360.webp') }}"
            alt="Rathinam Global University"
            width="140" height="36" loading="lazy" decoding="async"
            class="h-9 w-auto object-contain"
          />
        </div>

        <p class="mb-6 text-sm leading-7 text-white/70">
          Rathinam Global University — a leading deemed university in Coimbatore shaping future-ready graduates.
        </p>

        <!-- Social -->
        <div class="mb-6 flex flex-wrap gap-2">

          <!-- X / Twitter -->
          <a href="https://x.com/rathinamgroups" target="_blank" rel="noopener noreferrer" aria-label="X" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/70 transition hover:bg-white/10 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.738l7.738-8.835L1.254 2.25H8.08l4.261 5.636L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </a>

          <!-- LinkedIn -->
          <a href="https://www.linkedin.com/company/rathinam-global/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/70 transition hover:bg-white/10 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
          </a>

          <!-- Facebook -->
          <a href="https://www.facebook.com/rathinamglobal/" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/70 transition hover:bg-white/10 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
          </a>

          <!-- YouTube -->
          <a href="https://www.youtube.com/user/RathinamCollege" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/70 transition hover:bg-white/10 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
          </a>

          <!-- Instagram -->
          <a href="https://www.instagram.com/rathinam_global/" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/70 transition hover:bg-white/10 hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/>
            </svg>
          </a>

        </div>

        <!-- Tags -->
        <div class="flex flex-wrap gap-2">
          <span class="rounded-md border border-lime-400/20 bg-lime-400/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-lime-300">
            NAAC A++
          </span>

          <span class="rounded-md border border-lime-400/20 bg-lime-400/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-lime-300">
            NBA
          </span>

          <span class="rounded-md border border-lime-400/20 bg-lime-400/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-lime-300">
            UGC
          </span>

          <span class="rounded-md border border-lime-400/20 bg-lime-400/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-lime-300">
            AICTE
          </span>

          <span class="rounded-md border border-lime-400/20 bg-lime-400/10 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-lime-300">
            QS
          </span>
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h5 class="mb-5 text-xs font-extrabold uppercase tracking-[0.2em] text-white/75">
          Quick Links
        </h5>

        <ul class="space-y-3">
          <li><a href="{{ $homeUrl }}#about" class="text-sm text-white/70 transition hover:text-white">About RGU</a></li>
          <li><a href="{{ $homeUrl }}#inspiring-direction" class="text-sm text-white/70 transition hover:text-white">Leadership</a></li>
          <li><a href="{{ route('research.index') }}" class="text-sm text-white/70 transition hover:text-white">Research</a></li>
          <li><a href="{{ $homeUrl }}#spotlight" class="text-sm text-white/70 transition hover:text-white">Placements</a></li>
          <li><a href="{{ $homeUrl }}#life-at-rgu" class="text-sm text-white/70 transition hover:text-white">Alumni</a></li>
          <li><a href="{{ route('careers') }}" class="text-sm text-white/70 transition hover:text-white">Careers</a></li>
          <li><a href="{{ route('dbt-star-scheme') }}" class="text-sm text-white/70 transition hover:text-white">DBT Star College Scheme</a></li>
          <li><a href="{{ route('faq') }}" class="text-sm text-white/70 transition hover:text-white">FAQs</a></li>
          <li><a href="{{ $homeUrl }}#contact" class="text-sm text-white/70 transition hover:text-white">Contact</a></li>
          <li><a href="https://rathinamglobal.edu.in/fab/" rel="noopener" class="text-sm text-white/70 transition hover:text-white">RGU Summer Camp - 2026</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div>
        <h5 class="mb-5 text-xs font-extrabold uppercase tracking-[0.2em] text-white/75">
          Contact
        </h5>

        <div class="space-y-5">
          <div class="flex items-start gap-3">
            <span class="text-white/70">📍</span>

            <p class="text-sm leading-6 text-white/70">
              Eachanari, Coimbatore <br />
              Tamil Nadu – 641021
            </p>
          </div>

          <div class="flex items-start gap-3">
            <span class="text-white/70">📞</span>

            <p class="text-sm leading-6 text-white/70">
              +91-844-844-8909
            </p>
          </div>
        </div>
      </div>

      <!-- Extra -->
      <div>
        <h5 class="mb-5 text-xs font-extrabold uppercase tracking-[0.2em] text-white/75">
          Admissions
        </h5>

        <p class="mb-5 text-sm leading-7 text-white/70">
          Admissions are now open for Undergraduate, Postgraduate and Research programs.
        </p>

        <a
          href="{{ $homeUrl }}#courses"
          class="inline-flex items-center rounded-xl bg-white/10 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/20"
        >
          Explore Programs
        </a>
      </div>
    </div>

    <!-- Bottom -->
    <div class="flex flex-col gap-4 border-t border-white/5 py-6 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">
      
      <p class="text-xs leading-6 text-white/60">
        © 2026 Rathinam Global University. All rights reserved.
      </p>

      
    </div>
  </div>
  
<div id="site-popup-overlay" onclick="if(event.target===this)closeSitePopup()" class="x-9ab1popup">
  <div class="x-9ab1popup-inner">
    <button onclick="closeSitePopup()" aria-label="Close" class="x-9ab1popup-close">&times;</button>
    <img src="{{ storage_asset('assets/images/pop-up.jpeg') }}" alt="Rathinam Global University" class="x-9ab1popup-img">
  </div>
</div>

<style>
  #site-popup-overlay{
    display:none; position:fixed; inset:0; z-index:9999;
    align-items:center; justify-content:center;
    background:rgba(5,5,8,0.82);
    padding:20px;
  }
  #site-popup-overlay.is-open{ display:flex; }
  .x-9ab1popup-inner{
    position:relative;
    max-width:min(92vw, 420px);
    max-height:90vh;
    animation:x9ab1popupIn .25s ease-out;
  }
  .x-9ab1popup-img{
    display:block;
    width:100%;
    height:auto;
    max-height:90vh;
    object-fit:contain;
    border-radius:16px;
    box-shadow:0 20px 60px rgba(0,0,0,0.5);
  }
  .x-9ab1popup-close{
    position:absolute; top:-14px; right:-14px;
    width:34px; height:34px; border-radius:999px;
    background:#fff; color:#0f0f14; border:none;
    font-size:22px; line-height:1; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 4px 14px rgba(0,0,0,0.35);
  }
  @keyframes x9ab1popupIn{
    from{ opacity:0; transform:scale(.94); }
    to{ opacity:1; transform:scale(1); }
  }
</style>
<script>
  function closeSitePopup(){
    var ov = document.getElementById('site-popup-overlay');
    if (!ov) return;
    ov.classList.remove('is-open');
    document.body.style.overflow = '';
  }
  (function(){
    try{
      if (sessionStorage.getItem('rguSitePopupShown')) return;
    }catch(e){}
    var ov = document.getElementById('site-popup-overlay');
    if (!ov) return;
    window.addEventListener('DOMContentLoaded', function(){
      ov.classList.add('is-open');
      document.body.style.overflow = 'hidden';
      try{ sessionStorage.setItem('rguSitePopupShown', '1'); }catch(e){}
    });
  })();
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeSitePopup();
  });
</script>
</footer> 