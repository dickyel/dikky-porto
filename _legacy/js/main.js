(() => {
  const yearEl = document.getElementById("year");
  if (yearEl) yearEl.textContent = String(new Date().getFullYear());

  /* Mobile menu */
  const header = document.querySelector(".site-header");
  const toggle = document.querySelector(".menu-toggle");
  const navLinks = document.querySelectorAll(".nav-link");

  const setMenuOpen = (open) => {
    header?.classList.toggle("is-open", open);
    toggle?.setAttribute("aria-expanded", open ? "true" : "false");
    toggle?.setAttribute("aria-label", open ? "Close menu" : "Open menu");
    document.body.classList.toggle("is-menu-open", open);
  };

  toggle?.addEventListener("click", () => {
    setMenuOpen(!header?.classList.contains("is-open"));
  });

  navLinks.forEach((link) => {
    link.addEventListener("click", () => setMenuOpen(false));
  });

  document.querySelector(".btn-talk")?.addEventListener("click", () => {
    setMenuOpen(false);
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") setMenuOpen(false);
  });

  /* Active nav on scroll */
  const sections = [...document.querySelectorAll("main section[id]")];

  const setActiveNav = () => {
    const y = window.scrollY + 140;
    let current = sections[0]?.id;

    for (const section of sections) {
      if (section.offsetTop <= y) current = section.id;
    }

    navLinks.forEach((link) => {
      const href = link.getAttribute("href")?.slice(1);
      link.classList.toggle("is-active", href === current);
    });
  };

  window.addEventListener("scroll", setActiveNav, { passive: true });
  setActiveNav();

  /* Services accordion — one open at a time */
  const accordion = document.querySelector("[data-accordion]");
  accordion?.querySelectorAll(".service-item").forEach((item) => {
    const trigger = item.querySelector(".service-trigger");
    trigger?.addEventListener("click", () => {
      const isOpen = item.classList.contains("is-open");

      accordion.querySelectorAll(".service-item").forEach((other) => {
        other.classList.remove("is-open");
        other.querySelector(".service-trigger")?.setAttribute("aria-expanded", "false");
      });

      if (!isOpen) {
        item.classList.add("is-open");
        trigger.setAttribute("aria-expanded", "true");
      }
    });
  });

  /* Scroll reveal */
  const reveals = document.querySelectorAll(".reveal");
  if ("IntersectionObserver" in window) {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("is-visible");
            io.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.12, rootMargin: "0px 0px -40px 0px" }
    );

    reveals.forEach((el, i) => {
      el.style.transitionDelay = `${Math.min(i % 4, 3) * 80}ms`;
      io.observe(el);
    });
  } else {
    reveals.forEach((el) => el.classList.add("is-visible"));
  }
})();
