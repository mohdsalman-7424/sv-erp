/**
 * CORE.JS — Samriddhi-Ventures ERP
 * Shared utilities, dark mode, auth helpers, toast, modals
 */

/* ---- DARK / LIGHT MODE ---- */
const ThemeManager = (() => {
  const STORAGE_KEY = 'sv_theme';

  function apply(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem(STORAGE_KEY, theme);
    // Update icons
    document.querySelectorAll('.theme-icon').forEach(el => {
      el.textContent = theme === 'dark' ? '☀️' : '🌙';
    });
  }

  function toggle() {
    const current = localStorage.getItem(STORAGE_KEY) || 'light';
    apply(current === 'dark' ? 'light' : 'dark');
  }

  function init() {
    const saved = localStorage.getItem(STORAGE_KEY) ||
      (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    apply(saved);
  }

  return { init, toggle, apply };
})();

/* ---- TOAST NOTIFICATIONS ---- */
const Toast = (() => {
  function show(message, type = 'info', duration = 3500) {
    let container = document.getElementById('toast-container');
    if (!container) {
      container = document.createElement('div');
      container.id = 'toast-container';
      document.body.appendChild(container);
    }
    const icons = { success: '✅', error: '❌', info: '✦', warning: '⚠️' };
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `<span class="toast-icon">${icons[type] || '✦'}</span><span>${message}</span>`;
    container.appendChild(toast);
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(24px)';
      toast.style.transition = 'all 0.3s ease';
      setTimeout(() => toast.remove(), 300);
    }, duration);
  }
  return { show };
})();

/* ---- MOBILE NAV ---- */
const MobileNav = (() => {
  function init() {
    const hamburger = document.getElementById('hamburger');
    const mobMenu   = document.getElementById('mobMenu');
    if (!hamburger || !mobMenu) return;
    hamburger.addEventListener('click', () => {
      const isOpen = mobMenu.classList.toggle('open');
      hamburger.classList.toggle('open', isOpen);
    });
    // close on outside click
    document.addEventListener('click', (e) => {
      if (!hamburger.contains(e.target) && !mobMenu.contains(e.target)) {
        mobMenu.classList.remove('open');
        hamburger.classList.remove('open');
      }
    });
  }
  return { init };
})();

/* ---- SIDEBAR (DASHBOARD) ---- */
const Sidebar = (() => {
  function init() {
    const toggleBtn = document.getElementById('sidebarToggle');
    const sidebar   = document.getElementById('mainSidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    if (!toggleBtn || !sidebar) return;

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      if (overlay) overlay.classList.toggle('active');
    });
    if (overlay) {
      overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
      });
    }
    // Mark active sidebar item
    const path = window.location.pathname;
    document.querySelectorAll('.sidebar-item[href]').forEach(link => {
      if (link.getAttribute('href') === path) link.classList.add('active');
    });
  }
  return { init };
})();

/* ---- MODALS ---- */
const Modal = (() => {
  function open(id) {
    const el = document.getElementById(id);
    if (el) el.classList.add('open');
  }
  function close(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('open');
  }
  function closeAll() {
    document.querySelectorAll('.modal-overlay.open').forEach(el => el.classList.remove('open'));
  }
  function init() {
    // Close on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
      overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.classList.remove('open');
      });
    });
    // Close buttons
    document.querySelectorAll('.modal-close').forEach(btn => {
      btn.addEventListener('click', () => {
        btn.closest('.modal-overlay').classList.remove('open');
      });
    });
    // Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeAll();
    });
  }
  return { open, close, closeAll, init };
})();

/* ---- FAQ ACCORDION ---- */
function initFAQ() {
  document.querySelectorAll('.faq-q').forEach(q => {
    q.addEventListener('click', () => {
      const item = q.parentElement;
      const wasOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
      if (!wasOpen) item.classList.add('open');
    });
  });
}

/* ---- FILTER CHIPS ---- */
function initFilterChips(containerSelector) {
  document.querySelectorAll(containerSelector + ' .filter-chip').forEach(chip => {
    chip.addEventListener('click', () => {
      chip.closest(containerSelector).querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
      chip.classList.add('active');
    });
  });
}

