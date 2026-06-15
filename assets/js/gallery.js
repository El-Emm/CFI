/**
 * CharityFaith International — dynamic gallery loader
 */
(function () {
  'use strict';

  const $ = (sel, ctx = document) => ctx.querySelector(sel);
  const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

  const CATEGORY_LABELS = {
    outreach: 'Community Outreach',
    crusades: 'Crusades',
    food: 'Food Distribution',
    education: 'Education',
    healthcare: 'Healthcare',
    widow: 'Widow Empowerment',
    shelter: 'Shelter',
  };

  const isSubpage = window.location.pathname.includes('/pages/');
  const base = isSubpage ? '..' : '.';
  const manifestPath = `${base}/assets/data/gallery.json`;

  let activeCountry = 'all';
  let activeCategory = 'all';

  function formatPhone(num) {
    const d = num.replace(/\D/g, '');
    if (d.length === 11 && d.startsWith('1')) {
      return `+1 (${d.slice(1, 4)}) ${d.slice(4, 7)}-${d.slice(7)}`;
    }
    return num;
  }

  function renderCountries(countries, counts) {
    const grid = $('#cfi-countries-grid');
    if (!grid) return;

    grid.innerHTML = countries.map((c) => {
      const count = counts[c.id] || 0;
      return `
        <button type="button" class="cfi-country-card" data-country="${c.id}" aria-pressed="false">
          <span class="cfi-country-card__name">${c.label}</span>
          <span class="cfi-country-card__count">${count} media</span>
        </button>`;
    }).join('');

    $$('.cfi-country-card', grid).forEach((btn) => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.country;
        const next = activeCountry === id ? 'all' : id;
        setCountryFilter(next);
        if (next !== 'all') scrollToGrid();
      });
    });
  }

  function renderFilters(countries, categories) {
    const countryFilters = $('#cfi-country-filters');
    const catFilters = $('#cfi-category-filters');

    if (countryFilters) {
      countryFilters.innerHTML = `
        <button type="button" class="cfi-filter-btn cfi-country-filter is-active" data-filter="all">All Countries</button>
        ${countries.map((c) => `<button type="button" class="cfi-filter-btn cfi-country-filter" data-filter="${c.id}">${c.label}</button>`).join('')}
      `;
      $$('.cfi-country-filter', countryFilters).forEach((btn) => {
        btn.addEventListener('click', () => {
          setCountryFilter(btn.dataset.filter);
          syncCountryCards(btn.dataset.filter);
        });
      });
    }

    if (catFilters) {
      catFilters.innerHTML = `
        <button type="button" class="cfi-filter-btn cfi-category-filter is-active" data-filter="all">All Programs</button>
        ${categories.map((c) => `<button type="button" class="cfi-filter-btn cfi-category-filter" data-filter="${c}">${CATEGORY_LABELS[c] || c}</button>`).join('')}
      `;
      $$('.cfi-category-filter', catFilters).forEach((btn) => {
        btn.addEventListener('click', () => setCategoryFilter(btn.dataset.filter));
      });
    }
  }

  function syncCountryCards(id) {
    $$('.cfi-country-card').forEach((b) => {
      const on = id !== 'all' && b.dataset.country === id;
      b.classList.toggle('is-active', on);
      b.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  }

  function setCountryFilter(id) {
    activeCountry = id;
    $$('.cfi-country-filter').forEach((b) => b.classList.toggle('is-active', b.dataset.filter === id));
    syncCountryCards(id);
    applyFilters();
  }

  function setCategoryFilter(id) {
    activeCategory = id;
    $$('.cfi-category-filter').forEach((b) => b.classList.toggle('is-active', b.dataset.filter === id));
    applyFilters();
  }

  function renderGallery(items) {
    const grid = $('#cfi-gallery-grid');
    if (!grid) return;

    grid.innerHTML = items.map((item) => {
      const thumbSrc = item.thumb.startsWith('assets/') ? `${base}/${item.thumb}` : item.thumb;
      const fullSrc = item.src.startsWith('assets/') ? `${base}/${item.src}` : item.src;
      const isVideo = item.type === 'video';
      return `
        <button type="button" class="cfi-gallery-item${isVideo ? ' cfi-gallery-item--video' : ''}"
          data-country="${item.country}"
          data-category="${item.category}"
          data-type="${item.type}"
          data-src="${fullSrc}"
          data-alt="${item.alt}">
          <img src="${thumbSrc}" alt="${item.alt}" loading="lazy" width="400" height="400">
          <span class="cfi-gallery-item__overlay">
            <span class="cfi-gallery-item__label">${item.countryLabel}</span>
            <span class="cfi-gallery-item__label">${CATEGORY_LABELS[item.category] || item.category}</span>
          </span>
        </button>`;
    }).join('');

    window.CFI_initLightbox?.();
    applyFilters();
  }

  function applyFilters() {
    const items = $$('#cfi-gallery-grid .cfi-gallery-item');
    let visible = 0;
    items.forEach((item) => {
      const countryOk = activeCountry === 'all' || item.dataset.country === activeCountry;
      const catOk = activeCategory === 'all' || item.dataset.category === activeCategory;
      const show = countryOk && catOk;
      item.style.display = show ? '' : 'none';
      if (show) visible += 1;
    });
    const empty = $('#cfi-gallery-empty');
    if (empty) empty.hidden = visible > 0;
  }

  function scrollToGrid() {
    $('#cfi-gallery-grid')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function readUrlCountry() {
    const params = new URLSearchParams(window.location.search);
    return params.get('country');
  }

  async function init() {
    const grid = $('#cfi-gallery-grid');
    if (!grid) return;

    try {
      const res = await fetch(manifestPath);
      const data = await res.json();
      const items = data.gallery || [];

      const counts = {};
      items.forEach((item) => {
        counts[item.country] = (counts[item.country] || 0) + 1;
      });

      renderCountries(data.countries || [], counts);
      renderFilters(data.countries || [], data.categories || []);
      renderGallery(items);

      const urlCountry = readUrlCountry();
      if (urlCountry) setCountryFilter(urlCountry);
    } catch (err) {
      grid.innerHTML = '<p class="cfi-gallery-error">Unable to load gallery. Please refresh the page.</p>';
      console.error(err);
    }
  }

  document.addEventListener('DOMContentLoaded', init);
})();
