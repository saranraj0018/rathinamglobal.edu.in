(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var $  = function (sel, ctx) { return (ctx || document).querySelector(sel); };
  var $$ = function (sel, ctx) { return Array.prototype.slice.call((ctx || document).querySelectorAll(sel)); };

  var navToggle = $('#navToggle');
  var navMenu   = $('#navMenu');

  function closeMenu() {
    if (!navMenu) return;
    navMenu.classList.remove('is-open');
    navToggle.setAttribute('aria-expanded', 'false');
    navToggle.setAttribute('aria-label', 'Open menu');
  }

  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function () {
      var open = navMenu.classList.toggle('is-open');
      navToggle.setAttribute('aria-expanded', String(open));
      navToggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    });

    $$('.nav-menu a').forEach(function (link) {
      link.addEventListener('click', closeMenu);
    });

    document.addEventListener('click', function (e) {
      if (!navMenu.contains(e.target) && !navToggle.contains(e.target)) closeMenu();
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth > 1240) closeMenu();
    });
  }

  var supportsSmooth = 'scrollBehavior' in document.documentElement.style;

  $$('a[href^="#"]').forEach(function (link) {
    link.addEventListener('click', function (e) {
      var id = link.getAttribute('href');
      if (!id || id === '#') return;

      var target = document.querySelector(id);
      if (!target) return;

      e.preventDefault();

      var header = $('.navbar');
      var offset = (header && window.getComputedStyle(header).position === 'sticky')
        ? header.offsetHeight + 14
        : 14;
      var top = target.getBoundingClientRect().top + window.pageYOffset - offset;

      if (supportsSmooth && !reduceMotion) {
        window.scrollTo({ top: top, behavior: 'smooth' });
      } else {
        window.scrollTo(0, top);
      }

      if (history.replaceState) history.replaceState(null, '', id);
    });
  });

  var progress = $('#scrollProgress');
  var navbar   = $('#navbar');
  var toTop    = $('#toTop');
  var ticking  = false;

  function onScroll() {
    var y      = window.pageYOffset;
    var height = document.documentElement.scrollHeight - window.innerHeight;
    var pct    = height > 0 ? (y / height) * 100 : 0;

    if (progress) progress.style.width = pct.toFixed(2) + '%';
    if (navbar)   navbar.classList.toggle('is-stuck', y > 12);
    if (toTop)    toTop.classList.toggle('is-visible', y > 600);

    ticking = false;
  }

  window.addEventListener('scroll', function () {
    if (!ticking) {
      window.requestAnimationFrame(onScroll);
      ticking = true;
    }
  }, { passive: true });
  onScroll();

  if (toTop) {
    toTop.addEventListener('click', function () {
      window.scrollTo(supportsSmooth && !reduceMotion ? { top: 0, behavior: 'smooth' } : 0, 0);
    });
  }

  var revealItems = $$('.reveal');

  if (reduceMotion || !('IntersectionObserver' in window)) {
    revealItems.forEach(function (el) { el.classList.add('is-visible'); });
  } else {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        // Reveal when in view, or when the element has already been scrolled past
        // (fast jumps via hash links must never leave content invisible).
        if (!entry.isIntersecting && entry.boundingClientRect.top >= 0) return;
        var siblings = Array.prototype.slice.call(entry.target.parentNode.children);
        var index = siblings.indexOf(entry.target);
        entry.target.style.transitionDelay = Math.min(index, 5) * 80 + 'ms';
        entry.target.classList.add('is-visible');
        revealObserver.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

    revealItems.forEach(function (el) { revealObserver.observe(el); });
  }

  function countUp(el) {
    var target = parseInt(el.getAttribute('data-count'), 10);
    var suffix = el.getAttribute('data-suffix') || '';
    if (isNaN(target)) return;

    if (reduceMotion) { el.textContent = target + suffix; return; }

    var duration = 1400;
    var start = null;

    function frame(now) {
      if (start === null) start = now;
      var p = Math.min((now - start) / duration, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(target * eased) + suffix;
      if (p < 1) window.requestAnimationFrame(frame);
    }

    el.textContent = '0' + suffix;
    window.requestAnimationFrame(frame);
  }

  var counters = $$('.num[data-count]');
  if (counters.length && 'IntersectionObserver' in window) {
    var countObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        countUp(entry.target);
        countObserver.unobserve(entry.target);
      });
    }, { threshold: 0.6 });

    counters.forEach(function (el) { countObserver.observe(el); });
  }

  var journey = $('#journeySteps');
  if (journey) {
    if (!('IntersectionObserver' in window)) {
      journey.classList.add('is-drawn');
    } else {
      var journeyObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting && entry.boundingClientRect.top >= 0) return;
          entry.target.classList.add('is-drawn');
          journeyObserver.unobserve(entry.target);
        });
      }, { threshold: 0.25 });
      journeyObserver.observe(journey);
    }
  }

  var navLinks = $$('.nav-link');
  var sections = navLinks
    .map(function (link) { return document.querySelector(link.getAttribute('href')); })
    .filter(Boolean);

  if (sections.length && 'IntersectionObserver' in window) {
    var sectionObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        navLinks.forEach(function (link) {
          link.classList.toggle('is-active', link.getAttribute('href') === '#' + entry.target.id);
        });
      });
    }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });

    sections.forEach(function (section) { sectionObserver.observe(section); });
  }

  var lightbox      = $('#lightbox');
  var lightboxImg   = $('#lightboxImg');
  var lightboxClose = $('#lightboxClose');
  var lastFocused   = null;

  function openLightbox(img) {
    if (!lightbox) return;
    lastFocused = document.activeElement;
    lightboxImg.src = img.currentSrc || img.src;
    lightboxImg.alt = img.alt || '';
    lightbox.hidden = false;
    document.body.classList.add('is-locked');
    lightboxClose.focus();
  }

  function closeLightbox() {
    if (!lightbox || lightbox.hidden) return;
    lightbox.hidden = true;
    lightboxImg.removeAttribute('src');
    document.body.classList.remove('is-locked');
    if (lastFocused) lastFocused.focus();
  }

  $$('img[data-zoom]').forEach(function (img) {
    img.addEventListener('click', function () { openLightbox(img); });
  });

  if (lightbox) {
    lightbox.addEventListener('click', function (e) {
      if (e.target === lightbox) closeLightbox();
    });
    lightboxClose.addEventListener('click', closeLightbox);
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeLightbox(); closeMenu(); }
  });

  var form   = $('#enquiryForm');
  var status = $('#formStatus');

  function setError(input, message) {
    var field = input.closest('.field');
    if (!field) return;
    field.classList.add('has-error');
    var err = $('.err', field);
    if (!err) {
      err = document.createElement('span');
      err.className = 'err';
      field.appendChild(err);
    }
    err.textContent = message;
  }

  function clearError(input) {
    var field = input.closest('.field');
    if (field) field.classList.remove('has-error');
  }

  if (form) {
    $$('input, select, textarea', form).forEach(function (input) {
      input.addEventListener('input', function () { clearError(input); });
    });

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var name  = $('#name');
      var phone = $('#phone');
      var email = $('#email');
      var valid = true;

      if (!name.value.trim()) { setError(name, 'Please enter the student name.'); valid = false; }

      var digits = phone.value.replace(/\D/g, '');
      if (digits.length < 10) { setError(phone, 'Please enter a valid mobile number.'); valid = false; }

      if (email.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        setError(email, 'Please enter a valid email address.');
        valid = false;
      }

      if (!valid) {
        var firstError = $('.field.has-error input', form);
        if (firstError) firstError.focus();
        if (status) status.classList.remove('is-visible');
        return;
      }

      if (status) {
        status.textContent = 'Thank you! Your enquiry has been recorded for the admissions team.';
        status.classList.add('is-visible');
      }
      form.reset();
      $$('.field.has-error', form).forEach(function (field) { field.classList.remove('has-error'); });
    });
  }
})();
