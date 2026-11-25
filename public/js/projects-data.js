(() => {
  const STORAGE_KEY = "dikky_portfolio_projects";
  const AUTH_KEY = "dikky_portfolio_auth";

  const DEFAULT_PROJECTS = [
    {
      id: "p1",
      slug: "voltgear-ev-tracking",
      title: "Voltgear EV Tracking Mobile App",
      category: "Mobile App · Product Design",
      client: "Voltgear",
      year: "2025",
      cover: "https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=1600&h=900&fit=crop",
      summary:
        "An EV tracking experience that helps riders monitor battery, routes, and vehicle health in real time.",
      description:
        "Voltgear needed a mobile product that felt as sharp as their hardware. I led product design from research to high-fidelity UI, focusing on glanceable battery data, trip history, and a calm dark interface built for night rides.\n\nThe result is a tracking app with clear hierarchy, fast status checks, and a case-study ready visual system that scales across iOS and Android.",
      tags: ["UI/UX", "Mobile", "Product Design"],
      gallery: [
        "https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=1200&h=800&fit=crop",
        "https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=1200&h=800&fit=crop",
        "https://images.unsplash.com/photo-1551650975-87deedd944c3?w=1200&h=800&fit=crop",
      ],
      featured: true,
    },
    {
      id: "p2",
      slug: "finora-analytics",
      title: "Finora Analytics",
      category: "Dashboard · SaaS",
      client: "Finora",
      year: "2024",
      cover: "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=900&h=700&fit=crop",
      summary:
        "A SaaS analytics dashboard that turns dense financial data into decisions founders can act on.",
      description:
        "Finora's previous dashboard was packed but hard to scan. I redesigned information architecture, charts, and filters so revenue, churn, and cohort insights feel immediate.\n\nThe interface uses a quiet layout with strong typography and progressive disclosure — power users get depth without overwhelming first-time visitors.",
      tags: ["Dashboard", "SaaS", "Web"],
      gallery: [
        "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&h=800&fit=crop",
        "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&h=800&fit=crop",
        "https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1000&h=700&fit=crop&q=80",
      ],
      featured: false,
    },
    {
      id: "p3",
      slug: "nord-commerce",
      title: "Nord Commerce",
      category: "Branding · E-commerce",
      client: "Nord",
      year: "2024",
      cover: "https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=900&h=700&fit=crop",
      summary:
        "Brand and storefront design for a modern commerce brand with a clean northern aesthetic.",
      description:
        "Nord wanted an e-commerce presence that felt premium without becoming cold. I shaped the visual identity, product pages, and shopping flow around spacious layouts, soft contrast, and confident product photography.\n\nConversion-focused details — sticky buy actions, clearer variants, and trust blocks — shipped alongside the brand system.",
      tags: ["Branding", "E-commerce", "Web"],
      gallery: [
        "https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&h=800&fit=crop",
        "https://images.unsplash.com/photo-1445205170230-053b83016050?w=1200&h=800&fit=crop",
        "https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1000&h=700&fit=crop&q=60",
      ],
      featured: false,
    },
  ];

  function readProjects() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(DEFAULT_PROJECTS));
        return structuredClone(DEFAULT_PROJECTS);
      }
      const parsed = JSON.parse(raw);
      return Array.isArray(parsed) ? parsed : structuredClone(DEFAULT_PROJECTS);
    } catch {
      return structuredClone(DEFAULT_PROJECTS);
    }
  }

  function writeProjects(projects) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(projects));
  }

  function slugify(text) {
    return String(text || "")
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9]+/g, "-")
      .replace(/(^-|-$)/g, "");
  }

  function uid() {
    return `p${Date.now().toString(36)}`;
  }

  window.DikkyStore = {
    getProjects: readProjects,
    saveProjects: writeProjects,
    getBySlug(slug) {
      return readProjects().find((p) => p.slug === slug) || null;
    },
    getById(id) {
      return readProjects().find((p) => p.id === id) || null;
    },
    upsert(project) {
      const list = readProjects();
      const idx = list.findIndex((p) => p.id === project.id);
      if (idx >= 0) list[idx] = project;
      else list.unshift(project);
      writeProjects(list);
      return project;
    },
    remove(id) {
      writeProjects(readProjects().filter((p) => p.id !== id));
    },
    slugify,
    uid,
    reset() {
      writeProjects(structuredClone(DEFAULT_PROJECTS));
    },
    isLoggedIn() {
      return localStorage.getItem(AUTH_KEY) === "1";
    },
    login(username, password) {
      if (username === "admin" && password === "admin123") {
        localStorage.setItem(AUTH_KEY, "1");
        localStorage.setItem("dikky_portfolio_user", "Dikky Admin");
        return true;
      }
      return false;
    },
    logout() {
      localStorage.removeItem(AUTH_KEY);
    },
    currentUser() {
      return localStorage.getItem("dikky_portfolio_user") || "Admin";
    },
    requireAuth(redirectTo = "login.html") {
      if (!this.isLoggedIn()) {
        window.location.href = redirectTo;
        return false;
      }
      return true;
    },
  };
})();
