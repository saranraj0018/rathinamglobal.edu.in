{{-- Deferred GA4 + Meta Pixel: started on first interaction or idle (3.5s cap). --}}
@php($ga4Id = config('rgu.analytics.ga4_id'))
@php($pixelId = config('rgu.analytics.meta_pixel_id'))
<script>
(function () {
  var started = false;

  function startAnalytics() {
    if (started) return;
    started = true;

    /* Google Analytics 4 */
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', @js($ga4Id));

    var g = document.createElement('script');
    g.async = true;
    g.src = 'https://www.googletagmanager.com/gtag/js?id=' + @js($ga4Id);
    document.head.appendChild(g);

    /* Meta Pixel */
    !function (f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function () {
        n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
      };
      if (!f._fbq) f._fbq = n;
      n.push = n; n.loaded = !0; n.version = '2.0'; n.queue = [];
      t = b.createElement(e); t.async = !0; t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s);
    }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

    window.fbq('init', @js($pixelId));
    window.fbq('track', 'PageView');
  }

  var events = ['pointerdown', 'keydown', 'touchstart', 'wheel', 'scroll'];
  events.forEach(function (evt) {
    window.addEventListener(evt, startAnalytics, { passive: true, once: true });
  });

  if ('requestIdleCallback' in window) {
    requestIdleCallback(startAnalytics, { timeout: 3500 });
  } else {
    setTimeout(startAnalytics, 3000);
  }
})();
</script>
