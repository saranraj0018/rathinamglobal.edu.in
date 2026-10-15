
(function () {
    'use strict';

    var CONFIG = {
        LEAD_ENDPOINT: (window.RGU_LEAD_CONFIG && window.RGU_LEAD_CONFIG.lead) || "lead.php",
        BROCHURE_ENDPOINT: (window.RGU_LEAD_CONFIG && window.RGU_LEAD_CONFIG.brochure) || "brochure.php",
        CSRF_TOKEN: (window.RGU_LEAD_CONFIG && window.RGU_LEAD_CONFIG.csrfToken) || "",

        BROCHURE_DELIVERY: "both",

        DEFAULT_PROGRAMME: "ESIA Course"
    };

    var Endpoints = {
        lead: CONFIG.LEAD_ENDPOINT,
        brochure: CONFIG.BROCHURE_ENDPOINT,

        adopt: function (finalUrl) {
            if (!finalUrl) { return; }

            var base = String(finalUrl).split('?')[0];
            if (!/\/lead(\.php)?$/.test(base)) { return; }

            this.lead = base;
            this.brochure = /\.php$/.test(base)
                ? CONFIG.BROCHURE_ENDPOINT
                : CONFIG.BROCHURE_ENDPOINT.replace(/\.php$/, '');
        },

        dropExtension: function () {
            if (!/\.php$/.test(this.lead)) { return false; }
            this.lead = this.lead.replace(/\.php$/, '');
            this.brochure = this.brochure.replace(/\.php$/, '');
            return true;
        }
    };

    var DESKTOP_QUERY = window.matchMedia('(min-width: 1024px)');


    /* TOASTS + SHARED HELPERS */
    function prefersReducedMotion() {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    }

    var notify = (function () {
        var host = null;
        var hideTimer = null;

        function ensureHost() {
            if (host) { return host; }

            host = document.createElement('div');
            host.className = 'toast';
            host.setAttribute('role', 'status');
            host.setAttribute('aria-live', 'polite');
            host.hidden = true;

            host.innerHTML =
                '<span class="toast__icon" aria-hidden="true"></span>' +
                '<span class="toast__text"></span>' +
                '<button class="toast__close" type="button" aria-label="Dismiss">&times;</button>';

            host.querySelector('.toast__close').addEventListener('click', hide);
            document.body.appendChild(host);
            return host;
        }

        function hide() {
            if (!host) { return; }
            window.clearTimeout(hideTimer);
            host.classList.remove('is-visible');
            hideTimer = window.setTimeout(function () { host.hidden = true; }, 260);
        }

        return function (message, tone) {
            var node = ensureHost();
            window.clearTimeout(hideTimer);

            node.className = 'toast toast--' + (tone || 'info');
            node.querySelector('.toast__text').textContent = message;
            node.hidden = false;

            /* Force a frame so the entry transition runs on repeat calls. */
            void node.offsetWidth;
            node.classList.add('is-visible');

            hideTimer = window.setTimeout(hide, tone === 'success' ? 7000 : 5000);
        };
    }());


    /* 1. MOBILE NAVIGATION */
    function initMobileNav() {
        var toggle = document.querySelector('.navbar__toggle');
        var drawer = document.getElementById('mobile-nav');
        var header = document.querySelector('.site-header');

        if (!toggle || !drawer) { return; }

        function setOpen(open) {
            drawer.hidden = !open;
            toggle.setAttribute('aria-expanded', String(open));
            toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        }

        toggle.addEventListener('click', function () {
            setOpen(drawer.hidden);
        });

        /* Close when a link inside the drawer is chosen */
        drawer.addEventListener('click', function (event) {
            if (event.target.closest('a')) { setOpen(false); }
        });

        /* Close when clicking outside the header */
        document.addEventListener('click', function (event) {
            if (drawer.hidden) { return; }
            if (!header.contains(event.target)) { setOpen(false); }
        });

        /* Close on Escape */
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !drawer.hidden) {
                setOpen(false);
                toggle.focus();
            }
        });

        /* Always close when moving up to the desktop layout */
        DESKTOP_QUERY.addEventListener('change', function (event) {
            if (event.matches) { setOpen(false); }
        });
    }


    function initAccordions() {
        var groups = document.querySelectorAll('[data-accordion]');

        Array.prototype.forEach.call(groups, function (group) {
            var triggers = group.querySelectorAll('[aria-controls]');

            function panelOf(trigger) {
                return document.getElementById(trigger.getAttribute('aria-controls'));
            }

            function expand(panel) {
                panel.hidden = false;
                panel.style.height = '0px';
                /* force reflow so the transition runs from 0 */
                void panel.offsetHeight;
                panel.style.height = panel.scrollHeight + 'px';

                panel.addEventListener('transitionend', function done(event) {
                    if (event.propertyName !== 'height') { return; }
                    panel.style.height = 'auto';
                    panel.removeEventListener('transitionend', done);
                });
            }

            function collapse(panel) {
                panel.style.height = panel.scrollHeight + 'px';
                void panel.offsetHeight;
                panel.style.height = '0px';

                panel.addEventListener('transitionend', function done(event) {
                    if (event.propertyName !== 'height') { return; }
                    panel.hidden = true;
                    panel.style.height = '';
                    panel.removeEventListener('transitionend', done);
                });
            }

            function closeAll(except) {
                Array.prototype.forEach.call(triggers, function (trigger) {
                    if (trigger === except) { return; }
                    if (trigger.getAttribute('aria-expanded') !== 'true') { return; }
                    trigger.setAttribute('aria-expanded', 'false');
                    collapse(panelOf(trigger));
                });
            }

            Array.prototype.forEach.call(triggers, function (trigger, index) {

                trigger.addEventListener('click', function () {
                    var isOpen = trigger.getAttribute('aria-expanded') === 'true';

                    if (isOpen) {
                        trigger.setAttribute('aria-expanded', 'false');
                        collapse(panelOf(trigger));
                    } else {
                        closeAll(trigger);
                        trigger.setAttribute('aria-expanded', 'true');
                        expand(panelOf(trigger));
                    }
                });

                /* Arrow keys / Home / End move between headers */
                trigger.addEventListener('keydown', function (event) {
                    var target = null;

                    if (event.key === 'ArrowDown') {
                        target = triggers[(index + 1) % triggers.length];
                    } else if (event.key === 'ArrowUp') {
                        target = triggers[(index - 1 + triggers.length) % triggers.length];
                    } else if (event.key === 'Home') {
                        target = triggers[0];
                    } else if (event.key === 'End') {
                        target = triggers[triggers.length - 1];
                    }

                    if (target) {
                        event.preventDefault();
                        target.focus();
                    }
                });
            });
        });
    }


    /* 3. TESTIMONIAL CAROUSEL */
    function initCarousel() {
        var carousel = document.querySelector('[data-carousel]');
        if (!carousel) { return; }

        var slides = carousel.querySelectorAll('[data-slide]');
        var dots = carousel.querySelectorAll('.carousel-dot');
        var prev = carousel.querySelector('[data-prev]');
        var next = carousel.querySelector('[data-next]');

        if (!slides.length) { return; }

        var AUTOPLAY_MS = 3000;
        var timer = null;
        var held = false;      /* pointer over the deck, or focus inside it */
        var onScreen = true;   /* scrolled into view and tab in the foreground */
        var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        var current = 0;
        Array.prototype.forEach.call(slides, function (slide, index) {
            if (slide.classList.contains('is-active')) { current = index; }
        });

        carousel.classList.add('is-ready');

        function show(index) {
            current = (index + slides.length) % slides.length;

            Array.prototype.forEach.call(slides, function (slide, i) {
                var on = i === current;
                slide.classList.toggle('is-active', on);
                slide.setAttribute('aria-hidden', String(!on));
            });

            Array.prototype.forEach.call(dots, function (dot, i) {
                dot.classList.toggle('is-active', i === current);
                dot.setAttribute('aria-selected', String(i === current));
                dot.tabIndex = i === current ? 0 : -1;
            });
        }

        function stop() {
            if (timer) { window.clearInterval(timer); timer = null; }
        }

        function play() {
            stop();
            if (reduced || held || !onScreen || slides.length < 2) { return; }
            timer = window.setInterval(function () { show(current + 1); }, AUTOPLAY_MS);
        }

        function goTo(index) {
            show(index);
            play();
        }

        if (prev) { prev.addEventListener('click', function () { goTo(current - 1); }); }
        if (next) { next.addEventListener('click', function () { goTo(current + 1); }); }

        Array.prototype.forEach.call(dots, function (dot, index) {
            dot.addEventListener('click', function () { goTo(index); });

            dot.addEventListener('keydown', function (event) {
                var target = null;
                if (event.key === 'ArrowRight') { target = (index + 1) % dots.length; }
                else if (event.key === 'ArrowLeft') { target = (index - 1 + dots.length) % dots.length; }
                if (target === null) { return; }
                event.preventDefault();
                goTo(target);
                dots[target].focus();
            });
        });

        /* Hold while the visitor is reading or interacting. */
        carousel.addEventListener('mouseenter', function () { held = true; stop(); });
        carousel.addEventListener('mouseleave', function () { held = false; play(); });
        carousel.addEventListener('focusin', function () { held = true; stop(); });
        carousel.addEventListener('focusout', function () { held = false; play(); });

        /* Hold in a background tab. */
        document.addEventListener('visibilitychange', function () {
            onScreen = !document.hidden;
            play();
        });

        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                onScreen = entries[0].isIntersecting && !document.hidden;
                play();
            }, { threshold: 0.35 }).observe(carousel);
        }

        show(current);
        play();
    }


    function initSectionNav() {
        var nav = document.querySelector('[data-section-nav]');
        if (!nav) { return; }

        var navWrap = nav.closest('.section-nav');
        var header = document.querySelector('.site-header');
        var links = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));

        /* Pair every link with its section and keep them in document order */
        var items = [];
        links.forEach(function (link) {
            var section = document.getElementById(link.getAttribute('href').slice(1));
            if (section) { items.push({ link: link, section: section }); }
        });

        if (!items.length) { return; }

        items.sort(function (a, b) {
            return a.section.getBoundingClientRect().top - b.section.getBoundingClientRect().top;
        });

        var activeLink = null;
        var lockedLink = null;   /* held while a click-scroll is in flight */
        var idleTimer = null;
        var releaseTimer = null;
        var ticking = false;
        var placeholder = null;
        var stickyAt = 0;


        /* ---- geometry ---------------------------------------------------- */

        /* Everything currently pinned to the top of the viewport */
        function chromeHeight() {
            var height = header ? header.offsetHeight : 0;
            if (navWrap && navWrap.classList.contains('is-sticky')) {
                height += navWrap.offsetHeight;
            }
            return height;
        }

        function readingLine() {
            var margin = parseFloat(getComputedStyle(items[0].section).scrollMarginTop) || 0;
            return Math.max(chromeHeight(), margin) + 4;
        }


        /* ---- active link -------------------------------------------------- */

        function activate(link) {
            if (link === activeLink) { return; }   /* no redundant DOM writes */
            activeLink = link;
            links.forEach(function (other) {
                other.classList.toggle('is-active', other === link);
            });
        }

        function currentLink() {
            var doc = document.documentElement;

            if (window.pageYOffset + window.innerHeight >= doc.scrollHeight - 2) {
                return items[items.length - 1].link;
            }

            var line = readingLine();
            var found = items[0].link;

            for (var i = 0; i < items.length; i++) {
                if (items[i].section.getBoundingClientRect().top <= line) {
                    found = items[i].link;
                } else {
                    break;
                }
            }

            return found;
        }

        function update() {
            ticking = false;
            activate(lockedLink || currentLink());
        }

        function release() {
            clearTimeout(idleTimer);
            clearTimeout(releaseTimer);
            lockedLink = null;
            update();
        }


        /* ---- sticky bar --------------------------------------------------- */

        function stick() {
            if (!navWrap || navWrap.classList.contains('is-sticky')) { return; }

            placeholder = document.createElement('div');
            placeholder.className = 'section-nav__placeholder';
            placeholder.style.height = navWrap.offsetHeight + 'px';
            navWrap.parentNode.insertBefore(placeholder, navWrap);

            navWrap.classList.add('is-sticky');
            navWrap.style.top = (header ? header.offsetHeight : 0) + 'px';
        }

        function unstick() {
            if (!navWrap || !navWrap.classList.contains('is-sticky')) { return; }

            navWrap.classList.remove('is-sticky');
            navWrap.style.top = '';

            if (placeholder && placeholder.parentNode) {
                placeholder.parentNode.removeChild(placeholder);
            }
            placeholder = null;
        }

        function syncSticky() {
            if (!navWrap) { return; }
            var headerHeight = header ? header.offsetHeight : 0;
            if (window.pageYOffset >= stickyAt - headerHeight) { stick(); } else { unstick(); }
        }

        function measureSticky() {
            if (!navWrap) { return; }
            var anchor = placeholder || navWrap;
            stickyAt = anchor.getBoundingClientRect().top + window.pageYOffset;
            syncSticky();
        }


        /* ---- events -------------------------------------------------------- */

        function onScroll() {
            syncSticky();

            if (lockedLink) {
                clearTimeout(idleTimer);
                idleTimer = setTimeout(release, 140);
            }

            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(update);
            }
        }

        links.forEach(function (link) {
            link.addEventListener('click', function () {
                if (!document.getElementById(link.getAttribute('href').slice(1))) { return; }

                lockedLink = link;
                activate(link);

                clearTimeout(releaseTimer);
                releaseTimer = setTimeout(release, 1200);
            });
        });

        window.addEventListener('scroll', onScroll, { passive: true });

        window.addEventListener('resize', function () {
            measureSticky();
            update();
        });

        window.addEventListener('load', function () {
            measureSticky();
            update();
        });

        measureSticky();
        update();
    }


    function initForms() {

        var forms = document.querySelectorAll('[data-lead-form]');
        if (!forms.length) { return; }

        var HONEYPOTS = ['website', 'company_url', 'fax'];

        /* Bots submit instantly; a human needs a few seconds */
        var MIN_FILL_SECONDS = 3;

        var EMAIL_PATTERN = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*\.[A-Za-z]{2,24}$/;
        var NAME_PATTERN = /^[A-Za-z][A-Za-z\s.'\-]{1,59}$/;

        /* Throwaway inboxes — these leads are never reachable */
        var DISPOSABLE_DOMAINS = [
            'mailinator.com', 'yopmail.com', 'guerrillamail.com', 'tempmail.com',
            'temp-mail.org', '10minutemail.com', 'trashmail.com', 'sharklasers.com',
            'getnada.com', 'dispostable.com', 'fakeinbox.com', 'maildrop.cc',
            'throwawaymail.com', 'mailnesia.com', 'spam4.me', 'moakt.com'
        ];


        function fieldOf(control) {
            return control.closest('.field');
        }

        function setError(control, message) {
            var field = fieldOf(control);
            if (!field) { return; }

            var output = field.querySelector('[data-error]');
            field.classList.toggle('is-invalid', Boolean(message));
            control.setAttribute('aria-invalid', message ? 'true' : 'false');
            if (output) { output.textContent = message || ''; }
        }

        function clearAllErrors(controls) {
            Array.prototype.forEach.call(controls, function (control) {
                setError(control, '');
            });
        }



        function normalizePhone(raw) {
            var digits = String(raw || '').replace(/\D/g, '');

            if (digits.length === 12 && digits.indexOf('91') === 0) {
                digits = digits.slice(2);
            } else if (digits.length === 11 && digits.charAt(0) === '0') {
                digits = digits.slice(1);
            }

            return digits;
        }

        function validatePhone(raw) {
            var value = String(raw || '').trim();

            if (/[A-Za-z]/.test(value)) {
                return 'Enter a valid mobile number.';
            }

            var digits = normalizePhone(value);

            if (!digits) { return 'This field is required.'; }

            /* Repeated or sequential filler such as 0000000000 / 1234567890 */
            if (/^(\d)\1+$/.test(digits) || digits === '1234567890') {
                return 'Enter a valid mobile number.';
            }

            /* International number entered with a non-Indian country code */
            var isInternational = value.indexOf('+') === 0 && value.replace(/\D/g, '').indexOf('91') !== 0;
            if (isInternational) {
                var all = value.replace(/\D/g, '');
                return (all.length >= 8 && all.length <= 15) ? '' : 'Enter a valid mobile number.';
            }

            if (digits.length !== 10) {
                return 'Enter a 10-digit mobile number.';
            }

            if (!/^[6-9]/.test(digits)) {
                return 'Mobile number must start with 6, 7, 8 or 9.';
            }

            return '';
        }

        function validateEmail(raw) {
            var value = String(raw || '').trim();

            if (value.length > 100) { return 'Email address is too long.'; }
            if (value.indexOf('..') !== -1) { return 'Enter a valid email address.'; }
            if (!EMAIL_PATTERN.test(value)) { return 'Enter a valid email address.'; }

            var domain = value.split('@')[1].toLowerCase();
            if (DISPOSABLE_DOMAINS.indexOf(domain) !== -1) {
                return 'Please use a permanent email address.';
            }

            return '';
        }

        function validateName(raw) {
            var value = String(raw || '').trim();

            if (value.length < 2) { return 'Enter your full name.'; }
            if (/\d/.test(value)) { return 'Name cannot contain numbers.'; }
            if (!NAME_PATTERN.test(value)) { return 'Enter a valid name.'; }

            return '';
        }

        function validateOrganisation(raw) {
            var value = String(raw || '').trim();

            if (!value) { return ''; }
            if (value.length < 2) { return 'Enter a valid organization name.'; }
            if (/https?:\/\/|www\./i.test(value)) { return 'Enter a valid organization name.'; }

            return '';
        }

        /* Single entry point used by blur, input and submit */
        function validate(control) {
            var value = (control.value || '').trim();
            var name = control.getAttribute('name');
            var required = control.hasAttribute('required');
            var message = '';

            if (required && !value) {
                message = control.tagName === 'SELECT'
                    ? 'Please make a selection.'
                    : 'This field is required.';
                setError(control, message);
                return false;
            }

            if (!value && !required) {
                setError(control, '');
                return true;
            }

            if (name === 'name') { message = validateName(value); }
            else if (name === 'email') { message = validateEmail(value); }
            else if (name === 'phone') { message = validatePhone(value); }
            else if (name === 'organisation') { message = validateOrganisation(value); }

            setError(control, message);
            return !message;
        }


        function showFormError(form, message) {
            var banner = form.querySelector('[data-form-error]');
            if (!banner) { return; }

            banner.textContent = message || '';
            banner.hidden = !message;
        }


        Array.prototype.forEach.call(forms, function (form) {

            /* Honeypots are excluded from validation and from the payload */
            var controls = Array.prototype.filter.call(
                form.querySelectorAll('input, select'),
                function (control) {
                    return HONEYPOTS.indexOf(control.getAttribute('name')) === -1
                        && control.type !== 'hidden';
                }
            );

            var success = form.querySelector('[data-success]');
            var submitBtn = form.querySelector('button[type="submit"]');
            var state = { sending: false };
            var renderedAt = Date.now();

            controls.forEach(function (control) {
                control.addEventListener('blur', function () { validate(control); });
                control.addEventListener('change', function () { validate(control); });
                control.addEventListener('input', function () {
                    var field = fieldOf(control);
                    if (field && field.classList.contains('is-invalid')) {
                        validate(control);
                    }
                });
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                if (state.sending) { return; }

                if (success) { success.hidden = true; }
                showFormError(form, '');

                /* --- client-side validation ------------------------------- */
                var firstInvalid = null;
                controls.forEach(function (control) {
                    if (!validate(control) && !firstInvalid) { firstInvalid = control; }
                });

                if (firstInvalid) {
                    firstInvalid.focus();
                    return;
                }

                /* --- honeypot: a filled hidden field means a bot ---------- */
                var trapped = false;
                HONEYPOTS.forEach(function (name) {
                    var trap = form.querySelector('[name="' + name + '"]');
                    if (trap && trap.value) { trapped = true; }
                });

                var elapsed = Math.round((Date.now() - renderedAt) / 1000);

                if (trapped || elapsed < MIN_FILL_SECONDS) {
                    form.reset();
                    clearAllErrors(controls);
                    if (success) { success.hidden = false; }
                    return;
                }

                /* --- submit ---------------------------------------------- */
                var formData = new FormData(form);
                var payload = {
                    full_name: formData.get('name') || '',
                    email: formData.get('email') || '',
                    mobile: formData.get('phone') || '',
                    current_role: formData.get('role') || '',
                    organization: formData.get('organisation') || '',
                    programme: formData.get('programme') || CONFIG.DEFAULT_PROGRAMME,
                    form_name: form.getAttribute('data-form-name') || 'ESIA Lead Form',
                    page_url: window.location.href,
                    elapsed: elapsed
                };

                var originalBtnText = submitBtn ? submitBtn.innerHTML : '';

                state.sending = true;
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Submitting...';
                }

                function finish() {
                    state.sending = false;
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                }

                /* Same-origin now, so a normal JSON request is fine. */
                function post(url) {
                    return fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CONFIG.CSRF_TOKEN },
                        credentials: 'same-origin',
                        body: JSON.stringify(payload)
                    });
                }

                post(Endpoints.lead)
                    .then(function (response) {
                        if ((response.redirected || response.status === 405)
                            && Endpoints.dropExtension()) {
                            return post(Endpoints.lead);
                        }
                        return response;
                    })
                    .then(function (response) { return response.json(); })
                    .then(function (result) {

                        if (result && result.success) {
                            form.reset();
                            clearAllErrors(controls);
                            renderedAt = Date.now();
                            if (success) { success.hidden = false; }

                            Brochure.store(result.download);

                            if (Brochure.available()) {
                                var opened = Brochure.deliver();
                                var lead = result.duplicate
                                    ? 'You have already registered'
                                    : 'Thank you';
                                notify(
                                    opened
                                        ? lead + ' \u2014 your brochure is opening in a new tab.'
                                        : lead + ' \u2014 use the brochure button below to open it.',
                                    'success'
                                );
                            } else {
                                notify('Thank you \u2014 your request has been received.', 'success');
                            }
                            return;
                        }

                        console.error('Lead not saved:', result);

                        var message = (result && result.message) || 'Something went wrong. Please try again.';

                        /* Point at the offending field when the server names one */
                        if (result && result.field) {
                            var target = form.querySelector('[name="' + result.field + '"]');
                            if (target) {
                                setError(target, message);
                                target.focus();
                            }
                        }

                        showFormError(form, message);
                    })
                    .catch(function (error) {
                        console.error('Submission failed:', error);
                        showFormError(
                            form,
                            'We could not reach the server. Please check your connection and try again.'
                        );
                    })
                    .then(finish, finish);
            });
        });
    }


    var Brochure = (function () {

        var grant = null;   /* { token, expires } handed back by lead.php */

        function available() {
            return Boolean(grant && grant.token && Date.now() < grant.expires);
        }

        function url(mode) {
            return Endpoints.brochure +
                '?mode=' + mode +
                '&t=' + encodeURIComponent(grant.token);
        }

        function saveCopy() {
            var frame = document.getElementById('brochure-sink');
            if (!frame) {
                frame = document.createElement('iframe');
                frame.id = 'brochure-sink';
                frame.setAttribute('aria-hidden', 'true');
                frame.style.cssText = 'position:absolute;width:0;height:0;border:0;left:-9999px;';
                document.body.appendChild(frame);
            }
            frame.src = url('download');
        }

        function openTab() {
            var win = window.open(url('inline'), '_blank', 'noopener');
            return Boolean(win);
        }

        function deliver() {
            if (!available()) { return false; }

            var mode = CONFIG.BROCHURE_DELIVERY || 'both';

            if (mode === 'download') { saveCopy(); return true; }
            if (mode === 'tab') { return openTab(); }

            saveCopy();
            return openTab();
        }

        function revealLinks() {
            var links = document.querySelectorAll('[data-brochure-link]');
            Array.prototype.forEach.call(links, function (link) {
                if (!available()) { link.hidden = true; return; }
                link.href = url('inline');
                link.hidden = false;
            });
        }

        function store(download) {
            if (!download || !download.token) { return; }
            grant = { token: download.token, expires: Number(download.expires) || 0 };
            revealLinks();
        }

        function nearestForm(trigger) {
            var forms = document.querySelectorAll('[data-lead-form]');
            if (!forms.length) { return null; }

            var origin = trigger.getBoundingClientRect().top + window.pageYOffset;
            var best = null;
            var bestGap = Infinity;

            Array.prototype.forEach.call(forms, function (form) {
                var box = form.getBoundingClientRect();
                var middle = box.top + window.pageYOffset + (box.height / 2);
                var gap = Math.abs(middle - origin);
                if (gap < bestGap) { bestGap = gap; best = form; }
            });

            return best;
        }

        function sendToForm(form) {
            if (!form) { return; }

            var anchor = form.closest('.lead-card') || form;
            anchor.scrollIntoView({
                behavior: prefersReducedMotion() ? 'auto' : 'smooth',
                block: 'center'
            });

            var first = form.querySelector('input:not([type="hidden"]), select');
            if (!first) { return; }

            /* Focus after the scroll settles, otherwise the browser jumps. */
            window.setTimeout(function () {
                try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); }
                form.classList.add('is-highlighted');
                window.setTimeout(function () {
                    form.classList.remove('is-highlighted');
                }, 1800);
            }, prefersReducedMotion() ? 0 : 520);
        }

        function restore() {
            if (!window.fetch) { return; }

            fetch(Endpoints.lead + '?grant=1', {
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json' }
            })
                .then(function (r) {
                    Endpoints.adopt(r.url);
                    return r.ok ? r.json() : null;
                })
                .then(function (data) {
                    if (data && data.granted) { store(data.download); }
                })
                .catch(function () { /* the gate simply stays shut */ });
        }

        function init() {
            var buttons = document.querySelectorAll('[data-brochure]');

            Array.prototype.forEach.call(buttons, function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    if (available()) {
                        if (!deliver()) {
                            notify('Your brochure is ready — use the link in the form above.', 'info');
                            revealLinks();
                        }
                        return;
                    }

                    sendToForm(nearestForm(button));
                    notify('Please fill in the form to download the brochure.', 'info');
                });
            });

            restore();
        }

        return {
            init: init,
            store: store,
            deliver: deliver,
            available: available,
            revealLinks: revealLinks
        };
    }());


    function initFacultyCarousel() {
        var root = document.querySelector('[data-faculty-carousel]');
        if (!root) { return; }

        var viewport = root.querySelector('.faculty-carousel__viewport');
        var track = root.querySelector('.faculty-carousel__track');
        var prev = root.querySelector('[data-faculty-prev]');
        var next = root.querySelector('[data-faculty-next]');
        var originals = Array.prototype.slice.call(track.children);
        var count = originals.length;

        if (count < 2) { return; }

        var AUTOPLAY_MS = 3000;
        var SLIDE_MS = 500;        /* keep in step with the CSS transition */
        var index = 0;
        var perView = 0;
        var timer = null;
        var wrapTimer = null;
        var held = false;      /* pointer over the rail, or focus inside it */
        var onScreen = true;   /* in view and tab in the foreground */
        var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function readPerView() {
            var raw = parseInt(getComputedStyle(root).getPropertyValue('--per-view'), 10);
            if (isNaN(raw)) { raw = 3; }
            return Math.max(1, Math.min(raw, count));
        }

        function stepSize() {
            var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
            return originals[0].offsetWidth + gap;
        }

        function setPos(to, animate) {
            index = to;
            var x = -index * stepSize();

            if (animate && !reduced) {
                track.style.transform = 'translateX(' + x + 'px)';
                return;
            }

            track.style.transition = 'none';
            track.style.transform = 'translateX(' + x + 'px)';
            void track.offsetWidth;        /* flush, so the next move animates */
            track.style.transition = '';
        }

        function build() {
            Array.prototype.slice.call(track.querySelectorAll('[data-clone]'))
                .forEach(function (node) { track.removeChild(node); });

            perView = readPerView();

            var copies = Math.min(count, Math.max(perView, 4));

            for (var i = 0; i < copies; i++) {
                var copy = originals[i].cloneNode(true);
                copy.setAttribute('data-clone', '');
                copy.setAttribute('aria-hidden', 'true');
                /* a duplicate must never become a tab stop */
                Array.prototype.forEach.call(copy.querySelectorAll('a, button'), function (el) {
                    el.tabIndex = -1;
                });
                track.appendChild(copy);
            }

            if (index > count) { index = 0; }
            setPos(index, false);
        }

        function scheduleWrap() {
            window.clearTimeout(wrapTimer);
            if (index < count) { return; }
            wrapTimer = window.setTimeout(function () {
                setPos(0, false);
            }, reduced ? 0 : SLIDE_MS + 20);
        }

        function forward() {
            if (index >= count) { setPos(0, false); }
            setPos(index + 1, true);
            scheduleWrap();
        }

        function back() {
            window.clearTimeout(wrapTimer);
            if (index <= 0) { setPos(count, false); }
            setPos(index - 1, true);
        }

        function stop() {
            if (timer) { window.clearInterval(timer); timer = null; }
        }

        function play() {
            stop();
            if (reduced || held || !onScreen || count <= perView) { return; }
            timer = window.setInterval(forward, AUTOPLAY_MS);
        }

        function nudge(fn) { fn(); play(); }

        if (prev) { prev.addEventListener('click', function () { nudge(back); }); }
        if (next) { next.addEventListener('click', function () { nudge(forward); }); }

        root.addEventListener('mouseenter', function () { held = true; stop(); });
        root.addEventListener('mouseleave', function () { held = false; play(); });
        root.addEventListener('focusin', function () { held = true; stop(); });
        root.addEventListener('focusout', function () { held = false; play(); });

        document.addEventListener('visibilitychange', function () {
            onScreen = !document.hidden;
            play();
        });

        if ('IntersectionObserver' in window) {
            new IntersectionObserver(function (entries) {
                onScreen = entries[0].isIntersecting && !document.hidden;
                play();
            }, { threshold: 0.2 }).observe(root);
        }

        /* Swipe, so the rail behaves on a touchscreen. */
        var touchX = null;
        track.addEventListener('touchstart', function (e) {
            touchX = e.touches[0].clientX;
            held = true;
            stop();
        }, { passive: true });

        track.addEventListener('touchend', function (e) {
            if (touchX === null) { return; }
            var delta = e.changedTouches[0].clientX - touchX;
            touchX = null;
            held = false;
            if (Math.abs(delta) > 40) { (delta < 0 ? forward : back)(); }
            play();
        });

        var lastWidth = 0;
        function refresh() {
            var w = viewport.offsetWidth;
            if (w === lastWidth) { return; }
            lastWidth = w;
            stop();
            build();
            play();
        }

        if ('ResizeObserver' in window) {
            new ResizeObserver(refresh).observe(viewport);
        } else {
            var resizeTimer = null;
            window.addEventListener('resize', function () {
                window.clearTimeout(resizeTimer);
                resizeTimer = window.setTimeout(refresh, 150);
            });
        }

        build();
        play();

        window.addEventListener('load', refresh);
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(refresh);
        }
    }


    /* BOOT */
    function init() {
        initMobileNav();
        initAccordions();
        initCarousel();
        initSectionNav();
        initForms();
        Brochure.init();
        initFacultyCarousel();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
}());
