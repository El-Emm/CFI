/**
 * Charity Faith International — Main JavaScript
 * WordPress migration: enqueue as cfi-main.js
 */
(function () {
  'use strict';

  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

  /* Header scroll + mobile nav */
  function initHeader() {
    const header = $('.cfi-header');
    const toggle = $('.cfi-menu-toggle');
    const mobileNav = $('.cfi-mobile-nav');
    if (!header) return;

    window.addEventListener('scroll', () => {
      header.classList.toggle('is-scrolled', window.scrollY > 20);
    }, { passive: true });

    if (toggle && mobileNav) {
      toggle.addEventListener('click', () => {
        const open = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!open));
        mobileNav.classList.toggle('is-open', !open);
        mobileNav.hidden = open;
        document.body.style.overflow = open ? '' : 'hidden';
      });

      $$('.cfi-mobile-nav__link', mobileNav).forEach((link) => {
        link.addEventListener('click', () => {
          toggle.setAttribute('aria-expanded', 'false');
          mobileNav.classList.remove('is-open');
          mobileNav.hidden = true;
          document.body.style.overflow = '';
        });
      });
    }
  }

  /* Hero slideshow */
  function initHero() {
    const slides = $$('.cfi-hero__slide');
    const dots = $$('.cfi-hero__dot');
    if (!slides.length) return;

    let current = 0;
    let timer;

    function goTo(index) {
      current = (index + slides.length) % slides.length;
      slides.forEach((s, i) => s.classList.toggle('is-active', i === current));
      dots.forEach((d, i) => {
        d.classList.toggle('is-active', i === current);
        d.setAttribute('aria-selected', i === current ? 'true' : 'false');
      });
    }

    function next() { goTo(current + 1); }

    function startAutoplay() {
      clearInterval(timer);
      timer = setInterval(next, 6000);
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        goTo(i);
        startAutoplay();
      });
    });

    goTo(0);
    startAutoplay();
  }

  /* Impact counters — data-target editable via WP */
  function initCounters() {
    const stats = $$('.cfi-stat__number[data-target]');
    if (!stats.length) return;

    const animate = (el) => {
      const target = parseInt(el.dataset.target, 10) || 0;
      const suffix = el.dataset.suffix || '';
      const duration = 2000;
      const start = performance.now();

      const step = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = Math.floor(eased * target);
        el.innerHTML = value.toLocaleString() + (suffix ? `<span class="cfi-stat__suffix">${suffix}</span>` : '');
        if (progress < 1) requestAnimationFrame(step);
      };

      requestAnimationFrame(step);
    };

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !entry.target.dataset.animated) {
            entry.target.dataset.animated = 'true';
            animate(entry.target);
          }
        });
      },
      { threshold: 0.3 }
    );

    stats.forEach((s) => observer.observe(s));
  }

  /* Global impact map — loads world SVG with markers, countries from site-data.js */
  function bindMapInteractions(mapWrap) {
    const storyEl = $('.cfi-map-story__content');
    const site = window.CFI_SITE;
    const wrap = mapWrap || $('.cfi-map-wrap[data-map-src]');
    if (!storyEl || !site || !wrap) return;

    const galleryBase = (window.cfiTheme && window.cfiTheme.galleryUrl)
      ? window.cfiTheme.galleryUrl
      : (window.location.pathname.includes('/pages/') ? 'gallery.html' : 'pages/gallery.html');

    const svg = wrap.querySelector('svg');

    function getMarkers() {
      return $$('[data-country]', wrap).filter((el) =>
        el.classList.contains('cfi-map-marker') || el.classList.contains('cfi-map-country')
      );
    }

    function markerKey(el) {
      return el && el.getAttribute('data-country');
    }

    function markerPoint(marker) {
      const x = parseFloat(marker.getAttribute('data-map-x'));
      const y = parseFloat(marker.getAttribute('data-map-y'));
      if (!Number.isNaN(x) && !Number.isNaN(y)) return { x, y };

      const transform = marker.getAttribute('transform') || '';
      const match = transform.match(/translate\(\s*([-\d.]+)(?:[,\s]+([-\d.]+))?\s*\)/);
      if (!match) return null;
      return { x: parseFloat(match[1]), y: parseFloat(match[2] || 0) };
    }

    function showStory(key) {
      if (!key) return;
      const country = site.countries.find((c) => c.id === key);
      const text = site.mapStories[key];
      if (!country || !text) return;

      getMarkers().forEach((m) => m.classList.toggle('is-active', markerKey(m) === key));
      storyEl.innerHTML = `
        <h3 class="cfi-map-story__country">${country.label}</h3>
        <p>${text}</p>
        <a href="${galleryBase}?country=${key}" class="cfi-btn cfi-btn--primary" style="margin-top:1rem">View Gallery</a>
      `;
    }

    function goToCountryGallery(key) {
      if (!key) return;
      window.location.href = `${galleryBase}?country=${encodeURIComponent(key)}`;
    }

    function countryAtPoint(clientX, clientY) {
      if (!svg) return null;

      const ctm = svg.getScreenCTM();
      if (!ctm) return null;

      const pt = svg.createSVGPoint();
      pt.x = clientX;
      pt.y = clientY;
      const svgPt = pt.matrixTransform(ctm.inverse());

      let closestKey = null;
      let closestDist = Infinity;

      getMarkers().forEach((marker) => {
        const point = markerPoint(marker);
        if (!point) return;

        const dist = Math.hypot(svgPt.x - point.x, svgPt.y - point.y);
        const hitRadius = parseFloat(marker.getAttribute('data-hit-r')) || 14;
        if (dist <= hitRadius && dist < closestDist) {
          closestDist = dist;
          closestKey = markerKey(marker);
        }
      });

      return closestKey;
    }

    if (!wrap.hasAttribute('data-map-bound')) {
      wrap.setAttribute('data-map-bound', 'true');

      wrap.addEventListener('click', (e) => {
        const key = countryAtPoint(e.clientX, e.clientY);
        if (!key) return;
        e.preventDefault();
        goToCountryGallery(key);
      });

      wrap.addEventListener('touchend', (e) => {
        const touch = e.changedTouches && e.changedTouches[0];
        if (!touch) return;
        const key = countryAtPoint(touch.clientX, touch.clientY);
        if (!key) return;
        e.preventDefault();
        goToCountryGallery(key);
      }, { passive: false });

      wrap.addEventListener('mousemove', (e) => {
        const key = countryAtPoint(e.clientX, e.clientY);
        getMarkers().forEach((m) => m.classList.toggle('is-hover', markerKey(m) === key));
        wrap.style.cursor = key ? 'pointer' : 'default';
        if (key) showStory(key);
      });

      wrap.addEventListener('mouseleave', () => {
        getMarkers().forEach((m) => m.classList.remove('is-hover'));
        wrap.style.cursor = 'default';
      });

      wrap.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        const marker = e.target.closest('[data-country]');
        if (!marker || !wrap.contains(marker)) return;
        e.preventDefault();
        goToCountryGallery(markerKey(marker));
      });
    }

    if (!getMarkers().length) return;

    showStory('nigeria');
  }

  async function initMap() {
    const wrap = $('.cfi-map-wrap[data-map-src]');
    if (wrap) {
      const src = wrap.dataset.mapSrc;
      wrap.classList.add('is-loading');
      try {
        const res = await fetch(src);
        if (!res.ok) throw new Error('Map failed to load');
        wrap.innerHTML = await res.text();
        wrap.classList.remove('is-loading');
        wrap.removeAttribute('aria-busy');
      } catch {
        wrap.classList.remove('is-loading');
        wrap.removeAttribute('aria-busy');
        wrap.innerHTML = '<p class="cfi-map-story__placeholder">Map unavailable. Use the country links below.</p>';
        return;
      }
    }
    bindMapInteractions(wrap);
  }

  /* Lightbox — shared with dynamic gallery */
  function initLightbox() {
    const lightbox = $('.cfi-lightbox');
    const lightboxContent = $('.cfi-lightbox__content');
    const closeBtn = $('.cfi-lightbox__close');
    if (!lightbox || !lightboxContent) return;

    function openLightbox(el) {
      const type = el.dataset.type || 'image';
      const src = el.dataset.src;
      const alt = el.dataset.alt || '';

      if (type === 'video') {
        lightboxContent.innerHTML = `<video src="${src}" controls playsinline preload="metadata" title="${alt}"></video>`;
      } else {
        lightboxContent.innerHTML = `<img src="${src}" alt="${alt}">`;
      }

      lightbox.classList.add('is-open');
      lightbox.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      closeBtn?.focus();
    }

    function closeLightbox() {
      const video = $('video', lightboxContent);
      if (video) video.pause();
      lightbox.classList.remove('is-open');
      lightbox.setAttribute('aria-hidden', 'true');
      lightboxContent.innerHTML = '';
      document.body.style.overflow = '';
    }

    $$('.cfi-gallery-item').forEach((item) => {
      if (item.dataset.lightboxBound) return;
      item.dataset.lightboxBound = 'true';
      item.addEventListener('click', () => openLightbox(item));
    });

    if (!closeBtn?.dataset.lightboxBound) {
      closeBtn.dataset.lightboxBound = 'true';
      closeBtn.addEventListener('click', closeLightbox);
      lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) closeLightbox();
      });
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
      });
    }
  }

  window.CFI_initLightbox = initLightbox;

  /* Donation fund + amount selection */
  function initDonate() {
    const funds = $$('.cfi-fund-card');
    const amounts = $$('.cfi-amount-btn');
    const form = $('.cfi-donate-form');

    funds.forEach((card) => {
      card.addEventListener('click', () => {
        funds.forEach((c) => c.classList.remove('is-selected'));
        card.classList.add('is-selected');
        const input = $('input', card);
        if (input) input.checked = true;
      });
    });

    amounts.forEach((btn) => {
      btn.addEventListener('click', () => {
        amounts.forEach((b) => b.classList.remove('is-selected'));
        btn.classList.add('is-selected');
        const custom = $('#donate-custom');
        if (custom) custom.value = btn.dataset.amount || '';
      });
    });

    form?.addEventListener('submit', (e) => {
      e.preventDefault();
      const notice = $('.cfi-donate-notice');
      if (notice) {
        notice.hidden = false;
        notice.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
    });
  }

  /* Contact form */
  function initContact() {
    const form = $('.cfi-contact-form');
    form?.addEventListener('submit', (e) => {
      e.preventDefault();
      const success = $('.cfi-form-success');
      if (success) {
        success.hidden = false;
        form.reset();
        success.focus();
      }
    });
  }

  /* Prayer request form (static fallback) */
  function initPrayer() {
    const form = $('.cfi-prayer-form');
    form?.addEventListener('submit', (e) => {
      e.preventDefault();
      const notice = form.parentElement?.querySelector('.cfi-donate-notice');
      if (notice) {
        notice.hidden = false;
        notice.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        form.reset();
      }
    });
  }

  /* Leadership slider */
  function initLeadershipSlider() {
    const slider = $('[data-leadership-slider]');
    if (!slider) return;

    const slides = $$('.cfi-founder-slider__slide', slider);
    const dots = $$('.cfi-founder-slider__dot', slider);
    const prev = $('.cfi-founder-slider__arrow--prev', slider);
    const next = $('.cfi-founder-slider__arrow--next', slider);
    if (!slides.length) return;

    let current = 0;
    let timer;

    function goTo(index) {
      current = (index + slides.length) % slides.length;
      slides.forEach((slide, i) => {
        const active = i === current;
        slide.classList.toggle('is-active', active);
        slide.setAttribute('aria-hidden', active ? 'false' : 'true');
      });
      dots.forEach((dot, i) => {
        dot.classList.toggle('is-active', i === current);
        dot.setAttribute('aria-selected', i === current ? 'true' : 'false');
      });
    }

    function startAutoplay() {
      clearInterval(timer);
      timer = setInterval(() => goTo(current + 1), 8000);
    }

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => {
        goTo(i);
        startAutoplay();
      });
    });

    prev?.addEventListener('click', () => {
      goTo(current - 1);
      startAutoplay();
    });

    next?.addEventListener('click', () => {
      goTo(current + 1);
      startAutoplay();
    });

    goTo(0);
    startAutoplay();
  }

  document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initHero();
    initCounters();
    initMap();
    initLightbox();
    initDonate();
    initContact();
    initPrayer();
    initLeadershipSlider();
  });
})();
