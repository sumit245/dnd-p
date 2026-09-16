/* Portfolio page — client-side industry filter + stagger bookkeeping.
   Placement is pure CSS (dense grid in sort order); hiding tiles re-packs the rest.
   Reveal animation is handled by the site-wide .reveal observer in app.js. */
document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const root = document.querySelector('.pf');
  if (!root) return;

  const chips = Array.from(root.querySelectorAll('.pf-chip[data-filter]'));
  const tiles = Array.from(root.querySelectorAll('.pf-tile:not([data-cta])'));
  const count = document.getElementById('pf-count');
  const empty = document.getElementById('pf-empty');
  const valid = new Set(chips.map(c => c.dataset.filter));

  const push = (event, payload) => {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event, ...payload });
  };

  const apply = (filter, updateUrl) => {
    chips.forEach(c => {
      const on = c.dataset.filter === filter;
      c.classList.toggle('is-active', on);
      c.setAttribute('aria-pressed', on ? 'true' : 'false');
    });

    let shown = 0;
    tiles.forEach(t => {
      const show = filter === 'all' || t.dataset.industry === filter;
      t.hidden = !show;
      if (show) {
        t.style.setProperty('--reveal-delay', ((shown % 6) * 60) + 'ms');
        // Tiles un-hidden after the observer already fired need a nudge.
        if (!t.classList.contains('visible')) t.classList.add('visible');
        shown++;
      }
    });

    if (count) count.textContent = shown + (shown === 1 ? ' project' : ' projects');
    if (empty) empty.hidden = shown > 0;

    if (updateUrl) {
      const url = new URL(window.location.href);
      if (filter === 'all') url.searchParams.delete('industry');
      else url.searchParams.set('industry', filter);
      history.replaceState(null, '', url);
      push('portfolio_filter', { filter, page_path: url.pathname });
    }
  };

  chips.forEach(c => c.addEventListener('click', () => apply(c.dataset.filter, true)));

  const initial = new URLSearchParams(window.location.search).get('industry');
  if (initial && valid.has(initial)) apply(initial, false);

  tiles.forEach(t => {
    t.addEventListener('click', () => {
      push('portfolio_tile_click', { slug: t.dataset.slug, industry: t.dataset.industry, page_path: window.location.pathname });
    });
  });
});
