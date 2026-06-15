/**
 * STORE.JS — Samriddhi-Ventures ERP
 * Programmatically synced with MySQL via CodeIgniter 3 API endpoints
 */

const SVStore = (() => {

  const getApiUrl = (method, collection = '', id = '') => {
    const siteUrl = window.SV_SITE_URL || '/sv_erp/index.php/';
    const base = siteUrl.endsWith('/') ? siteUrl : siteUrl + '/';
    let url = base + 'api/' + method;
    const params = [];
    if (collection) params.push('collection=' + encodeURIComponent(collection));
    if (id) params.push('id=' + encodeURIComponent(id));
    if (params.length > 0) {
      url += '?' + params.join('&');
    }
    return url;
  };

  const syncRequest = (method, url, data = null) => {
    try {
      const xhr = new XMLHttpRequest();
      xhr.open(method, url, false); // Synchronous
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.send(data ? JSON.stringify(data) : null);
      if (xhr.status >= 200 && xhr.status < 300) {
        return JSON.parse(xhr.responseText);
      }
    } catch (e) {
      console.error('API Connection Error:', e);
    }
    return null;
  };

  // Static list for Rashi metadata (non-table)
  const RASHIS = [
    { sym: '♈', hi: 'मेष', en: 'Aries', lord: 'Mars', element: 'Fire' },
    { sym: '♉', hi: 'वृष', en: 'Taurus', lord: 'Venus', element: 'Earth' },
    { sym: '♊', hi: 'मिथुन', en: 'Gemini', lord: 'Mercury', element: 'Air' },
    { sym: '♋', hi: 'कर्क', en: 'Cancer', lord: 'Moon', element: 'Water' },
    { sym: '♌', hi: 'सिंह', en: 'Leo', lord: 'Sun', element: 'Fire' },
    { sym: '♍', hi: 'कन्या', en: 'Virgo', lord: 'Mercury', element: 'Earth' },
    { sym: '♎', hi: 'तुला', en: 'Libra', lord: 'Venus', element: 'Air' },
    { sym: '♏', hi: 'वृश्चिक', en: 'Scorpio', lord: 'Mars', element: 'Water' },
    { sym: '♐', hi: 'धनु', en: 'Sagittarius', lord: 'Jupiter', element: 'Fire' },
    { sym: '♑', hi: 'मकर', en: 'Capricorn', lord: 'Saturn', element: 'Earth' },
    { sym: '♒', hi: 'कुम्भ', en: 'Aquarius', lord: 'Saturn', element: 'Air' },
    { sym: '♓', hi: 'मीन', en: 'Pisces', lord: 'Jupiter', element: 'Water' }
  ];

  function init() {
    // DB is fully seeded on the server side now
  }

  function getAll(collection) {
    if (collection === 'rashis') {
      return RASHIS;
    }
    const url = getApiUrl('get', collection);
    const data = syncRequest('GET', url);
    return data || [];
  }

  function getById(collection, id) {
    const items = getAll(collection);
    return items.find(item => String(item.id) === String(id)) || null;
  }

  function add(collection, item) {
    const url = getApiUrl('save', collection);
    const data = syncRequest('POST', url, item);
    return data || item;
  }

  function update(collection, id, updates) {
    const current = getById(collection, id);
    if (!current) return null;
    const merged = { ...current, ...updates };
    const url = getApiUrl('save', collection);
    const data = syncRequest('POST', url, merged);
    return data || merged;
  }

  function remove(collection, id) {
    const url = getApiUrl('remove', collection, id);
    syncRequest('POST', url);
  }

  function login(email, password, role) {
    const url = getApiUrl('login');
    const user = syncRequest('POST', url, { email, password, role });
    if (user) {
      localStorage.setItem('sv_current_user', JSON.stringify(user));
      return user;
    }
    return null;
  }

  function currentUser() {
    try { return JSON.parse(localStorage.getItem('sv_current_user')); }
    catch { return null; }
  }

  function logout() {
    localStorage.removeItem('sv_current_user');
  }

  function adminStats() {
    const url = getApiUrl('admin_stats');
    const data = syncRequest('GET', url);
    if (data) return data;
    return {
      totalUsers: 0,
      totalAstrologers: 0,
      totalRevenue: 0,
      activeSubscriptions: 0
    };
  }

  return { init, getAll, getById, add, update, remove, login, currentUser, logout, adminStats };
})();

document.addEventListener('DOMContentLoaded', () => SVStore.init());
