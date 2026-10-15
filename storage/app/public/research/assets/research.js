/* RGU — Research Portal • Shared behaviour */
(function () {
  "use strict";

  /* ---- Lucide icons ---- */
  function icons() { if (window.lucide && window.lucide.createIcons) window.lucide.createIcons(); }

  /* ---- Mobile nav toggle ---- */
  function mobileNav() {
    var btn = document.getElementById("r-mob-btn");
    var menu = document.getElementById("r-mob-menu");
    if (!btn || !menu) return;
    btn.addEventListener("click", function () { menu.classList.toggle("hidden"); });
    // mobile dropdown accordion
    document.querySelectorAll("[data-r-acc]").forEach(function (t) {
      t.addEventListener("click", function () {
        var p = document.getElementById(t.getAttribute("data-r-acc"));
        if (p) p.classList.toggle("hidden");
        t.querySelector("[data-r-caret]") && t.querySelector("[data-r-caret]").classList.toggle("rotate-180");
      });
    });
  }

  /* ---- Sticky nav shadow ---- */
  function navShadow() {
    var nav = document.querySelector(".r-nav");
    if (!nav) return;
    var onScroll = function () {
      if (window.scrollY > 8) nav.classList.add("shadow-lg", "bg-white/95");
      else nav.classList.remove("shadow-lg", "bg-white/95");
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  /* ---- Scroll reveal ---- */
  function reveal() {
    var els = document.querySelectorAll(".r-reveal");
    if (!("IntersectionObserver" in window) || !els.length) {
      els.forEach(function (e) { e.classList.add("is-in"); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { en.target.classList.add("is-in"); io.unobserve(en.target); }
      });
    }, { threshold: 0.12 });
    els.forEach(function (e) { io.observe(e); });
  }

  /* ---- Animated counters ---- */
  function counters() {
    var els = document.querySelectorAll("[data-count]");
    if (!els.length) return;
    var run = function (el) {
      var target = parseFloat(el.getAttribute("data-count"));
      var dec = parseInt(el.getAttribute("data-dec") || "0", 10);
      var prefix = el.getAttribute("data-prefix") || "";
      var suffix = el.getAttribute("data-suffix") || "";
      var dur = 1500, start = null;
      var step = function (ts) {
        if (!start) start = ts;
        var p = Math.min((ts - start) / dur, 1);
        var eased = 1 - Math.pow(1 - p, 3);
        var val = target * eased;
        el.textContent = prefix + val.toLocaleString("en-IN", { minimumFractionDigits: dec, maximumFractionDigits: dec }) + suffix;
        if (p < 1) requestAnimationFrame(step);
        else el.textContent = prefix + target.toLocaleString("en-IN", { minimumFractionDigits: dec, maximumFractionDigits: dec }) + suffix;
      };
      requestAnimationFrame(step);
    };
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (en.isIntersecting) { run(en.target); io.unobserve(en.target); }
      });
    }, { threshold: 0.4 });
    els.forEach(function (e) { io.observe(e); });
  }

  /* ---- CSS bar charts: grow on view ---- */
  function bars() {
    var groups = document.querySelectorAll("[data-bars]");
    if (!groups.length) return;
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (en) {
        if (!en.isIntersecting) return;
        var max = parseFloat(en.target.getAttribute("data-max")) || 1;
        en.target.querySelectorAll(".r-bar").forEach(function (b) {
          var v = parseFloat(b.getAttribute("data-v")) || 0;
          b.style.height = Math.max((v / max) * 100, v > 0 ? 2 : 0) + "%";
        });
        io.unobserve(en.target);
      });
    }, { threshold: 0.3 });
    groups.forEach(function (g) { io.observe(g); });
  }

  /* ---- Data table live search ---- */
  function tableSearch() {
    var input = document.getElementById("r-table-search");
    if (!input) return;
    var table = document.querySelector("table.r-table");
    var empty = document.getElementById("r-no-results");
    var countOut = document.getElementById("r-result-count");
    var rows = Array.prototype.slice.call(table.querySelectorAll("tbody tr"));
    var debounce;
    input.addEventListener("input", function () {
      clearTimeout(debounce);
      debounce = setTimeout(function () {
        var q = input.value.trim().toLowerCase();
        var shown = 0;
        var groupVisible = {};
        // first pass: data rows
        rows.forEach(function (tr) {
          if (tr.classList.contains("r-group-row")) return;
          var match = !q || tr.textContent.toLowerCase().indexOf(q) !== -1;
          tr.style.display = match ? "" : "none";
          if (match && !tr.classList.contains("r-total-row")) {
            shown++;
            var g = tr.getAttribute("data-group");
            if (g) groupVisible[g] = true;
          }
        });
        // second pass: group header rows hide if no children visible
        rows.forEach(function (tr) {
          if (!tr.classList.contains("r-group-row")) return;
          var g = tr.getAttribute("data-group");
          tr.style.display = (!q || groupVisible[g]) ? "" : "none";
        });
        if (countOut) countOut.textContent = shown.toLocaleString("en-IN");
        if (empty) empty.style.display = shown === 0 ? "block" : "none";
      }, 120);
    });
  }

  /* ---- Back to top ---- */
  function backTop() {
    var b = document.getElementById("r-top");
    if (!b) return;
    window.addEventListener("scroll", function () {
      if (window.scrollY > 600) b.classList.add("show"); else b.classList.remove("show");
    }, { passive: true });
    b.addEventListener("click", function () { window.scrollTo({ top: 0, behavior: "smooth" }); });
  }

  /* ---- Popup modal ---- */
  function popupModal() {
    var modal = document.getElementById("r-popup-modal");
    var secondModal = document.getElementById("r-popup-modal-2");
    if (!modal && !secondModal) return;

    function showModal(modalEl) {
      if (!modalEl) return;
      modalEl.classList.remove("hidden");
      modalEl.classList.add("flex");
    }

    function hideModal(modalEl) {
      if (!modalEl) return;
      modalEl.classList.add("hidden");
      modalEl.classList.remove("flex");
    }

    function closeFirstModal() {
      if (modal) {
        hideModal(modal);
      }
      if (secondModal) {
        setTimeout(function () {
          showModal(secondModal);
        }, 150);
      }
    }

    if (modal) {
      var image = modal.querySelector(".r-popup-image");
      if (image) {
        image.loading = "eager";
        image.decoding = "async";
        image.addEventListener("error", function () {
          hideModal(modal);
        });
      }

      var closeButton = document.getElementById("r-popup-close");
      if (closeButton) closeButton.addEventListener("click", closeFirstModal);

      modal.addEventListener("click", function (event) {
        if (event.target === modal) closeFirstModal();
      });

      showModal(modal);
    }

    if (secondModal) {
      var secondCloseButton = document.getElementById("r-popup-close-2");
      if (secondCloseButton) {
        secondCloseButton.addEventListener("click", function () {
          hideModal(secondModal);
        });
      }

      secondModal.addEventListener("click", function (event) {
        if (event.target === secondModal) hideModal(secondModal);
      });

      if (!modal) {
        showModal(secondModal);
      }
    }

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        if (secondModal && !secondModal.classList.contains("hidden")) {
          hideModal(secondModal);
        } else if (modal && !modal.classList.contains("hidden")) {
          hideModal(modal);
        }
      }
    });
  }

  document.addEventListener("DOMContentLoaded", function () {
    icons(); mobileNav(); navShadow(); reveal(); counters(); bars(); tableSearch(); backTop(); popupModal();
  });
})();
