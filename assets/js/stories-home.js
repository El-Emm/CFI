/**
 * Homepage Stories of Hope — loads from stories.json (same source as blog posts).
 */
(function () {
  'use strict';

  const mount = document.getElementById('cfi-stories-mount');
  if (!mount) return;

  const base = mount.dataset.base || '.';

  function storyImage(story) {
    return `${base}/assets/media/featured/${story.image}`;
  }

  function storyUrl(story) {
    return `${base}/pages/stories/${story.slug}.html`;
  }

  function render(stories) {
    const featured = stories.find((s) => s.featured);
    const cards = stories.filter((s) => !s.featured);

    if (!featured) {
      mount.innerHTML = '';
      return;
    }

    mount.innerHTML = `
      <div class="cfi-stories">
        <article class="cfi-story-featured">
          <img src="${storyImage(featured)}" alt="${featured.title}" width="900" height="600" loading="lazy">
          <div class="cfi-story-featured__overlay">
            <span class="cfi-story-card__tag">${featured.tag}</span>
            <h3>${featured.title}</h3>
            <p>${featured.excerpt}</p>
            <a href="${storyUrl(featured)}" class="cfi-btn cfi-btn--primary">Read Full Story</a>
          </div>
        </article>
        <div class="cfi-story-list">
          ${cards.map((card) => `
            <a href="${storyUrl(card)}" class="cfi-story-card">
              <img src="${storyImage(card)}" alt="${card.title}" width="240" height="160" loading="lazy">
              <div class="cfi-story-card__body">
                <span class="cfi-story-card__tag">${card.tag}</span>
                <h4>${card.title}</h4>
              </div>
            </a>`).join('')}
        </div>
      </div>`;
  }

  async function init() {
    try {
      const res = await fetch(`${base}/assets/data/stories.json`);
      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      render(data.stories || []);
    } catch (err) {
      mount.innerHTML = '<p class="cfi-gallery-empty">Unable to load stories.</p>';
      console.error(err);
    }
  }

  document.addEventListener('DOMContentLoaded', init);
})();
