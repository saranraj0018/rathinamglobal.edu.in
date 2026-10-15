
/* 1. UTILITIES */

function onReady(fn) {
    if (document.readyState !== 'loading') {
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}

/* 2. NAVBAR — sticky scroll + mobile drawer */

function initNavbar() {
    const navbar  = document.getElementById('navbar');
    const toggle  = document.getElementById('mobile-menu-toggle');
    const menu    = document.getElementById('mobile-menu');
    const iconMenu  = document.getElementById('icon-menu');
    const iconClose = document.getElementById('icon-close');

    if (!navbar) return;

    // Sticky on scroll
    function handleScroll() {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll(); // Run once on load

    // Mobile menu toggle
    if (toggle && menu) {
        toggle.addEventListener('click', function () {
            const isOpen = menu.classList.contains('open');
            if (isOpen) {
                closeMobileMenu();
            } else {
                menu.classList.add('open');
                iconMenu.style.display  = 'none';
                iconClose.style.display = 'block';
                toggle.setAttribute('aria-expanded', 'true');
            }
        });
    }
}

/** Close mobile menu — also called from inline onclick in PHP partials */
function closeMobileMenu() {
    const menu      = document.getElementById('mobile-menu');
    const toggle    = document.getElementById('mobile-menu-toggle');
    const iconMenu  = document.getElementById('icon-menu');
    const iconClose = document.getElementById('icon-close');
    if (!menu) return;
    menu.classList.remove('open');
    if (iconMenu)  iconMenu.style.display  = 'block';
    if (iconClose) iconClose.style.display = 'none';
    if (toggle)    toggle.setAttribute('aria-expanded', 'false');
}

/* 3. HERO — cinematic reveal + mouse parallax + counters */

function initHero() {
    const cineTop    = document.getElementById('cine-top');
    const cineBottom = document.getElementById('cine-bottom');
    const video      = document.getElementById('hero-video');
    const spotlight  = document.getElementById('hero-spotlight');
    const heroSection = document.getElementById('hero');

    // Cinematic reveal after 400 ms
    setTimeout(function () {
        if (cineTop)    cineTop.classList.add('revealed');
        if (cineBottom) cineBottom.classList.add('revealed');
    }, 400);

    // Mouse parallax on hero video
    if (heroSection && video) {
        window.addEventListener('mousemove', function (e) {
            const rect = heroSection.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width)  * 100;
            const y = ((e.clientY - rect.top)  / rect.height) * 100;
            const pX = ((x - 50) * -0.018).toFixed(3);
            const pY = ((y - 50) * -0.018).toFixed(3);
            video.style.transform = `scale(1.10) translate(${pX}%, ${pY}%)`;

            // Update cursor spotlight
            if (spotlight) {
                spotlight.style.background =
                    `radial-gradient(ellipse 55vw 55vh at ${x}% ${y}%, transparent 0%, rgba(8,8,16,.58) 45%, rgba(8,8,16,.9) 75%, rgba(8,8,16,.97) 100%)`;
            }
        }, { passive: true });
    }

    // Animated counters
    initCounters();
}

function initCounters() {
    const counters = document.querySelectorAll('.hero-counter');
    if (!counters.length) return;

    let started = false;

    function startCounters() {
        if (started) return;
        started = true;
        counters.forEach(function (el) {
            const target = parseInt(el.dataset.target, 10) || 0;
            const suffix = el.dataset.suffix || '';
            let step  = 0;
            const steps = 50;
            const id = setInterval(function () {
                step++;
                el.textContent = Math.round((target * step) / steps) + suffix;
                if (step >= steps) {
                    clearInterval(id);
                    el.textContent = target + suffix;
                }
            }, 28);
        });
    }

    // Start counters after hero reveal (1s delay)
    setTimeout(startCounters, 1000);
}

/* 4. INTERSECTION OBSERVER — scroll triggered animations */

function initScrollAnimations() {
    const elements = document.querySelectorAll('.reveal-up, .reveal-scale');
    if (!elements.length) return;

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Stop observing once revealed (one-shot animation)
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08 });

    elements.forEach(function (el) {
        observer.observe(el);
    });
}

/* 5. PROGRESS BARS — animate when section enters viewport */

function initProgressBars() {
    const bars = document.querySelectorAll('.progress-bar');
    if (!bars.length) return;

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                const bar   = entry.target;
                const width = bar.dataset.width || '0';
                // Small delay so the reveal animation fires first
                setTimeout(function () {
                    bar.style.width = width + '%';
                }, 300);
                observer.unobserve(bar);
            }
        });
    }, { threshold: 0.12 });

    bars.forEach(function (bar) {
        bar.style.width = '0%'; // ensure starting at 0
        observer.observe(bar);
    });
}

/* 6. EVENT FILTER — happening section tag filtering */

function initEventFilter() {
    const filterContainer = document.getElementById('event-filters');
    const eventsGrid      = document.getElementById('events-grid');
    if (!filterContainer || !eventsGrid) return;

    const filterBtns  = filterContainer.querySelectorAll('.filter-btn');
    const eventCards  = eventsGrid.querySelectorAll('.event-card');

    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = btn.dataset.filter;

            // Update active state
            filterBtns.forEach(function (b) {
                b.classList.remove('active');
                b.setAttribute('aria-pressed', 'false');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-pressed', 'true');

            // Show/hide event cards
            eventCards.forEach(function (card) {
                if (filter === 'All' || card.dataset.tag === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

/* 7. SMOOTH SCROLL — anchor link behaviour */

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const targetId = anchor.getAttribute('href').slice(1);
            if (!targetId) return;
            const target = document.getElementById(targetId);
            if (target) {
                e.preventDefault();
                const navHeight = document.getElementById('navbar')
                    ? document.getElementById('navbar').offsetHeight
                    : 0;
                const top = target.getBoundingClientRect().top + window.pageYOffset - navHeight;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    });
}

/* 8. CARD HOVER — mobile touch fallback (outcome progress) */

function initCardHoverMobile() {
    // On touch devices, inline onmouseenter/onmouseleave don't always fire.
    // This adds equivalent touch events for the outcome progress bars.
    const outcomeCards = document.querySelectorAll('.outcome-card');
    outcomeCards.forEach(function (card) {
        card.addEventListener('touchstart', function () {
            const fill = card.querySelector('.outcome-fill');
            const icon = card.querySelector('.outcome-icon');
            if (fill) fill.style.width = '100%';
            if (icon) icon.style.transform = 'rotate(12deg) scale(1.1)';
        }, { passive: true });
        card.addEventListener('touchend', function () {
            const fill = card.querySelector('.outcome-fill');
            const icon = card.querySelector('.outcome-icon');
            if (fill) fill.style.width = '25%';
            if (icon) icon.style.transform = 'none';
        }, { passive: true });
    });
}


function injectDelayStyles() {
    const delays = [0, 80, 100, 120, 160, 200, 240, 300, 320, 360, 400, 500, 700];
    const rules  = delays.map(function (d) {
        return `.delay-${d} { transition-delay: ${d}ms; }`;
    }).join('\n');
    const style = document.createElement('style');
    style.textContent = rules;
    document.head.appendChild(style);
}

/* 10. INIT — wire everything up on DOMContentLoaded */

onReady(function () {
    injectDelayStyles();
    initNavbar();
    initHero();
    initScrollAnimations();
    initProgressBars();
    initEventFilter();
    initSmoothScroll();
    initCardHoverMobile();
});
