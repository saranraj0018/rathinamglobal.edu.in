
document.addEventListener('DOMContentLoaded', () => {
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // --- Lucide Icons ---
  if (window.lucide) lucide.createIcons();

  const progressBar = document.getElementById('scrollProgressBar');
  const navbar = document.getElementById('mainNavbar');
  const floatingCta = document.getElementById('floatingCta');
  let ticking = false;

  function onScroll() {
    const y = window.scrollY;
    const max = document.documentElement.scrollHeight - window.innerHeight;

    if (progressBar) progressBar.style.width = (max > 0 ? (y / max) * 100 : 0) + '%';
    if (navbar) navbar.classList.toggle('scrolled', y > 20);
    if (floatingCta) floatingCta.classList.toggle('visible', y > 600);

    ticking = false;
  }

  window.addEventListener('scroll', () => {
    if (!ticking) {
      ticking = true;
      window.requestAnimationFrame(onScroll);
    }
  }, { passive: true });

  onScroll();

  /* Scroll reveal */
  const revealTargets = document.querySelectorAll('[data-reveal]');

  // Stagger siblings inside a marked container so grids cascade in.
  document.querySelectorAll('[data-reveal-stagger]').forEach(group => {
    group.querySelectorAll(':scope > [data-reveal]').forEach((el, i) => {
      el.style.setProperty('--reveal-delay', Math.min(i * 80, 480) + 'ms');
    });
  });

  if (reduceMotion || !('IntersectionObserver' in window)) {
    revealTargets.forEach(el => el.classList.add('is-visible'));
  } else {
    const revealObserver = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });

    revealTargets.forEach(el => revealObserver.observe(el));
  }

  /* Navigation: mobile drawer + scrollspy */
  const mobileToggle = document.getElementById('mobileNavToggle');
  const navMenu = document.getElementById('navMenu');
  const navBackdrop = document.getElementById('navBackdrop');

  function setNav(open) {
    if (!navMenu || !mobileToggle) return;
    navMenu.classList.toggle('open', open);
    mobileToggle.setAttribute('aria-expanded', String(open));
    mobileToggle.setAttribute('aria-label', open ? 'Close navigation menu' : 'Open navigation menu');
    document.body.classList.toggle('nav-open', open);
    if (navBackdrop) {
      navBackdrop.hidden = false;
      navBackdrop.classList.toggle('open', open);
    }
  }

  mobileToggle?.addEventListener('click', () => {
    setNav(!navMenu.classList.contains('open'));
  });

  navBackdrop?.addEventListener('click', () => setNav(false));
  navMenu?.querySelectorAll('a').forEach(a => a.addEventListener('click', () => setNav(false)));

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && navMenu?.classList.contains('open')) {
      setNav(false);
      mobileToggle.focus();
    }
  });

  // Drop the drawer state if the viewport grows back to desktop.
  window.matchMedia('(min-width: 861px)').addEventListener('change', e => {
    if (e.matches) setNav(false);
  });

  // Highlight the nav link for whichever section is currently in view.
  const navLinks = [...document.querySelectorAll('.nav-link')];
  const sections = navLinks
    .map(link => document.querySelector(link.getAttribute('href')))
    .filter(Boolean);

  if (sections.length && 'IntersectionObserver' in window) {
    const spy = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        navLinks.forEach(l => l.classList.toggle('active', l.getAttribute('href') === '#' + entry.target.id));
      });
    }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });

    sections.forEach(s => spy.observe(s));
  }

  /* Registration form — validation + Google Sheets submission */
  const registrationForm = document.getElementById('heroRegistrationForm');
  const submitBtn = document.getElementById('submitBtn');
  const btnSpinner = document.getElementById('btnSpinner');
  const btnText = document.getElementById('btnText');
  const formSuccessMessage = document.getElementById('formSuccessMessage');

  const BUS_CONFIG = window.RGU_BUS_CONFIG || {};
  const SUBMIT_ENDPOINTS = BUS_CONFIG.submitUrl ? [BUS_CONFIG.submitUrl] : ['submit/', 'submit.php'];

  // Remembered for the session once one works, so we pay the fallback cost once.
  let workingEndpoint = null;

  async function postRegistration(body) {
    const candidates = workingEndpoint ? [workingEndpoint] : SUBMIT_ENDPOINTS;
    let lastError = null;

    for (const url of candidates) {
      try {
        const res = await fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
            'X-CSRF-TOKEN': BUS_CONFIG.csrfToken || ''
          },
          body
        });
        workingEndpoint = url;
        return res;
      } catch (err) {
        lastError = err;
        console.warn('Endpoint unreachable, trying next:', url, err.message);
      }
    }

    throw lastError || new Error('No submission endpoint reachable.');
  }

  function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorEl = document.getElementById(fieldId + 'Error');
    if (field) {
      field.classList.add('error');
      field.setAttribute('aria-invalid', 'true');
    }
    if (errorEl) {
      errorEl.textContent = message;
      errorEl.classList.add('visible');
    }
  }

  function clearErrors() {
    document.querySelectorAll('.form-control.error').forEach(el => {
      el.classList.remove('error');
      el.removeAttribute('aria-invalid');
    });
    document.querySelectorAll('.error-text.visible').forEach(el => el.classList.remove('visible'));
  }

  function setLoading(isLoading) {
    if (!submitBtn) return;
    submitBtn.disabled = isLoading;
    btnSpinner.style.display = isLoading ? 'inline-block' : 'none';
    btnText.textContent = isLoading ? 'Submitting Request…' : 'Register Interest';
  }

  /* AC upgrade gate + Route → Pickup Location cascade */
  const acUpgradeInput = document.getElementById('acUpgrade');
  const busNoInput = document.getElementById('busNo');
  const pickupSelect = document.getElementById('pickupLocation');
  const routeSelect = document.getElementById('preferredRoute');
  const acGateNote = document.getElementById('acGateNote');
  const pickupHint = document.getElementById('pickupHint');
  const earlyBirdFieldset = document.getElementById('earlyBirdFieldset');

  // Generated from the tariff workbook — see assets/routes.js.
  const ROUTES = window.AC_BUS_ROUTES || {};
  const ROUTE_NAMES = Object.keys(ROUTES);

  if (!ROUTE_NAMES.length) {
    console.error('assets/routes.js did not load — the route dropdown will be empty.');
  }

  function isACYes() {
    return !!acUpgradeInput?.checked;
  }

  function fillOptions(select, values, placeholder) {
    if (!select) return;
    const previous = select.value;
    select.innerHTML = '';

    const first = new Option(placeholder, '');
    first.disabled = true;
    first.selected = true;
    select.add(first);

    values.forEach(v => select.add(new Option(v, v)));

    // Keep the choice if it still exists in the new option set.
    if (previous && values.includes(previous)) select.value = previous;
  }

  fillOptions(routeSelect, ROUTE_NAMES, 'Select your route');

  /** Repopulate pickup stops for the chosen route. */
  function syncPickupOptions() {
    if (!pickupSelect) return;

    const route = routeSelect?.value || '';
    const stops = ROUTES[route] || [];

    if (!route) {
      fillOptions(pickupSelect, [], 'Select a route first');
      pickupSelect.disabled = true;
      if (pickupHint) pickupHint.textContent = 'Choose a route above to see its pickup stops.';
      return;
    }

    fillOptions(pickupSelect, stops, 'Select your pickup stop');
    pickupSelect.disabled = !isACYes();
    if (pickupHint) {
      pickupHint.textContent = stops.length + ' stop' + (stops.length === 1 ? '' : 's') + ' on the ' + route + ' route.';
    }
  }

  /** Enable or disable everything gated behind the AC upgrade answer. */
  function updateACBusDependency() {
    const yes = isACYes();

    if (acGateNote) acGateNote.hidden = yes;
    document.querySelectorAll('.ac-dependent').forEach(el => el.classList.toggle('is-locked', !yes));

    if (busNoInput) busNoInput.disabled = !yes;
    if (routeSelect) routeSelect.disabled = !yes;

    if (earlyBirdFieldset) {
      earlyBirdFieldset.querySelectorAll('input').forEach(inp => { inp.disabled = !yes; });
    }

    if (!yes) {
      // Clear the gated answers so a stale route/stop cannot be submitted.
      if (busNoInput) busNoInput.value = '';
      if (routeSelect) routeSelect.value = '';
      ['busNo', 'preferredRoute', 'pickupLocation'].forEach(id => {
        document.getElementById(id)?.classList.remove('error');
        document.getElementById(id + 'Error')?.classList.remove('visible');
      });
    }

    syncPickupOptions();

    if (submitBtn) {
      submitBtn.disabled = !yes;
      submitBtn.title = yes ? '' : 'Select "Yes" above to register for the AC Bus upgrade.';
    }
  }

  routeSelect?.addEventListener('change', () => {
    syncPickupOptions();
    pickupSelect?.classList.remove('error');
    document.getElementById('pickupLocationError')?.classList.remove('visible');
  });

  // Immediate Features Modal Popup Logic
  const featuresModal = document.getElementById('featuresModal');
  const modalBackdrop = document.getElementById('modalBackdrop');
  const modalCloseBtn = document.getElementById('modalCloseBtn');
  const modalConfirmBtn = document.getElementById('modalConfirmBtn');

  function openFeaturesModal() {
    if (!featuresModal) return;
    featuresModal.classList.add('open');
    featuresModal.setAttribute('aria-hidden', 'false');
    if (window.lucide) lucide.createIcons();
  }

  function closeFeaturesModal() {
    if (!featuresModal) return;
    featuresModal.classList.remove('open');
    featuresModal.setAttribute('aria-hidden', 'true');
    busNoInput?.focus();
  }

  modalBackdrop?.addEventListener('click', closeFeaturesModal);
  modalCloseBtn?.addEventListener('click', closeFeaturesModal);
  modalConfirmBtn?.addEventListener('click', closeFeaturesModal);

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && featuresModal?.classList.contains('open')) {
      closeFeaturesModal();
    }
  });

  acUpgradeInput?.addEventListener('change', e => {
    updateACBusDependency();
    if (e.target.checked) {
      openFeaturesModal();
      routeSelect?.focus();
    }
  });

  updateACBusDependency(); // run initial setup

  // Cloudflare Turnstile Security Verification Callbacks
  let turnstileToken = '';

  window.onTurnstileSuccess = function(token) {
    turnstileToken = token;
    document.getElementById('turnstileError')?.classList.remove('visible');
  };

  window.onTurnstileExpired = function() {
    turnstileToken = '';
  };

  window.onTurnstileError = function(code) {
    turnstileToken = '';
    console.warn('Turnstile error', code, '— the form will fall back to server-side verification.');
  };

  function turnstileRendered() {
    const w = document.querySelector('.cf-turnstile');
    return !!(w && w.querySelector('iframe'));
  }

  // A Turnstile token is single-use — clear it after a failed submit so the
  // visitor can retry instead of being stuck on a stale token.
  function resetTurnstile() {
    turnstileToken = '';
    if (typeof turnstile !== 'undefined' && document.querySelector('.cf-turnstile')) {
      try { turnstile.reset(); } catch (_) { /* widget not ready — non-fatal */ }
    }
  }

  /* Toast notifications */

  const MAX_TOASTS = 3;

  const TOAST_ICONS = {
    success: '<path d="M20 6 9 17l-5-5"/>',
    warning: '<path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/>',
    error:   '<circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/>'
  };

  function svgIcon(paths, size) {
    return `<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 24 24"`
      + ` fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"`
      + ` stroke-linejoin="round" aria-hidden="true" focusable="false">${paths}</svg>`;
  }

  function showToast(message, type = 'success', duration = 5000) {
    const container = document.getElementById('toastContainer');

    // Never let a failure notification vanish silently.
    if (!container) {
      console[type === 'error' ? 'error' : 'warn']('[toast]', message);
      return null;
    }

    const existing = [...container.querySelectorAll('.toast')];

    // Repeated clicks shouldn't stack the same warning over and over.
    const duplicate = existing.find(t => t.dataset.message === message);
    if (duplicate) {
      duplicate.classList.remove('toast-out');
      return duplicate;
    }

    // Cap the stack so a burst of errors can't cover the page.
    existing.slice(0, Math.max(0, existing.length - (MAX_TOASTS - 1)))
      .forEach(t => t.remove());

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.dataset.message = message;

    // Errors interrupt; success is announced only when the user is idle.
    toast.setAttribute('role', type === 'success' ? 'status' : 'alert');

    const icon = document.createElement('div');
    icon.className = 'toast-icon';
    icon.innerHTML = svgIcon(TOAST_ICONS[type] || TOAST_ICONS.success, 16);

    // textContent, not innerHTML: messages carry user input (Student ID) and
    // server text, neither of which may be parsed as markup.
    const text = document.createElement('div');
    text.className = 'toast-message';
    text.textContent = message;

    const closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'toast-close';
    closeBtn.setAttribute('aria-label', 'Close notification');
    closeBtn.innerHTML = svgIcon('<path d="M18 6 6 18"/><path d="m6 6 12 12"/>', 14);

    toast.append(icon, text, closeBtn);
    container.appendChild(toast);

    let timer = null;
    let dismissed = false;

    const dismiss = () => {
      if (dismissed) return;          // click + timeout can both fire
      dismissed = true;
      clearTimeout(timer);
      toast.classList.add('toast-out');
      setTimeout(() => toast.remove(), 300);
    };

    const startTimer = () => {
      if (duration > 0) timer = setTimeout(dismiss, duration);
    };

    // Hold the toast open while it is being read or interacted with.
    toast.addEventListener('mouseenter', () => clearTimeout(timer));
    toast.addEventListener('mouseleave', startTimer);
    toast.addEventListener('focusin', () => clearTimeout(timer));
    toast.addEventListener('focusout', startTimer);

    closeBtn.addEventListener('click', dismiss);
    startTimer();

    return toast;
  }

  function showSuccess(isACUpgrade) {
    setLoading(false);
    registrationForm.style.display = 'none';
    showToast('Success! Your response has been recorded.', 'success', 6000);

    const successTitle = document.getElementById('successTitle');
    const successDesc = document.getElementById('successDesc');
    const acFeaturesPop = document.getElementById('acFeaturesPop');

    if (isACUpgrade) {
      if (successTitle) successTitle.textContent = 'Welcome Aboard Rathinam AC Bus!';
      if (successDesc) {
        successDesc.textContent = 'Your seat registration for the new AC Bus Service has been recorded! Get ready to experience 21°C climate control, Free Wi-Fi, C-Type fast charging, and live GPS tracking.';
      }
      if (acFeaturesPop) acFeaturesPop.style.display = 'block';
    } else {
      if (successTitle) successTitle.textContent = 'Response Submitted!';
      if (successDesc) {
        successDesc.textContent = 'Thank you for submitting your response. Your contact details have been recorded with our transport office.';
      }
      if (acFeaturesPop) acFeaturesPop.style.display = 'none';
    }

    formSuccessMessage.classList.add('active');
    if (window.lucide) lucide.createIcons();
    formSuccessMessage.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
  }

  // Clear a field's error as soon as the user starts correcting it.
  registrationForm?.querySelectorAll('.form-control').forEach(el => {
    el.addEventListener('input', () => {
      if (!el.classList.contains('error')) return;
      // Don't clear error here if textNoNumbers validation is currently failing
      if (['fullName', 'department'].includes(el.id) && /[0-9]/.test(el.value)) return;
      el.classList.remove('error');
      el.removeAttribute('aria-invalid');
      document.getElementById(el.id + 'Error')?.classList.remove('visible');
    });
  });

  function validateNoNumbers(fieldId, fieldLabel, checkRequired = true) {
    const el = document.getElementById(fieldId);
    if (!el) return true;

    const raw = el.value;
    const trimmed = raw.trim();

    // 1. STRICT NUMBER CHECK — Reject any number input
    if (/[0-9]/.test(raw)) {
      showError(fieldId, `${fieldLabel} cannot contain numbers. Please enter letters only.`);
      return false;
    }

    // 2. Empty check
    if (!trimmed) {
      if (checkRequired) {
        showError(fieldId, `Please enter your ${fieldLabel.toLowerCase()}.`);
        return false;
      }
      // If optional / typing, don't show empty error yet
      el.classList.remove('error');
      el.removeAttribute('aria-invalid');
      document.getElementById(fieldId + 'Error')?.classList.remove('visible');
      return true;
    }

    // 3. Special characters check
    const isName = fieldId === 'fullName';
    const validPattern = isName ? /^[a-zA-Z\s.'-]+$/ : /^[a-zA-Z\s.&'-]+$/;

    if (!validPattern.test(trimmed)) {
      showError(fieldId, `${fieldLabel} must contain letters and spaces only.`);
      return false;
    }

    // 4. Minimum length check for Name
    if (isName && trimmed.length < 2) {
      showError(fieldId, `${fieldLabel} must be at least 2 characters long.`);
      return false;
    }

    // Valid field — clear error styling and text
    el.classList.remove('error');
    el.removeAttribute('aria-invalid');
    document.getElementById(fieldId + 'Error')?.classList.remove('visible');
    return true;
  }

  // Attach real-time validation on input & blur for Full Name and Department
  ['fullName', 'department'].forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    const label = id === 'fullName' ? 'Full Name' : 'Department';

    el.addEventListener('input', () => validateNoNumbers(id, label, false));
    el.addEventListener('blur', () => validateNoNumbers(id, label, true));
  });

  function validatePhone(checkRequired = true) {
    const el = document.getElementById('phoneNumber');
    if (!el) return true;

    const raw = el.value.trim();

    if (!raw) {
      if (checkRequired) {
        showError('phoneNumber', 'Please enter your 10-digit mobile number.');
        return false;
      }
      return true;
    }

    if (/[^0-9]/.test(raw)) {
      showError('phoneNumber', 'Phone number must contain numbers only.');
      return false;
    }

    if (raw.length !== 10) {
      showError('phoneNumber', 'Phone number must be exactly 10 digits.');
      return false;
    }

    if (!/^[6-9]/.test(raw)) {
      showError('phoneNumber', 'Please enter a valid mobile number starting with 6, 7, 8, or 9.');
      return false;
    }

    // Valid phone number — clear error styling and text
    el.classList.remove('error');
    el.removeAttribute('aria-invalid');
    document.getElementById('phoneNumberError')?.classList.remove('visible');
    return true;
  }

  // Real-time phone number input filtering (block non-digits & auto-strip)
  const phoneEl = document.getElementById('phoneNumber');
  if (phoneEl) {
    phoneEl.addEventListener('keydown', e => {
      const allowedKeys = ['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'ArrowLeft', 'ArrowRight', 'Home', 'End'];
      if (allowedKeys.includes(e.key) || e.ctrlKey || e.metaKey) return;

      if (e.key < '0' || e.key > '9') {
        e.preventDefault();
        showError('phoneNumber', 'Phone number must contain numbers only.');
      }
    });

    phoneEl.addEventListener('input', () => {
      if (/[^0-9]/.test(phoneEl.value)) {
        phoneEl.value = phoneEl.value.replace(/[^0-9]/g, '');
        showError('phoneNumber', 'Phone number must contain numbers only.');
      } else {
        validatePhone(false);
      }
    });

    phoneEl.addEventListener('blur', () => validatePhone(true));
  }

  function validateEmail(checkRequired = true) {
    const el = document.getElementById('email');
    if (!el) return true;

    // Auto-convert uppercase input to lowercase
    let val = el.value.trim().toLowerCase();
    if (el.value !== val) {
      el.value = val;
    }

    if (!val) {
      if (checkRequired) {
        showError('email', 'Please enter your university email address.');
        return false;
      }
      return true;
    }

    if (/\s/.test(val)) {
      showError('email', 'Email address cannot contain spaces.');
      return false;
    }

    // Strict @rathinam.in domain check
    const rathinamEmailRegex = /^[a-z0-9._%+-]+@rathinam\.in$/;
    if (!rathinamEmailRegex.test(val)) {
      if (!val.includes('@')) {
        showError('email', 'Email must include "@rathinam.in" (e.g. student@rathinam.in).');
      } else {
        const domain = val.split('@')[1] || '';
        if (domain !== 'rathinam.in') {
          showError('email', 'Only official @rathinam.in university emails are allowed.');
        } else {
          showError('email', 'Please enter a valid university email address.');
        }
      }
      return false;
    }

    // Valid email — clear error styling and text
    el.classList.remove('error');
    el.removeAttribute('aria-invalid');
    document.getElementById('emailError')?.classList.remove('visible');
    return true;
  }

  // Real-time email input handling (auto-lowercase & format check)
  const emailEl = document.getElementById('email');
  if (emailEl) {
    emailEl.addEventListener('input', () => {
      if (emailEl.value !== emailEl.value.toLowerCase()) {
        const start = emailEl.selectionStart;
        emailEl.value = emailEl.value.toLowerCase();
        try { emailEl.setSelectionRange(start, start); } catch (_) {}
      }
      validateEmail(false);
    });

    emailEl.addEventListener('blur', () => validateEmail(true));
  }

  registrationForm?.addEventListener('submit', async e => {
    e.preventDefault();
    clearErrors();

    const val = id => (document.getElementById(id)?.value || '').trim();

    // Anti-Spam Honeypot check (Silent rejection for bots)
    const honeypotVal = val('websiteHp');
    if (honeypotVal) {
      console.warn('Spam bot submission blocked via honeypot.');
      return;
    }

    const name = val('fullName');
    const studentId = val('studentId');
    const department = val('department');
    const phone = val('phoneNumber');
    const email = val('email');
    const interestedInAC = document.querySelector('input[name="acUpgrade"]:checked')?.value || 'No';
    const busNo = val('busNo');
    const pickupLocation = val('pickupLocation');
    const preferredRoute = val('preferredRoute');
    const earlyBirdOffer = (interestedInAC === 'Yes')
      ? (document.querySelector('input[name="earlyBirdOffer"]:checked')?.value || 'Yes')
      : 'No';

    let isValid = true;
    let firstInvalid = null;

    const fail = (field, message) => {
      showError(field, message);
      if (!firstInvalid) firstInvalid = document.getElementById(field);
      isValid = false;
    };

    // 1. Strict Full Name Validation (No numbers allowed)
    if (!validateNoNumbers('fullName', 'Full Name', true)) {
      if (!firstInvalid) firstInvalid = document.getElementById('fullName');
      isValid = false;
    }

    // 2. Strict Student ID Validation
    if (!studentId) {
      fail('studentId', 'Please enter your Student / Roll ID.');
    } else if (studentId.length < 3) {
      fail('studentId', 'Student / Roll ID must be at least 3 characters.');
    } else if (!/^[a-zA-Z0-9\s/-]+$/.test(studentId)) {
      fail('studentId', 'Student / Roll ID can contain only letters and numbers.');
    }

    // 3. Strict Department Validation (No numbers allowed)
    if (!validateNoNumbers('department', 'Department', true)) {
      if (!firstInvalid) firstInvalid = document.getElementById('department');
      isValid = false;
    }

    // 4. Strict Phone Number Validation (10 digits starting with 6-9)
    if (!validatePhone(true)) {
      if (!firstInvalid) firstInvalid = document.getElementById('phoneNumber');
      isValid = false;
    }

    // 5. Strict Email Validation (Lowercase & proper format)
    if (!validateEmail(true)) {
      if (!firstInvalid) firstInvalid = document.getElementById('email');
      isValid = false;
    }

    if (interestedInAC !== 'Yes') {
      showToast('Select "Yes" to the AC Bus upgrade question to register.', 'warning');
      document.querySelector('input[name="acUpgrade"][value="Yes"]')?.focus();
      return;
    }

    if (!preferredRoute) fail('preferredRoute', 'Please select your preferred route.');

    if (!pickupLocation) {
      fail('pickupLocation', preferredRoute ? 'Please select your pickup stop.' : 'Select a route first, then choose your stop.');
    } else if (preferredRoute && !(ROUTES[preferredRoute] || []).includes(pickupLocation)) {
      // Guards against a stale pairing left behind by a mid-edit route change.
      fail('pickupLocation', 'That stop is not on the selected route. Please choose again.');
    }

    if (turnstileRendered()) {
      const cfResponseInput = document.querySelector('[name="cf-turnstile-response"]');
      let apiToken = '';
      try {
        apiToken = (typeof turnstile !== 'undefined' && turnstile.getResponse()) || '';
      } catch (_) { /* widget not ready */ }

      const cfToken = (cfResponseInput && cfResponseInput.value) || turnstileToken || apiToken;

      if (!cfToken) {
        showError('turnstile', 'Please complete the security verification.');
        showToast('Please complete the security verification.', 'warning');
        if (!firstInvalid) firstInvalid = document.querySelector('.cf-turnstile');
        isValid = false;
      }
    } else if (document.querySelector('.cf-turnstile')) {
      console.warn('Turnstile did not render — check that this hostname is listed in the widget\'s allowed domains. Falling back to server-side checks.');
    }

    if (!isValid) {
      firstInvalid?.focus();
      firstInvalid?.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'center' });
      return;
    }

    // Duplicate check via localStorage
    let submittedIds = [];
    try {
      const stored = JSON.parse(localStorage.getItem('rathinam_ac_bus_submissions') || '[]');
      // Guard the shape too: valid JSON that is not an array would throw on .includes()
      // and take the whole submit handler down.
      if (Array.isArray(stored)) submittedIds = stored;
    } catch (_) { /* corrupted entry — start fresh */ }

    if (submittedIds.includes(studentId)) {
      showError('studentId', 'A registration for this Student ID has already been submitted.');
      showToast('Registration already submitted for Student ID: ' + studentId, 'warning');
      document.getElementById('studentId')?.focus();
      return;
    }

    setLoading(true);

    const timestamp = new Date().toLocaleString('en-IN', {
      timeZone: 'Asia/Kolkata'
    });

    const formData = {
      name, studentId, department, phone, email,
      interestedInAC, busNo, pickupLocation, preferredRoute, earlyBirdOffer,
      timestamp
    };

    const remember = () => {
      submittedIds.push(studentId);
      try {
        localStorage.setItem('rathinam_ac_bus_submissions', JSON.stringify(submittedIds));
      } catch (_) { /* storage full or blocked — non-fatal */ }
    };

    const urlParams = new URLSearchParams();
    for (const key in formData) {
      if (formData[key] !== undefined && formData[key] !== null) {
        urlParams.append(key, formData[key]);
      }
    }

    // Pass the honeypot and CAPTCHA token through for server-side checking.
    urlParams.append('website_hp', document.getElementById('websiteHp')?.value || '');

    const cfToken = document.querySelector('[name="cf-turnstile-response"]')?.value || turnstileToken || '';
    if (cfToken) urlParams.append('cf-turnstile-response', cfToken);

    let result = null;
    let httpStatus = 0;

    try {
      const res = await postRegistration(urlParams.toString());

      httpStatus = res.status;
      // A PHP fatal or a missing file returns HTML, not JSON — tolerate that.
      result = await res.json().catch(() => null);

      if (!res.ok || !result || result.ok !== true) {
        throw new Error((result && result.message) || ('Server responded ' + res.status));
      }
    } catch (err) {
      console.error('Registration submission failed:', err);
      setLoading(false);

      if (result && result.code === 'duplicate') {
        showError('studentId', 'This Student ID or email is already registered.');
        showToast(result.message, 'warning', 9000);
        remember();
        document.getElementById('studentId')?.focus();
        return;
      }

      // Tell the visitor which of these it is — "try again" is useless advice
      // when the cause is a missing file on the server.
      let message;

      if (!navigator.onLine) {
        message = 'You appear to be offline. Reconnect and submit again — your details are still here.';
      } else if (httpStatus === 404) {
        console.error('Endpoint not found. Upload submit.php and submit/index.php next to index.php.');
        message = 'Registration service is unavailable. Please contact the transport office.';
      } else if (httpStatus === 0) {
        // Nothing answered at all: the request never produced an HTTP response.
        // Usually the host blocking the endpoint URL, or a blocked/offline network.
        console.error(
          'No endpoint answered. Tried: ' + SUBMIT_ENDPOINTS.join(', ') +
          ' — check the files are uploaded and that the host is not blocking the URL.'
        );
        message = 'We could not reach the registration service. Please try again, or contact the transport office.';
      } else if (result && result.message) {
        message = result.message;
      } else if (httpStatus >= 500) {
        message = 'The registration service is having trouble. Please try again in a moment.';
      } else {
        message = 'We could not save your registration. Please check your connection and try again.';
      }

      showToast(message, 'error', 9000);
      resetTurnstile();
      return; // leave the form on screen so the details are not lost
    }

    // Only now is the row genuinely written — record the duplicate guard.
    remember();
    setTimeout(() => showSuccess(interestedInAC === 'Yes'), 400);
  });

  /* Feedback form + star rating */
  const feedbackForm = document.getElementById('feedbackForm');
  const starRating = document.getElementById('starRating');
  const ratingValueInput = document.getElementById('ratingValue');
  const ratingCaption = document.getElementById('ratingCaption');

  const RATING_LABELS = ['Not important', 'Slightly important', 'Moderately important', 'Very important', 'Extremely important'];

  if (starRating) {
    const stars = [...starRating.querySelectorAll('.star')];

    // Paints stars up to `n`; `commit` also writes the value (hover only previews).
    function paint(n, commit) {
      stars.forEach((s, i) => {
        s.classList.toggle('active', i < n);
        if (commit) s.setAttribute('aria-checked', String(i + 1 === n));
      });
      if (ratingCaption) ratingCaption.textContent = RATING_LABELS[n - 1] || '';
      if (commit && ratingValueInput) ratingValueInput.value = n;
    }

    const current = () => parseInt(ratingValueInput?.value || '5', 10);

    stars.forEach((star, i) => {
      star.addEventListener('click', () => paint(i + 1, true));
      star.addEventListener('mouseenter', () => paint(i + 1, false));
      star.addEventListener('focus', () => paint(i + 1, false));
    });

    starRating.addEventListener('mouseleave', () => paint(current(), false));
    starRating.addEventListener('focusout', () => paint(current(), false));

    // The markup ships with a default of 5 — reflect that in the UI on load.
    paint(current(), true);

    feedbackForm?.addEventListener('submit', e => {
      e.preventDefault();

      const btn = feedbackForm.querySelector('.btn-primary');
      btn.disabled = true;

      showToast('Thanks! Your feedback helps us plan the routes.', 'success', 5000);

      feedbackForm.reset();
      paint(5, true);

      // Brief lock-out so a double-click cannot fire two confirmations.
      setTimeout(() => { btn.disabled = false; }, 1200);
    });
  }

  /* FAQ accordion — animates to the real content height */
  const faqItems = [...document.querySelectorAll('.faq-item')];

  function setFaq(item, open) {
    const btn = item.querySelector('.faq-question');
    const panel = item.querySelector('.faq-answer');
    const inner = item.querySelector('.faq-answer-inner');

    item.classList.toggle('active', open);
    btn.setAttribute('aria-expanded', String(open));
    panel.style.height = open ? inner.scrollHeight + 'px' : '0px';
  }

  faqItems.forEach(item => {
    const btn = item.querySelector('.faq-question');
    setFaq(item, item.classList.contains('active'));

    btn.addEventListener('click', () => {
      const willOpen = !item.classList.contains('active');
      faqItems.forEach(i => setFaq(i, false));
      if (willOpen) setFaq(item, true);
    });
  });

  // Reflow open panels when text rewraps at a new width.
  window.addEventListener('resize', () => {
    faqItems.forEach(item => {
      if (!item.classList.contains('active')) return;
      item.querySelector('.faq-answer').style.height =
        item.querySelector('.faq-answer-inner').scrollHeight + 'px';
    });
  });

  /* Stat counters + timeline + seat meter (triggered on scroll) */
  function animateCounter(el) {
    const target = parseInt(el.dataset.target || '0', 10);
    const suffix = el.dataset.suffix || '';

    if (reduceMotion) {
      el.textContent = target + suffix;
      return;
    }

    const duration = 1800;
    const start = performance.now();

    function step(now) {
      const p = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - p, 3); // ease-out cubic
      el.textContent = Math.round(target * eased) + suffix;
      if (p < 1) requestAnimationFrame(step);
    }

    requestAnimationFrame(step);
  }

  const once = new WeakSet();

  const sectionObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting || once.has(entry.target)) return;
      once.add(entry.target);

      if (entry.target.classList.contains('stats-section')) {
        entry.target.querySelectorAll('.stat-number').forEach(animateCounter);
      }

      if (entry.target.classList.contains('timeline-section')) {
        const line = document.getElementById('timelineProgressLine');
        if (line) line.style.width = '100%';
      }

      if (entry.target.classList.contains('earlybird-section')) {
        const fill = document.getElementById('seatMeterFill');
        const count = document.getElementById('seatCount');
        if (fill) {
          const pct = parseInt(fill.dataset.fill || '0', 10);
          fill.style.width = pct + '%';
          if (count) {
            const seats = Math.round((pct / 100) * 300);
            count.textContent = seats + ' / 300';
          }
        }
      }
    });
  }, { threshold: 0.25 });

  ['.stats-section', '.timeline-section', '.earlybird-section'].forEach(sel => {
    const el = document.querySelector(sel);
    if (el) sectionObserver.observe(el);
  });

  /* Early Bird countdown */
  (function initCountdown() {
    const els = {
      days: document.getElementById('countDays'),
      hours: document.getElementById('countHours'),
      mins: document.getElementById('countMins'),
      secs: document.getElementById('countSecs')
    };

    if (!els.days) return;

    // Offer window ends 14 days out; persisted so the deadline doesn't reset on reload.
    const KEY = 'rathinam_ac_bus_deadline';
    let target = parseInt(localStorage.getItem(KEY) || '0', 10);

    if (!target || target < Date.now()) {
      target = Date.now() + 14 * 24 * 60 * 60 * 1000;
      try { localStorage.setItem(KEY, String(target)); } catch (_) { /* non-fatal */ }
    }

    const pad = n => String(n).padStart(2, '0');

    function tick() {
      const diff = Math.max(target - Date.now(), 0);
      els.days.textContent = pad(Math.floor(diff / 86400000));
      els.hours.textContent = pad(Math.floor(diff / 3600000) % 24);
      els.mins.textContent = pad(Math.floor(diff / 60000) % 60);
      els.secs.textContent = pad(Math.floor(diff / 1000) % 60);
      if (diff === 0) clearInterval(timer);
    }

    tick();
    const timer = setInterval(tick, 1000);
  })();
});
