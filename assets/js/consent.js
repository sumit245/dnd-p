/**
 * Cookie consent + Consent Mode v2 + optional Web Vitals → dataLayer (for GTM).
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'dashandots_consent_v1';

  function readChoice() {
    try {
      var raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return null;
      var parsed = JSON.parse(raw);
      if (parsed && (parsed.analytics === true || parsed.analytics === false)) {
        return parsed;
      }
    } catch (e) { /* ignore */ }
    return null;
  }

  function saveChoice(analytics) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify({
        analytics: !!analytics,
        ts: Date.now()
      }));
    } catch (e) { /* ignore */ }
  }

  function pushConsentUpdate(granted) {
    window.dataLayer = window.dataLayer || [];
    var state = granted ? 'granted' : 'denied';
    window.dataLayer.push({
      event: 'consent_update',
      analytics_storage: state,
      ad_storage: 'denied',
      ad_user_data: 'denied',
      ad_personalization: 'denied',
      functionality_storage: state,
      personalization_storage: 'denied'
    });
    if (typeof gtag === 'function') {
      gtag('consent', 'update', {
        analytics_storage: state,
        ad_storage: 'denied',
        ad_user_data: 'denied',
        ad_personalization: 'denied',
        functionality_storage: state,
        personalization_storage: 'denied'
      });
    }
  }

  function sendWebVital(metric) {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
      event: 'web_vitals',
      metric_name: metric.name,
      metric_value: metric.value,
      metric_id: metric.id,
      metric_delta: metric.delta,
      metric_rating: metric.rating || ''
    });
  }

  function loadWebVitals() {
    var choice = readChoice();
    if (!choice || !choice.analytics) return;

    var script = document.createElement('script');
    script.src = 'https://unpkg.com/web-vitals@4/dist/web-vitals.attribution.iife.js';
    script.async = true;
    script.onload = function () {
      if (!window.webVitals) return;
      var wv = window.webVitals;
      if (wv.onCLS) wv.onCLS(sendWebVital);
      if (wv.onINP) wv.onINP(sendWebVital);
      if (wv.onLCP) wv.onLCP(sendWebVital);
    };
    document.head.appendChild(script);
  }

  function hideBanner(banner) {
    if (!banner) return;
    banner.setAttribute('hidden', '');
    banner.setAttribute('aria-hidden', 'true');
    banner.classList.remove('consent-banner--visible');
  }

  function showBanner(banner) {
    if (!banner) return;
    banner.removeAttribute('hidden');
    banner.setAttribute('aria-hidden', 'false');
    banner.classList.add('consent-banner--visible');
    var accept = document.getElementById('consentAccept');
    if (accept) accept.focus();
  }

  function applyChoice(analytics, banner) {
    saveChoice(analytics);
    pushConsentUpdate(analytics);
    hideBanner(banner);
    if (analytics) loadWebVitals();
  }

  function init() {
    var banner = document.getElementById('consentBanner');
    var existing = readChoice();

    if (existing) {
      pushConsentUpdate(existing.analytics);
      hideBanner(banner);
      if (existing.analytics) loadWebVitals();
      return;
    }

    if (!banner) return;

    showBanner(banner);

    document.getElementById('consentAccept')?.addEventListener('click', function () {
      applyChoice(true, banner);
    });
    document.getElementById('consentReject')?.addEventListener('click', function () {
      applyChoice(false, banner);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
