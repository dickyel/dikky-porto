(() => {
  const triggers = [...document.querySelectorAll("[data-lightbox]")];
  if (!triggers.length) return;

  const items = [];
  const indexBySrc = new Map();

  triggers.forEach((el) => {
    const src = el.dataset.lightboxSrc || el.currentSrc || el.src;
    if (!src) return;

    if (!indexBySrc.has(src)) {
      indexBySrc.set(src, items.length);
      items.push({
        src,
        alt: el.getAttribute("alt") || el.getAttribute("aria-label") || "Preview",
      });
    }

    el.dataset.lightboxIndex = String(indexBySrc.get(src));
  });

  const root = document.createElement("div");
  root.className = "lightbox";
  root.hidden = true;
  root.innerHTML = `
    <div class="lightbox-backdrop" data-lightbox-close></div>
    <div class="lightbox-stage" role="dialog" aria-modal="true" aria-label="Image preview">
      <button type="button" class="lightbox-close" data-lightbox-close aria-label="Close">×</button>
      <button type="button" class="lightbox-nav lightbox-prev" aria-label="Previous">‹</button>
      <button type="button" class="lightbox-nav lightbox-next" aria-label="Next">›</button>
      <div class="lightbox-frame">
        <img class="lightbox-image" alt="" draggable="false" />
      </div>
      <div class="lightbox-toolbar">
        <button type="button" class="lightbox-tool" data-zoom-out aria-label="Zoom out">−</button>
        <button type="button" class="lightbox-tool" data-zoom-reset aria-label="Reset zoom">100%</button>
        <button type="button" class="lightbox-tool" data-zoom-in aria-label="Zoom in">+</button>
      </div>
    </div>
  `;
  document.body.appendChild(root);

  const img = root.querySelector(".lightbox-image");
  const frame = root.querySelector(".lightbox-frame");
  const prevBtn = root.querySelector(".lightbox-prev");
  const nextBtn = root.querySelector(".lightbox-next");
  const resetBtn = root.querySelector("[data-zoom-reset]");

  let index = 0;
  let scale = 1;
  let offsetX = 0;
  let offsetY = 0;
  let dragging = false;
  let startX = 0;
  let startY = 0;
  let originX = 0;
  let originY = 0;

  const clampScale = (value) => Math.min(4, Math.max(1, value));

  const applyTransform = () => {
    img.style.transform = `translate(${offsetX}px, ${offsetY}px) scale(${scale})`;
    resetBtn.textContent = `${Math.round(scale * 100)}%`;
    frame.classList.toggle("is-zoomed", scale > 1);
  };

  const resetZoom = () => {
    scale = 1;
    offsetX = 0;
    offsetY = 0;
    applyTransform();
  };

  const show = (i) => {
    index = (i + items.length) % items.length;
    const item = items[index];
    img.src = item.src;
    img.alt = item.alt;
    resetZoom();
    root.hidden = false;
    document.body.classList.add("is-lightbox-open");
    prevBtn.hidden = items.length < 2;
    nextBtn.hidden = items.length < 2;
  };

  const close = () => {
    root.hidden = true;
    document.body.classList.remove("is-lightbox-open");
    img.removeAttribute("src");
    resetZoom();
  };

  triggers.forEach((el) => {
    const open = (event) => {
      event.preventDefault();
      show(Number(el.dataset.lightboxIndex || 0));
    };

    el.addEventListener("click", open);

    if (el.tagName !== "BUTTON") {
      el.addEventListener("keydown", (event) => {
        if (event.key === "Enter" || event.key === " ") open(event);
      });
    }
  });

  root.querySelectorAll("[data-lightbox-close]").forEach((el) => {
    el.addEventListener("click", close);
  });

  prevBtn.addEventListener("click", () => show(index - 1));
  nextBtn.addEventListener("click", () => show(index + 1));

  root.querySelector("[data-zoom-in]").addEventListener("click", () => {
    scale = clampScale(scale + 0.25);
    applyTransform();
  });

  root.querySelector("[data-zoom-out]").addEventListener("click", () => {
    scale = clampScale(scale - 0.25);
    if (scale === 1) {
      offsetX = 0;
      offsetY = 0;
    }
    applyTransform();
  });

  resetBtn.addEventListener("click", resetZoom);

  frame.addEventListener(
    "wheel",
    (event) => {
      if (root.hidden) return;
      event.preventDefault();
      const delta = event.deltaY > 0 ? -0.15 : 0.15;
      scale = clampScale(scale + delta);
      if (scale === 1) {
        offsetX = 0;
        offsetY = 0;
      }
      applyTransform();
    },
    { passive: false }
  );

  img.addEventListener("pointerdown", (event) => {
    if (scale <= 1) return;
    dragging = true;
    startX = event.clientX;
    startY = event.clientY;
    originX = offsetX;
    originY = offsetY;
    img.setPointerCapture(event.pointerId);
  });

  img.addEventListener("pointermove", (event) => {
    if (!dragging) return;
    offsetX = originX + (event.clientX - startX);
    offsetY = originY + (event.clientY - startY);
    applyTransform();
  });

  const endDrag = () => {
    dragging = false;
  };

  img.addEventListener("pointerup", endDrag);
  img.addEventListener("pointercancel", endDrag);

  document.addEventListener("keydown", (event) => {
    if (root.hidden) return;
    if (event.key === "Escape") close();
    if (event.key === "ArrowLeft") show(index - 1);
    if (event.key === "ArrowRight") show(index + 1);
    if (event.key === "+" || event.key === "=") {
      scale = clampScale(scale + 0.25);
      applyTransform();
    }
    if (event.key === "-" || event.key === "_") {
      scale = clampScale(scale - 0.25);
      if (scale === 1) {
        offsetX = 0;
        offsetY = 0;
      }
      applyTransform();
    }
  });
})();
