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
    'building-houses': 'Building Houses for Folks',
  };

  const isSubpage = window.location.pathname.includes('/pages/');
  const base = (window.cfiTheme && window.cfiTheme.themeUri)
    ? window.cfiTheme.themeUri
    : (isSubpage ? '..' : '.');

  const manifestPath = (window.cfiTheme && window.cfiTheme.galleryApi)
    ? window.cfiTheme.galleryApi
    : ((window.cfiTheme && window.cfiTheme.galleryJson)
      ? window.cfiTheme.galleryJson
      : `${base}/assets/data/gallery.json`);

  let allItems = [];
  let countries = [];
  let categories = [];
  let activeCountry = 'all';
  let activeCategory = 'all';

  function resolveAsset(path) {
    if (!path || path.startsWith('http')) return path;
    if (window.cfiTheme && window.cfiTheme.themeUri) {
      return path.startsWith('assets/') ? `${window.cfiTheme.themeUri}/${path}` : path;
    }
    return `${base}/${path}`;
  }

  function countItems(filterCountry, filterCategory) {
    return allItems.filter((item) => {
      const countryOk = filterCountry === 'all' || item.country === filterCountry;
      const catOk = filterCategory === 'all' || item.category === filterCategory;
      return countryOk && catOk;
    }).length;
  }

  function countryCounts() {
    const counts = {};
    countries.forEach((c) => {
      counts[c.id] = countItems(c.id, activeCategory);
    });
    return counts;
  }

  function categoryCounts() {
    const counts = {};
    categories.forEach((cat) => {
      counts[cat] = countItems(activeCountry, cat);
    });
    return counts;
  }

  function updateMetaBar() {
    const meta = $('#cfi-gallery-meta');
    if (!meta) return;

    const visible = countItems(activeCountry, activeCategory);
    const parts = [];

    if (activeCountry !== 'all') {
      const country = countries.find((c) => c.id === activeCountry);
      parts.push(country ? country.label : activeCountry);
    }
    if (activeCategory !== 'all') {
      parts.push(CATEGORY_LABELS[activeCategory] || activeCategory);
    }

    const summary = parts.length
      ? parts.join(' · ')
      : 'All countries & programs';

    meta.innerHTML = `
      <p class="cfi-gallery-meta__summary">
        <strong>${visible}</strong> ${visible === 1 ? 'item' : 'items'}
        <span class="cfi-gallery-meta__filters">${summary}</span>
      </p>
      ${(activeCountry !== 'all' || activeCategory !== 'all')
        ? '<button type="button" class="cfi-gallery-meta__clear" id="cfi-gallery-clear">Clear filters</button>'
        : ''}`;
    $('#cfi-gallery-clear')?.addEventListener('click', clearFilters);
  }

  function renderCountries() {
    const grid = $('#cfi-countries-grid');
    if (!grid) return;

    const counts = countryCounts();
    const totalAll = countItems('all', activeCategory);

    grid.innerHTML = `
      <button type="button" class="cfi-country-card${activeCountry === 'all' ? ' is-active' : ''}"
        data-country="all" aria-pressed="${activeCountry === 'all'}">
        <span class="cfi-country-card__name">All Countries</span>
        <span class="cfi-country-card__count">${totalAll} media</span>
      </button>
      ${countries.map((c) => {
        const count = counts[c.id] || 0;
        const active = activeCountry === c.id;
        return `
        <button type="button" class="cfi-country-card${active ? ' is-active' : ''}${count === 0 ? ' is-empty' : ''}"
          data-country="${c.id}" aria-pressed="${active}" ${count === 0 ? 'disabled' : ''}>
          <span class="cfi-country-card__name">${c.label}</span>
          <span class="cfi-country-card__count">${count} media</span>
        </button>`;
      }).join('')}`;

    $$('.cfi-country-card', grid).forEach((btn) => {
      btn.addEventListener('click', () => {
        if (btn.disabled) return;
        setCountryFilter(btn.dataset.country);
        scrollToGrid();
      });
    });
  }

  function renderCategoryFilters() {
    const catFilters = $('#cfi-category-filters');
    if (!catFilters) return;

    const counts = categoryCounts();
    const totalAll = countItems(activeCountry, 'all');

    catFilters.innerHTML = `
      <button type="button" class="cfi-filter-btn cfi-category-filter${activeCategory === 'all' ? ' is-active' : ''}"
        data-filter="all">All Programs <span class="cfi-filter-btn__count">(${totalAll})</span></button>
      ${categories.map((cat) => {
        const count = counts[cat] || 0;
        const active = activeCategory === cat;
        return `<button type="button" class="cfi-filter-btn cfi-category-filter${active ? ' is-active' : ''}${count === 0 ? ' is-empty' : ''}"
          data-filter="${cat}" ${count === 0 ? 'disabled' : ''}>${CATEGORY_LABELS[cat] || cat}
          <span class="cfi-filter-btn__count">(${count})</span></button>`;
      }).join('')}`;

    $$('.cfi-category-filter', catFilters).forEach((btn) => {
      btn.addEventListener('click', () => {
        if (btn.disabled) return;
        setCategoryFilter(btn.dataset.filter);
      });
    });
  }

  function refreshFilters() {
    renderCountries();
    renderCategoryFilters();
    updateMetaBar();
  }

  function setCountryFilter(id) {
    activeCountry = id;
    if (activeCategory !== 'all' && countItems(id, activeCategory) === 0) {
      activeCategory = 'all';
    }
    syncUrl();
    refreshFilters();
    applyFilters();
  }

  function setCategoryFilter(id) {
    activeCategory = id;
    if (activeCountry !== 'all' && countItems(activeCountry, id) === 0) {
      activeCountry = 'all';
    }
    syncUrl();
    refreshFilters();
    applyFilters();
  }

  function clearFilters() {
    activeCountry = 'all';
    activeCategory = 'all';
    syncUrl();
    refreshFilters();
    applyFilters();
  }

  function syncUrl() {
    const params = new URLSearchParams();
    if (activeCountry !== 'all') params.set('country', activeCountry);
    if (activeCategory !== 'all') params.set('program', activeCategory);
    const query = params.toString();
    const next = `${window.location.pathname}${query ? `?${query}` : ''}`;
    window.history.replaceState({}, '', next);
  }

  function renderGallery(items) {
    const grid = $('#cfi-gallery-grid');
    if (!grid) return;

    allItems = items;

    if (!items.length) {
      grid.innerHTML = '';
      applyFilters();
      return;
    }

    grid.innerHTML = items.map((item) => {
      const thumbSrc = resolveAsset(item.thumb);
      const fullSrc = resolveAsset(item.src);
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
    refreshFilters();
    applyFilters();
  }

  function applyFilters() {
    const items = $$('#cfi-gallery-grid .cfi-gallery-item');
    let visible = 0;
    items.forEach((item) => {
      const countryOk = activeCountry === 'all' || item.dataset.country === activeCountry;
      const catOk = activeCategory === 'all' || item.dataset.category === activeCategory;
      const show = countryOk && catOk;
      item.hidden = !show;
      if (show) visible += 1;
    });
    const empty = $('#cfi-gallery-empty');
    if (empty) empty.hidden = visible > 0;
    updateMetaBar();
  }

  function scrollToGrid() {
    $('#cfi-gallery-toolbar')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function readUrlFilters() {
    const params = new URLSearchParams(window.location.search);
    const country = params.get('country');
    const program = params.get('program') || params.get('category');
    if (country) activeCountry = country;
    if (program) activeCategory = program;
  }

  async function init() {
    const grid = $('#cfi-gallery-grid');
    if (!grid) return;

    try {
      const res = await fetch(manifestPath);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();

      countries = data.countries || [];
      categories = data.categories || [];

      readUrlFilters();
      renderGallery(data.gallery || []);
    } catch (err) {
      grid.innerHTML = '<p class="cfi-gallery-error">Unable to load gallery. Please refresh the page.</p>';
      console.error(err);
    }
  }

  document.addEventListener('DOMContentLoaded', init);
})();
