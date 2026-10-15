document.addEventListener("DOMContentLoaded", () => {
  // 1. Initialize State
  const searchInput = document.getElementById("programme-search");
  let cardWrappers = document.querySelectorAll(".card-wrapper");
  let cards = document.querySelectorAll(".category-card");

  const detailsSection = document.getElementById("course-details-section");
  const detailPanels = document.querySelectorAll(".course-detail-panel");

  const showCourseDetails = (category) => {
    detailPanels.forEach((panel) => {
      panel.classList.toggle("visible", panel.dataset.category === category);
    });

    if (detailsSection) {
      detailsSection.classList.add("visible");
      setTimeout(() => {
        detailsSection.scrollIntoView({ behavior: "smooth", block: "start" });
      }, 300);
    }
  };

  // 2. Search Functionality
  const handleSearch = (e) => {
    const query = e.target.value.toLowerCase().trim();

    // Normalized query (remove dots and collapse spaces) to match abbreviations like B.Sc, bsc, B.SC
    const normalize = (s) =>
      s.replace(/\./g, "").replace(/\s+/g, " ").toLowerCase();
    const normalizedQuery = normalize(query);

    cardWrappers.forEach((wrapper) => {
      const title = wrapper.querySelector(".card-title").textContent;
      const titleLower = title.toLowerCase();
      const titleNorm = normalize(title);

      const chips = Array.from(wrapper.querySelectorAll(".chip")).map(
        (chip) => chip.textContent,
      );
      const chipsLower = chips.map((c) => c.toLowerCase());
      const chipsNorm = chips.map((c) => normalize(c));

      // Also check the related course detail panel's content for matches
      const category = wrapper.getAttribute("data-category");
      const detailPanel = document.querySelector(
        `.course-detail-panel[data-category="${category}"]`,
      );
      const detailText = detailPanel
        ? detailPanel.textContent.toLowerCase()
        : "";

      const isMatch =
        // direct case-insensitive matches
        titleLower.includes(query) ||
        chipsLower.some((chip) => chip.includes(query)) ||
        (query !== "" && detailText.includes(query)) ||
        // normalized abbreviation matches (handles b.sc, B.Sc, bsc)
        (normalizedQuery !== "" &&
          (titleNorm.includes(normalizedQuery) ||
            chipsNorm.some((chip) => chip.includes(normalizedQuery)) ||
            detailText
              .replace(/\./g, "")
              .toLowerCase()
              .includes(normalizedQuery)));

      if (query === "") {
        wrapper.classList.remove("filtered-out", "filtered-in");
      } else if (isMatch) {
        wrapper.classList.remove("filtered-out");
        wrapper.classList.add("filtered-in");
      } else {
        wrapper.classList.remove("filtered-in");
        wrapper.classList.add("filtered-out");
      }
    });
  };

  // Debounced search for performance
  const debounce = (func, wait) => {
    let timeout;
    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => func.apply(this, args), wait);
    };
  };

  searchInput.addEventListener("input", debounce(handleSearch, 150));

  // 3. Card Click Logic (Show Course Details)
  cards.forEach((card) => {
    card.addEventListener("click", (e) => {
      const wrapper = card.closest(".card-wrapper");
      const category = wrapper.getAttribute("data-category");

      // Toggle active state for visuals
      cardWrappers.forEach((w) => w.classList.remove("active-card"));
      wrapper.classList.add("active-card");

      showCourseDetails(category);
    });
  });

  // 4. Magnetic Hover Effect (Subtle)
  cardWrappers.forEach((wrapper) => {
    wrapper.addEventListener("mousemove", (e) => {
      if (window.innerWidth < 1200) return; // Disable on non-asymmetric layout

      const card = wrapper.querySelector(".category-card");
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left - rect.width / 2;
      const y = e.clientY - rect.top - rect.height / 2;

      // Move card slightly towards mouse
      card.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px) scale(1.02)`;
    });

    wrapper.addEventListener("mouseleave", () => {
      const card = wrapper.querySelector(".category-card");
      card.style.transform = "";
    });
  });

  // 5. Entrance Animations
  cardWrappers.forEach((wrapper, index) => {
    wrapper.style.opacity = "0";
    wrapper.style.transform = "translateY(30px) scale(0.9)";

    setTimeout(() => {
      wrapper.style.transition =
        "opacity 0.8s ease, transform 0.8s cubic-bezier(0.34, 1.56, 0.64, 1)";
      wrapper.style.opacity = "1";
      wrapper.style.transform = "translateY(0) scale(1)";
    }, 100 * index);
  });

  // 6. Keyboard Accessibility
  cards.forEach((card) => {
    card.setAttribute("tabindex", "0");
    card.setAttribute("role", "button");
    card.setAttribute("aria-expanded", "false");

    card.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        card.click();
      }
    });
  });

  // Sync active state (simplified)
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.attributeName === "class") {
        const wrapper = mutation.target;
        const card = wrapper.querySelector(".category-card");
        const isActive = wrapper.classList.contains("active-card");
        card.setAttribute("aria-pressed", isActive);
      }
    });
  });

  cardWrappers.forEach((wrapper) => {
    observer.observe(wrapper, { attributes: true });
  });

  // 7. Vertical tabs for Campus Events
  const tabLinks = document.querySelectorAll(".tab-link");
  const tabPanels = document.querySelectorAll(".tab-panel");

  const showTab = (targetId) => {
    tabPanels.forEach((panel) => {
      if (panel.classList.contains(targetId)) {
        panel.classList.remove("hidden");
      } else {
        panel.classList.add("hidden");
      }
    });

    tabLinks.forEach((link) => {
      link.classList.toggle("opacity-60", link.dataset.target !== targetId);
    });
  };

  tabLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const target = link.dataset.target;
      if (!target) return;
      showTab(target);
    });

    link.addEventListener("keydown", (e) => {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        link.click();
      }
    });
  });

  // Ensure default active tab is visible
  if (document.querySelector(".tab-panel.cultural-fiesta-content")) {
    showTab("cultural-fiesta-content");
  }

  // 8. YouTube slider: smooth autoplay + drag + dots
  const sliders = document.querySelectorAll(".youtube-slider");

  sliders.forEach((slider) => {
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let animationId = null;
    let paused = false;

    const speed = 1.5;

    // =========================
    // DRAG SCROLL
    // =========================
    slider.addEventListener("pointerdown", (e) => {
      isDown = true;
      startX = e.pageX;
      scrollLeft = slider.scrollLeft;

      slider.classList.add("dragging");

      cancelAnimationFrame(animationId);
    });

    slider.addEventListener("pointermove", (e) => {
      if (!isDown) return;

      e.preventDefault();

      const walk = (e.pageX - startX) * 1.5;
      slider.scrollLeft = scrollLeft - walk;
    });

    const stopDragging = () => {
      isDown = false;
      slider.classList.remove("dragging");

      autoScroll();
    };

    slider.addEventListener("pointerup", stopDragging);
    slider.addEventListener("pointerleave", stopDragging);
    slider.addEventListener("pointercancel", stopDragging);

    // =========================
    // PAUSE ON HOVER
    // =========================
    slider.addEventListener("mouseenter", () => {
      paused = true;
    });

    slider.addEventListener("mouseleave", () => {
      paused = false;
    });

    // =========================
    // PAGINATION DOTS
    // =========================
    const slides = [...slider.querySelectorAll(".slide")];

    const dotsWrap = document.createElement("div");
    dotsWrap.className = "slider-dots flex justify-center gap-2 mt-5";

    slides.forEach((slide, index) => {
      const dot = document.createElement("button");

      dot.className =
        "dot w-3 h-3 rounded-full bg-gray-300 transition-all duration-300";

      dot.setAttribute("aria-label", `Go to slide ${index + 1}`);

      dot.addEventListener("click", () => {
        slider.scrollTo({
          left: slide.offsetLeft,
          behavior: "smooth",
        });
      });

      dotsWrap.appendChild(dot);
    });

    slider.parentElement.appendChild(dotsWrap);

    // =========================
    // ACTIVE DOT
    // =========================
    const updateActiveDot = () => {
      const sliderCenter = slider.scrollLeft + slider.clientWidth / 2;

      let activeIndex = 0;
      let minDistance = Infinity;

      slides.forEach((slide, index) => {
        const slideCenter = slide.offsetLeft + slide.offsetWidth / 2;

        const distance = Math.abs(slideCenter - sliderCenter);

        if (distance < minDistance) {
          minDistance = distance;
          activeIndex = index;
        }
      });

      [...dotsWrap.children].forEach((dot, index) => {
        dot.classList.toggle("bg-black", index === activeIndex);
        dot.classList.toggle("w-8", index === activeIndex);

        dot.classList.toggle("bg-gray-300", index !== activeIndex);
      });
    };

    // =========================
    // AUTO SCROLL
    // =========================
    const autoScroll = () => {
      const scrollStep = () => {
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        if (!paused && !isDown && maxScroll > 1) {
          slider.scrollLeft += speed;

          if (slider.scrollLeft >= maxScroll) {
            slider.scrollLeft = 0;
          }

          updateActiveDot();
        }

        animationId = requestAnimationFrame(scrollStep);
      };

      animationId = requestAnimationFrame(scrollStep);
    };

    updateActiveDot();
    autoScroll();
  });
});
