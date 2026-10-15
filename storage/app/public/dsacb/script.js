/* DSACB 2027 landing page — in-page nav, track accordion, smooth scroll. */
(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    ready(function () {
        var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* ═══ In-page nav ══════════════════════════════════════════════ */
        var nav = document.getElementById('lp-nav');
        var menu = document.getElementById('lp-nav-menu');
        var toggle = document.getElementById('lp-nav-toggle');
        var navLinks = [].slice.call(document.querySelectorAll('[data-lp-nav]'));

        function closeMenu() {
            if (!menu || !toggle) return;
            menu.classList.remove('is-open');
            toggle.setAttribute('aria-expanded', 'false');
        }

        if (toggle && menu) {
            toggle.addEventListener('click', function () {
                var open = toggle.getAttribute('aria-expanded') === 'true';
                menu.classList.toggle('is-open', !open);
                toggle.setAttribute('aria-expanded', open ? 'false' : 'true');
            });

            /* Tapping a link, pressing Escape or clicking away closes the panel. */
            menu.addEventListener('click', function (e) {
                if (e.target.closest('a')) closeMenu();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeMenu();
            });
            document.addEventListener('click', function (e) {
                if (!nav.contains(e.target)) closeMenu();
            });
            window.addEventListener('resize', function () {
                if (window.innerWidth > 1024) closeMenu();
            });
        }

        /* Solid-ish bar once the page has scrolled off the top. */
        if (nav) {
            var stuck = false;
            var onScroll = function () {
                var next = window.scrollY > 8;
                if (next !== stuck) { stuck = next; nav.classList.toggle('is-stuck', next); }
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        }

        var sections = navLinks.map(function (a) {
            return { link: a, el: document.getElementById(a.getAttribute('data-lp-nav')) };
        }).filter(function (s) { return s.el; });

        function updateActive() {
            var line = window.scrollY + (nav ? nav.offsetHeight : 0) + 24;
            var current = null;

            for (var i = 0; i < sections.length; i++) {
                if (sections[i].el.getBoundingClientRect().top + window.scrollY <= line) {
                    current = sections[i];
                }
            }
            sections.forEach(function (s) {
                s.link.classList.toggle('is-active', s === current);
            });
        }

        if (sections.length) {
            var pending = false;
            var queueActive = function () {
                if (pending) return;
                pending = true;
                setTimeout(function () { pending = false; updateActive(); }, 100);
            };
            window.addEventListener('scroll', queueActive, { passive: true });
            window.addEventListener('resize', queueActive);
            updateActive();
        }

        /* ═══ Tracks accordion ═════════════════════════════════════════ */
        var buttons = [].slice.call(document.querySelectorAll('.lp-acc__btn'));

        function panelOf(btn) {
            return document.getElementById(btn.getAttribute('aria-controls'));
        }

        function setOpen(btn, open) {
            var panel = panelOf(btn);
            var item = btn.closest('.lp-acc__item');
            if (!panel || !item) return;

            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            item.classList.toggle('is-open', open);
            panel.style.maxHeight = open ? panel.scrollHeight + 'px' : '';
        }

        buttons.forEach(function (btn) {
            /* Honour the server-rendered open state on first paint. */
            if (btn.getAttribute('aria-expanded') === 'true') setOpen(btn, true);

            btn.addEventListener('click', function () {
                var open = btn.getAttribute('aria-expanded') === 'true';
                buttons.forEach(function (b) { setOpen(b, false); });
                if (!open) setOpen(btn, true);
            });
        });

        /* Re-measure the open panel when reflow changes its height. */
        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                buttons.forEach(function (b) {
                    if (b.getAttribute('aria-expanded') === 'true') {
                        var p = panelOf(b);
                        if (p) p.style.maxHeight = p.scrollHeight + 'px';
                    }
                });
            }, 150);
        });

        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                var id = this.getAttribute('href');
                if (!id || id === '#') return;

                var target = document.querySelector(id);
                if (!target) return;

                e.preventDefault();
                target.scrollIntoView({ behavior: reduced ? 'auto' : 'smooth', block: 'start' });
                if (history.replaceState) history.replaceState(null, '', id);
            });
        });
    });
})();
