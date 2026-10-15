@extends('layouts.base')

@section('title', 'Best University in Tamil Nadu | Rathinam Global University')
@section('description', 'Rathinam Global University (RGU): NAAC A++ accredited in Tamil Nadu. Industry-focused programs, innovation, excellence and global opportunities for students.')

@push('head')
    <meta name="theme-color" content="#050508">
    <meta name="google-site-verification" content="RMXPW9hR4uofEp4FIp4QOaQMtyqJJYN2ESvtlyt2VJY" />
    <meta name="robots" content="index,follow">
    <meta property="og:title" content="Best University in Tamil Nadu | Rathinam Global University">
    <meta property="og:description" content="Rathinam Global University (RGU): NAAC A++ accredited in Tamil Nadu. Industry-focused programs, innovation, excellence and global opportunities for students.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ storage_asset('assets/images/logo.webp') }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Best University in Tamil Nadu | Rathinam Global University">
    <meta name="twitter:description" content="Rathinam Global University (RGU): NAAC A++ accredited in Tamil Nadu. Industry-focused programs, innovation, excellence and global opportunities for students.">
    <meta name="twitter:image" content="{{ storage_asset('assets/images/logo-360.webp') }}">
    <link rel="icon" type="image/png" href="{{ storage_asset('assets/images/favicon.png') }}">
    <style>
      body{margin:0!important;padding:0!important;background:#fff;color:#1e293b;font-family:'Outfit',system-ui,-apple-system,Segoe UI,Roboto,sans-serif}
      .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
    </style>

    <!-- Preconnect / preload critical origins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://i.ytimg.com" crossorigin>

    <link rel="preload" as="image"
          imagesrcset="{{ storage_asset('assets/images/earth-half-mobileview-480.webp') }} 1x, {{ storage_asset('assets/images/earth-half-mobileview-800.webp') }} 2x"
          type="image/webp" media="(max-width: 767px)" fetchpriority="high">
    <link rel="preload" as="image"
          imagesrcset="{{ storage_asset('assets/images/earth-half-1200.webp') }} 1x, {{ storage_asset('assets/images/earth-half-1920.webp') }} 1.6x"
          type="image/webp" media="(min-width: 768px)" fetchpriority="high">

    <!-- Fonts: load async to avoid render-block -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&display=swap"></noscript>

    <style>{!! $criticalCss !!}</style>
    <link rel="preload" href="{{ storage_asset('assets/css/home.bundle.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="{{ storage_asset('assets/css/home.bundle.css') }}"></noscript>


    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"></noscript>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <!-- Analytics are loaded lazily; see the deferred loader before </body>. -->


         
<!-- Organization / Local Business structured data. -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "CollegeOrUniversity",
      "@id": "https://rathinamglobal.edu.in/#university",
      "name": "Rathinam Global Deemed to be University",
      "alternateName": "Rathinam Global University",
      "description": "Rathinam Global University (RGU) is a NAAC A++ accredited deemed-to-be university in Coimbatore, Tamil Nadu, offering industry-focused undergraduate, postgraduate and research programs.",
      "url": "https://rathinamglobal.edu.in/",
      "logo": "https://rathinamglobal.edu.in/assets/images/logo-360.webp",
      "image": "https://rathinamglobal.edu.in/assets/images/logo-360.webp",
      "telephone": "+91-844-844-8909",
      "email": "admission@rathinam.in",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Pollachi Main Rd, Kpm Nagar, Eachanari",
        "addressLocality": "Coimbatore",
        "addressRegion": "Tamil Nadu",
        "postalCode": "641021",
        "addressCountry": "IN"
      },
      "sameAs": [
        "https://www.facebook.com/rathinamglobal/",
        "https://www.instagram.com/rathinam_global/",
        "https://www.youtube.com/@RathinamGlobal",
        "https://x.com/rathinamgroups",
        "https://www.linkedin.com/company/rathinam-global/"
      ]
    },
    {
      "@type": "LocalBusiness",
      "@id": "https://rathinamglobal.edu.in/#localbusiness",
      "name": "Rathinam Global Deemed to be University",
      "alternateName": "Rathinam Global University",
      "description": "Rathinam Global Deemed to be University in Coimbatore, Tamil Nadu.",
      "url": "https://rathinamglobal.edu.in/",
      "logo": "https://rathinamglobal.edu.in/assets/images/logo-360.webp",
      "image": "https://rathinamglobal.edu.in/assets/images/logo-360.webp",
      "telephone": "+91-844-844-8909",
      "email": "admission@rathinam.in",
      "priceRange": "$$",
      "currenciesAccepted": "INR",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Pollachi Main Rd, Kpm Nagar, Eachanari",
        "addressLocality": "Coimbatore",
        "addressRegion": "Tamil Nadu",
        "postalCode": "641021",
        "addressCountry": "IN"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 10.9315512,
        "longitude": 76.9815877
      },
      "hasMap": "https://www.google.com/maps/search/?api=1&query=10.9315512,76.9815877",
      "areaServed": {
        "@type": "Country",
        "name": "India"
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday"
          ],
          "opens": "09:00",
          "closes": "18:00"
        }
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-844-844-8909",
        "email": "admission@rathinam.in",
        "contactType": "admissions",
        "areaServed": "IN",
        "availableLanguage": [
          "English",
          "Tamil",
          "Malayalam"
        ]
      },
      "sameAs": [
        "https://www.facebook.com/rathinamglobal/",
        "https://www.instagram.com/rathinam_global/",
        "https://www.youtube.com/@RathinamGlobal",
        "https://x.com/rathinamgroups",
        "https://www.linkedin.com/company/rathinam-global/"
      ]
    }
  ]
}
</script>

  
  <!-- Meta Pixel Code -->
<noscript><img height="1" width="1" class="x-pixel-hidden" alt=""
src="https://www.facebook.com/tr?id={{ config('rgu.analytics.meta_pixel_id') }}&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->
 
@endpush

@section('body')
    <a href="#courses" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-[10001] focus:bg-white focus:text-black focus:px-3 focus:py-2 focus:rounded">Skip to main content</a>
    @include('home.partials.banner')
    @include('home.partials.home-hero')
    @include('home.partials.marquee')
    @include('home.partials.live-admission')
    @include('home.partials.courses')
    @include('home.partials.rgu-different')
    @include('home.partials.campus-events')
    @include('home.partials.rathinam-tv')
    @include('home.partials.life-at-rgu')
    @include('home.partials.ranking-excellence')
    @include('home.partials.spotlight')
    @include('home.partials.inspiring-direction')
    @include('home.partials.faq-preview')
    @include('partials.footer')

    <script src="{{ storage_asset('assets/js/script.js') }}" defer></script>

    @include('partials.analytics')
@endsection
