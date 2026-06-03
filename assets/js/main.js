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

  /* Global impact map */
  const mapStories = {
    nigeria: {
      country: 'Nigeria',
      text: 'CFI has conducted multiple crusades, food distributions, and widow empowerment initiatives across Nigerian communities, bringing practical aid and faith-based hope to thousands of families.',
    },
    ghana: {
      country: 'Ghana',
      text: 'Education support and school supplies programs have helped children access quality learning. Healthcare assistance has supported families facing urgent medical needs.',
    },
    kenya: {
      country: 'Kenya',
      text: 'Community development and shelter projects are creating safer environments for vulnerable families while faith outreach strengthens local churches and communities.',
    },
    usa: {
      country: 'United States',
      text: 'As a US-registered nonprofit, CFI coordinates global partnerships, donor engagement, and church collaborations that fuel humanitarian work worldwide.',
    },
    uk: {
      country: 'United Kingdom',
      text: 'Partners and supporters in the UK help expand CFI\'s reach through fundraising, advocacy, and cross-cultural ministry partnerships.',
    },
    india: {
      country: 'India',
      text: 'Food relief and community outreach programs have served families in hardship, combining practical compassion with Christian witness.',
    },
  };

  function initMap() {
    const storyEl = $('.cfi-map-story__content');
    const markers = $$('.cfi-map-marker[data-country]');
    if (!storyEl || !markers.length) return;

    function showStory(key) {
      const data = mapStories[key];
      if (!data) return;
      markers.forEach((m) => m.classList.toggle('is-active', m.dataset.country === key));
      storyEl.innerHTML = `
        <h3 class="cfi-map-story__country">${data.country}</h3>
        <p>${data.text}</p>
        <a href="pages/gallery.html" class="cfi-btn cfi-btn--primary" style="margin-top:1rem">View Impact Photos</a>
      `;
    }

    markers.forEach((m) => {
      m.addEventListener('click', () => showStory(m.dataset.country));
      m.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          showStory(m.dataset.country);
        }
      });
    });

    showStory('nigeria');
  }

  /* Gallery filters + lightbox */
  function initGallery() {
    const filters = $$('.cfi-filter-btn');
    const items = $$('.cfi-gallery-item');
    const lightbox = $('.cfi-lightbox');
    const lightboxContent = $('.cfi-lightbox__content');
    const closeBtn = $('.cfi-lightbox__close');

    if (filters.length && items.length) {
      filters.forEach((btn) => {
        btn.addEventListener('click', () => {
          const cat = btn.dataset.filter;
          filters.forEach((b) => b.classList.toggle('is-active', b === btn));
          items.forEach((item) => {
            const match = cat === 'all' || item.dataset.category === cat;
            item.style.display = match ? '' : 'none';
          });
        });
      });
    }

    if (!lightbox || !lightboxContent) return;

    function openLightbox(el) {
      const type = el.dataset.type || 'image';
      const src = el.dataset.src;
      const alt = el.dataset.alt || '';

      if (type === 'video') {
        lightboxContent.innerHTML = `<iframe src="${src}" title="${alt}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>`;
      } else {
        lightboxContent.innerHTML = `<img src="${src}" alt="${alt}">`;
      }

      lightbox.classList.add('is-open');
      lightbox.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      closeBtn?.focus();
    }

    function closeLightbox() {
      lightbox.classList.remove('is-open');
      lightbox.setAttribute('aria-hidden', 'true');
      lightboxContent.innerHTML = '';
      document.body.style.overflow = '';
    }

    items.forEach((item) => {
      item.addEventListener('click', () => openLightbox(item));
    });

    closeBtn?.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && lightbox.classList.contains('is-open')) closeLightbox();
    });
  }

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

  document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initHero();
    initCounters();
    initMap();
    initGallery();
    initDonate();
    initContact();
  });
})();
