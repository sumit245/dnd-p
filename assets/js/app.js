document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const mainContent = document.getElementById('main-content');
  const skipLink = document.querySelector('.skip-link');
  if (mainContent && !mainContent.hasAttribute('tabindex')) {
    mainContent.setAttribute('tabindex', '-1');
  }
  if (skipLink && mainContent) {
    skipLink.addEventListener('click', () => {
      requestAnimationFrame(() => mainContent.focus({ preventScroll: false }));
    });
  }

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // Push to dataLayer (GTM) and, when gtag.js is loaded directly (GA4_MEASUREMENT_ID),
  // also send the same event to GA4 so tracking works before GTM has any tags.
  const pushEvent = (event, payload = {}) => {
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ event, ...payload });
    if (window.DND_GA4_ID && typeof window.gtag === 'function') {
      try { window.gtag('event', event, { ...payload, send_to: window.DND_GA4_ID }); } catch (e) { /* ignore */ }
    }
  };

  document.querySelectorAll('[data-track]').forEach(el => {
    el.addEventListener('click', () => {
      const trackType = el.dataset.track;
      const payload = {
        cta_text: (el.textContent || '').trim(),
        cta_location: el.dataset.ctaLocation || '',
        destination: el.getAttribute('href') || '',
        page_path: window.location.pathname
      };

      if (trackType === 'whatsapp') {
        pushEvent('whatsapp_click', payload);
      } else if (trackType === 'phone') {
        pushEvent('phone_click', payload);
      } else if (trackType === 'demo') {
        pushEvent('demo_click', { ...payload, demo_slug: el.dataset.demoSlug || '' });
      } else if (trackType === 'proof-card') {
        pushEvent('proof_card_click', { ...payload, proof_type: el.dataset.proofType || '' });
      } else {
        pushEvent('cta_click', payload);
      }
    });
  });

  // ── Navbar scroll ──
  const navbar = document.getElementById('navbar');
  const backToTop = document.getElementById('backToTop');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 20);
      if (backToTop) backToTop.classList.toggle('show', window.scrollY > 400);
    }, { passive: true });
  }

  // ── Nav scroll-spy (homepage only: sections #home/#about/#services/#portfolio) ──
  const spyLinks = Array.from(document.querySelectorAll('.nav-links a[href]')).map(a => {
    const href = a.getAttribute('href') || '';
    const hash = href.includes('#') ? href.slice(href.indexOf('#') + 1) : (href.replace(/\/$/, '').split('/').pop() || '');
    const section = hash ? document.getElementById(hash) : null;
    return section ? { a, section } : null;
  }).filter(Boolean).sort((a, b) => a.section.offsetTop - b.section.offsetTop);
  if (spyLinks.length > 1) {
    // Probe line sits ~a third down the viewport so a section counts once it clearly occupies the screen.
    const navH = () => Math.max((navbar ? navbar.offsetHeight : 70) + 24, Math.round(window.innerHeight * 0.35));
    let spyTick = false;
    const runSpy = () => {
      spyTick = false;
      const y = window.scrollY + navH();
      let current = spyLinks[0];
      spyLinks.forEach(l => { if (l.section.offsetTop <= y) current = l; });
      // Past the last section (e.g. contact/footer) → keep the last one lit.
      spyLinks.forEach(l => l.a.classList.toggle('active', l === current));
    };
    window.addEventListener('scroll', () => {
      if (!spyTick) { spyTick = true; setTimeout(runSpy, 60); }
    }, { passive: true });
    window.addEventListener('resize', runSpy, { passive: true });
    runSpy();
  }

  const mobileStickyCta = document.querySelector('.mobile-sticky-cta');
  const mobileStickyBlockers = Array.from(document.querySelectorAll('#home, .trust-bar, .estimate-jump'));
  const hasVisibleStickyBlocker = () => mobileStickyBlockers.some(el => {
    const rect = el.getBoundingClientRect();
    return rect.bottom > 90 && rect.top < window.innerHeight - 90;
  });
  const updateMobileStickyCta = () => {
    if (!mobileStickyCta) return;
    const revealAfter = Math.max(window.innerHeight * 1.15, 720);
    const shouldShow = window.innerWidth <= 768 && window.scrollY > revealAfter && !hasVisibleStickyBlocker();
    mobileStickyCta.classList.toggle('is-visible', shouldShow);
  };
  updateMobileStickyCta();
  window.addEventListener('scroll', updateMobileStickyCta, { passive: true });
  window.addEventListener('resize', updateMobileStickyCta);

  // ── Back to top ──
  if (backToTop) {
    backToTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
    });
  }

  // ── Mobile menu (dialog + focus trap) ──
  const hamburger = document.getElementById('hamburgerBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  let mobileMenuLastFocus = null;

  const getMobileMenuFocusables = () => Array.from(mobileMenu.querySelectorAll(
    'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'
  )).filter(el => !el.hasAttribute('disabled') && el.offsetParent !== null);

  const closeMobileMenu = () => {
    mobileMenu.classList.remove('open');
    mobileMenu.setAttribute('aria-hidden', 'true');
    hamburger.setAttribute('aria-expanded', 'false');
    hamburger.setAttribute('aria-label', 'Open navigation menu');
    document.body.style.overflow = '';
    if (mobileMenuLastFocus) {
      mobileMenuLastFocus.focus();
    }
  };

  const openMobileMenu = () => {
    mobileMenuLastFocus = document.activeElement;
    mobileMenu.classList.add('open');
    mobileMenu.setAttribute('aria-hidden', 'false');
    hamburger.setAttribute('aria-expanded', 'true');
    hamburger.setAttribute('aria-label', 'Close navigation menu');
    document.body.style.overflow = 'hidden';
    const focusables = getMobileMenuFocusables();
    if (focusables.length) {
      focusables[0].focus();
    }
  };

  if (hamburger && mobileMenu) {
    hamburger.addEventListener('click', () => {
      if (mobileMenu.classList.contains('open')) {
        closeMobileMenu();
      } else {
        openMobileMenu();
      }
    });

    mobileMenu.addEventListener('keydown', (e) => {
      if (!mobileMenu.classList.contains('open')) {
        return;
      }
      if (e.key === 'Escape') {
        e.preventDefault();
        closeMobileMenu();
        return;
      }
      if (e.key !== 'Tab') {
        return;
      }
      const focusables = getMobileMenuFocusables();
      if (!focusables.length) {
        return;
      }
      const first = focusables[0];
      const last = focusables[focusables.length - 1];
      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    });

    mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMobileMenu));
  }

  // ── Scroll reveal ──
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(el => observer.observe(el));
  }

  // ── FAQ accordion ──
  document.querySelectorAll('.faq-q').forEach(btn => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.faq-item');
      const isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(i => {
        i.classList.remove('open');
        i.querySelector('.faq-q').setAttribute('aria-expanded', 'false');
      });
      if (!isOpen) { item.classList.add('open'); btn.setAttribute('aria-expanded', 'true'); }
    });
  });

  // ── Portfolio filter ──
  // ── Portfolio (home): show the first 6 cards matching the chosen industry ──
  const HOME_PORTFOLIO_MAX = 6;
  const homeCards = document.querySelectorAll('#portfolio .portfolio-card');
  const homeFilterBtns = document.querySelectorAll('#portfolio button.filter-btn');
  const viewAllLink = document.getElementById('portfolioViewAll');
  if (homeCards.length && homeFilterBtns.length) {
    const viewAllBase = viewAllLink ? viewAllLink.getAttribute('href').split('?')[0] : '';
    homeFilterBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const filter = btn.dataset.filter;
        homeFilterBtns.forEach(b => {
          const on = b === btn;
          b.classList.toggle('active', on);
          b.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        let shown = 0;
        homeCards.forEach(card => {
          const match = filter === 'all' || card.dataset.industry === filter;
          const show = match && shown < HOME_PORTFOLIO_MAX;
          if (show) shown++;
          card.hidden = !show;
          if (show) card.classList.add('visible');
        });
        if (viewAllLink) {
          viewAllLink.href = viewAllBase + (filter === 'all' ? '' : '?industry=' + encodeURIComponent(filter));
        }
        pushEvent('portfolio_filter', { filter, page_path: window.location.pathname });
      });
    });
  }

  // ── Contact form with AJAX to PHP backend ──
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', async function (e) {
      e.preventDefault();
      const btn = document.getElementById('submitBtn');
      const status = document.getElementById('formStatus');
      const form = this;

      const name = form.name.value.trim();
      const email = form.email.value.trim();
      const message = form.message.value.trim();
      if (!name || !email || !message) {
        status.className = 'form-status error';
        status.textContent = 'Please fill in all required fields (name, email, and message).';
        pushEvent('contact_form_submit_error', { error_type: 'client_validation', page_path: window.location.pathname });
        return;
      }
      const emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRx.test(email)) {
        status.className = 'form-status error';
        status.textContent = 'Please enter a valid email address.';
        pushEvent('contact_form_submit_error', { error_type: 'invalid_email', page_path: window.location.pathname });
        return;
      }

      pushEvent('contact_form_submit_attempt', {
        service: form.service.value,
        page_path: window.location.pathname
      });
      btn.classList.add('loading');
      btn.disabled = true;
      status.className = 'form-status';
      status.textContent = '';

      try {
        const payload = {
          name, email,
          company: form.company.value.trim(),
          phone: form.phone.value.trim(),
          service: form.service.value,
          message,
          website: (form.website && form.website.value) ? form.website.value.trim() : ''
        };
        const res = await fetch('contact-handler.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify(payload)
        });
        let data = null;
        try { data = await res.json(); } catch (e) { data = null; }
        if (data && data.success) {
          status.className = 'form-status success';
          status.textContent = '✓ Thank you! Your enquiry has been received. We\'ll respond within 1 business day with next steps.';
          pushEvent('contact_form_submit_success', {
            service: payload.service,
            page_path: window.location.pathname
          });
          form.reset();
        } else {
          // Server gave a reason (rate limit, validation, SMTP) — show it instead of a generic line.
          const serverMsg = data && data.message ? String(data.message) : '';
          const e = new Error(serverMsg || ('HTTP ' + res.status));
          e.serverMessage = serverMsg;
          throw e;
        }
      } catch (err) {
        status.className = 'form-status error';
        status.textContent = (err && err.serverMessage)
          ? err.serverMessage
          : 'Something went wrong. Please try again, or use the direct contact options on this page.';
        pushEvent('contact_form_submit_error', {
          error_type: 'server_or_network',
          error_message: err && err.message ? err.message : '',
          page_path: window.location.pathname
        });
      } finally {
        btn.classList.remove('loading');
        btn.disabled = false;
      }
    });
  }

  // ── Smooth scroll for anchor links ──
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = target.getBoundingClientRect().top + window.scrollY - 80;
        window.scrollTo({ top: offset, behavior: 'smooth' });
      }
    });
  });

  /* ═══════════════════════════════ AI BRIEF WIZARD ═══════════════════════════════ */
  // Only init wizard if present on page
  if (document.getElementById('wizPane1')) {
    const wizardData = { type: '', scale: '', features: [], integrations: [], name: '', email: '', company: '', phone: '', idea: '', _briefText: '' };
    let currentStep = 1;

    function updateProgress(step) {
      document.querySelectorAll('.wp-step').forEach((el, i) => {
        el.classList.remove('active', 'done');
        el.removeAttribute('aria-current');
        if (i + 1 < step) el.classList.add('done');
        else if (i + 1 === step) { el.classList.add('active'); el.setAttribute('aria-current', 'step'); }
      });
    }

    function showPane(n) {
      document.querySelectorAll('.wizard-pane').forEach(p => p.classList.remove('active'));
      const pane = document.getElementById('wizPane' + n);
      if (pane) { pane.classList.add('active'); pane.scrollIntoView({ behavior: 'smooth', block: 'nearest' }); }
      document.getElementById('wizResultPane').style.display = 'none';
      updateProgress(n);
      currentStep = n;
    }

    window.wizNext = function(from) {
      if (from === 1 && !wizardData.type) return;
      if (from === 2 && !wizardData.scale) return;
      showPane(from + 1);
    };
    window.wizBack = function(from) { showPane(from - 1); };

    // Step 1 — type selection
    document.querySelectorAll('.wiz-type-card').forEach(card => {
      card.addEventListener('click', () => {
        document.querySelectorAll('.wiz-type-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        wizardData.type = card.dataset.type;
        document.getElementById('step1Next').disabled = false;
        pushEvent('estimate_started', {
          project_type: wizardData.type,
          page_path: window.location.pathname
        });
      });
    });

    window.selectScale = function(el) {
      document.querySelectorAll('.wiz-radio-card').forEach(c => c.classList.remove('selected'));
      el.classList.add('selected');
      wizardData.scale = el.dataset.scale;
      document.getElementById('step2Next').disabled = false;
      pushEvent('estimate_step_completed', {
        step: 'scale',
        scale: wizardData.scale,
        page_path: window.location.pathname
      });
    };

    window.toggleCheck = function(el) {
      el.classList.toggle('selected');
      const cb = el.querySelector('input[type="checkbox"]');
      if (cb) cb.checked = el.classList.contains('selected');
    };

    function getChecked(gridId) {
      const vals = [];
      document.querySelectorAll('#' + gridId + ' .wiz-check-card.selected input').forEach(i => vals.push(i.value));
      return vals;
    }

    window.generateBrief = function() {
      const name = document.getElementById('wizName').value.trim();
      const email = document.getElementById('wizEmail').value.trim();
      const showWizError = (msg) => {
        let box = document.getElementById('wizError');
        if (!box) {
          box = document.createElement('p');
          box.id = 'wizError';
          box.className = 'wiz-error';
          box.setAttribute('role', 'alert');
          const nav = document.querySelector('#wizPane5 .wizard-nav');
          if (nav) nav.parentNode.insertBefore(box, nav);
        }
        box.textContent = msg || '';
        box.hidden = !msg;
      };
      showWizError('');
      if (!name || !email) { showWizError('Please enter your name and email to generate the brief.'); return; }

      wizardData.features = getChecked('featuresGrid');
      wizardData.integrations = getChecked('integrationsGrid');
      wizardData.name = name;
      wizardData.email = email;
      wizardData.company = document.getElementById('wizCompany').value.trim();
      wizardData.phone = document.getElementById('wizPhone').value.trim();
      wizardData.idea = document.getElementById('wizIdea').value.trim();

      const btn = document.querySelector('button[onclick="generateBrief()"]');
      const btnLabel = btn ? btn.textContent : '';
      if (btn) { btn.classList.add('loading'); btn.disabled = true; btn.textContent = 'Generating your brief…'; }

      fetch('estimate.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(wizardData)
      })
      .then(async res => {
        let data = null;
        try { data = await res.json(); } catch (e) { data = null; }
        if (!data) throw new Error('HTTP ' + res.status);
        return data;
      })
      .then(data => {
        if (btn) { btn.classList.remove('loading'); btn.disabled = false; btn.textContent = btnLabel; }
        if (data.error) { showWizError(data.error); return; }

        document.getElementById('resProjectType').textContent = data.type;
        document.getElementById('resClientName').textContent = data.clientName;
        document.getElementById('resTimeline').textContent = data.timelineStr;
        document.getElementById('resComplexity').textContent = data.complexity;
        document.getElementById('resSummary').textContent = data.summary;
        document.getElementById('resScope').textContent = data.scope;
        document.getElementById('resTech').textContent = data.tech;
        document.getElementById('resNotes').textContent = data.notes;
        wizardData._briefText = data.briefText;
        pushEvent('estimate_completed', {
          project_type: data.type,
          source: data.source,
          timeline: data.timelineStr,
          complexity: data.complexity,
          page_path: window.location.pathname
        });

        document.querySelectorAll('.wizard-pane').forEach(p => p.classList.remove('active'));
        document.getElementById('wizResultPane').style.display = 'block';
        updateProgress(6);
        document.getElementById('wizResultPane').scrollIntoView({ behavior: 'smooth', block: 'start' });
      })
      .catch(err => {
        if (btn) { btn.classList.remove('loading'); btn.disabled = false; btn.textContent = btnLabel; }
        console.error(err);
        showWizError('Something went wrong generating your brief. Please try again in a moment, or use the contact form below.');
      });
    };

    window.prefillContactForm = function() {
      const f = document.getElementById('contactForm');
      if (!f) return;
      f.querySelector('#name').value = wizardData.name || '';
      f.querySelector('#email').value = wizardData.email || '';
      if (wizardData.company) f.querySelector('#company').value = wizardData.company;
      if (wizardData.phone) f.querySelector('#phone').value = wizardData.phone;

      const sel = f.querySelector('#service');
      if (sel) {
        const serviceMap = {
          'ERP': 'ERP Development', 'CRM': 'CRM Development', 'TMS': 'Transport Management System (TMS)',
          'HMS': 'Hospital Management System (HMS)', 'Hotel PMS': 'Hotel / Property Management (PMS)',
          'Web App': 'Custom Web Application', 'Mobile App': 'Mobile App (iOS / Android)',
          'Website': 'Custom Web Application', 'Finance Software': 'Data, Analytics & AI',
          'IoT/Embedded': 'IoT & Embedded'
        };
        const target = serviceMap[wizardData.type] || '';
        for (let i = 0; i < sel.options.length; i++) {
          if (sel.options[i].text.includes(target.split(' ')[0]) || sel.options[i].value === target) {
            sel.selectedIndex = i; break;
          }
        }
      }
      f.querySelector('#message').value = wizardData._briefText;

      const contactSection = document.getElementById('contact');
      if (contactSection) {
        contactSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        setTimeout(() => {
          f.classList.add('form-highlight');
          setTimeout(() => f.classList.remove('form-highlight'), 2800);
        }, 600);
      }
    };

    window.resetWizard = function() {
      wizardData.type = ''; wizardData.scale = ''; wizardData.features = []; wizardData.integrations = [];
      wizardData.name = ''; wizardData.email = ''; wizardData.company = ''; wizardData.phone = ''; wizardData.idea = ''; wizardData._briefText = '';
      document.querySelectorAll('.wiz-type-card').forEach(c => c.classList.remove('selected'));
      document.querySelectorAll('.wiz-radio-card').forEach(c => { c.classList.remove('selected'); c.querySelector('input').checked = false; });
      document.querySelectorAll('.wiz-check-card').forEach(c => { c.classList.remove('selected'); c.querySelector('input').checked = false; });
      ['wizName', 'wizEmail', 'wizCompany', 'wizPhone', 'wizIdea'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
      document.getElementById('step1Next').disabled = true;
      document.getElementById('step2Next').disabled = true;
      document.getElementById('wizResultPane').style.display = 'none';
      showPane(1);
      document.getElementById('ai-brief').scrollIntoView({ behavior: 'smooth', block: 'start' });
    };
  }
  /* ═══════════════════════════════ END WIZARD ═══════════════════════════════ */
});