/* ---- TABLE SEARCH ---- */
function initTableSearch(inputId, tableId) {
  const input = document.getElementById(inputId);
  const table = document.getElementById(tableId);
  if (!input || !table) return;
  input.addEventListener('input', () => {
    const q = input.value.toLowerCase();
    table.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}

/* ---- LOCAL STORAGE HELPERS ---- */
const Store = {
  get: (key, def = null) => {
    try { return JSON.parse(localStorage.getItem('sv_' + key)) ?? def; } catch { return def; }
  },
  set: (key, value) => {
    try { localStorage.setItem('sv_' + key, JSON.stringify(value)); } catch {}
  },
  push: (key, item) => {
    const arr = Store.get(key, []);
    arr.unshift(item);
    Store.set(key, arr);
  }
};

/* ---- AUTH GUARD ---- */
function requireAuth(redirectUrl = '/auth/login') {
  const user = Store.get('current_user');
  if (!user) { window.location.href = redirectUrl; return false; }
  return user;
}

function requireRole(role, redirectUrl = '/') {
  const user = Store.get('current_user');
  if (!user || user.role !== role) { window.location.href = redirectUrl; return false; }
  return user;
}

function logout() {
  Store.set('current_user', null);
  window.location.href = '/sv_erp/auth/login';
}

/* ---- STAR FIELD ---- */
function initStarField(containerId = 'starField', count = 60) {
  const container = document.getElementById(containerId);
  if (!container) return;
  container.innerHTML = '';
  for (let i = 0; i < count; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    const size = Math.random() * 2.5 + 0.5;
    star.style.cssText = `
      width:${size}px; height:${size}px;
      top:${Math.random() * 100}%;
      left:${Math.random() * 100}%;
      --d:${(Math.random() * 3 + 2).toFixed(1)}s;
      animation-delay:${(Math.random() * 3).toFixed(1)}s;
      opacity:${Math.random() * 0.6 + 0.2};
    `;
    container.appendChild(star);
  }
}

/* ---- TICKER ---- */
function initTicker(containerId = 'tickerWrap') {
  const container = document.getElementById(containerId);
  if (!container) return;
  const items = [
    { label: 'Today\'s Tithi', value: 'Dashami' },
    { label: 'Nakshatra', value: 'Rohini' },
    { label: 'Yoga', value: 'Siddhi' },
    { label: 'Rahu Kaal', value: '9:00–10:30' },
    { label: 'Shubh Muhurat', value: '10:30–12:15' },
    { label: 'Panchang', value: 'Jyeshtha Shukla Dashami' },
    { label: 'Sun in', value: 'Mithun Rashi' },
    { label: 'Moon in', value: 'Vrishab Rashi' },
    { label: 'Mercury', value: 'Vrishabha' },
    { label: 'Jupiter', value: 'Vrishabha' },
  ];
  const render = (arr) => arr.map(i =>
    `<div class="tick-item"><div class="tick-dot"></div><span>${i.label}:</span><span class="tick-gold">${i.value}</span></div>`
  ).join('');
  container.innerHTML = render(items) + render(items); // duplicate for seamless loop
}

/* ---- INIT ON LOAD ---- */
document.addEventListener('DOMContentLoaded', () => {
  ThemeManager.init();
  MobileNav.init();
  Sidebar.init();
  Modal.init();
  initFAQ();
  initStarField();
  initTicker();

  // Bind theme toggles
  document.querySelectorAll('[data-action="toggle-theme"]').forEach(btn => {
    btn.addEventListener('click', ThemeManager.toggle);
  });

  // Animate elements on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('fade-in');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.kpi-card, .astro-card, .plan-card, .testi-card, .gem-card').forEach(el => {
    observer.observe(el);
  });
});

/* ---- GLOBAL HELPERS ---- */
function formatINR(amount) {
  return '₹' + Number(amount).toLocaleString('en-IN');
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
}

function randomId() {
  return 'SV' + Date.now().toString(36).toUpperCase();
}
