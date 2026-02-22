import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const THEME_KEY = 'serial-system-theme';

function getPreferredTheme() {
  try {
    const stored = window.localStorage.getItem(THEME_KEY);
    return stored === 'light' ? 'light' : 'dark';
  } catch (error) {
    return 'dark';
  }
}

function applyTheme(theme) {
  const root = document.documentElement;
  root.classList.remove('dark', 'light');
  root.classList.add(theme === 'light' ? 'light' : 'dark');
}

function saveTheme(theme) {
  try {
    window.localStorage.setItem(THEME_KEY, theme);
  } catch (error) {
    // Ignore storage write issues in restricted browsers.
  }
}

function initThemeToggle() {
  const toggles = document.querySelectorAll('[data-theme-toggle]');

  if (!toggles.length) {
    applyTheme(getPreferredTheme());
    return;
  }

  applyTheme(getPreferredTheme());

  const syncThemeState = () => {
    const isDark = document.documentElement.classList.contains('dark');

    toggles.forEach((toggle) => {
      const icon = toggle.querySelector('[data-theme-icon]');

      if (icon) {
        icon.innerHTML = isDark
          ? '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />'
          : '<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 3v1.5m0 15V21m6.364-15.364l-1.06 1.06M6.696 17.304l-1.06 1.06M21 12h-1.5m-15 0H3m15.364 5.304l-1.06-1.06M6.696 6.696l-1.06-1.06M12 16.25a4.25 4.25 0 100-8.5 4.25 4.25 0 000 8.5z" />';
      }

      const nextMode = isDark ? 'light' : 'dark';
      toggle.setAttribute('title', `Aktifkan mode ${nextMode}`);
      toggle.setAttribute('aria-label', `Aktifkan mode ${nextMode}`);
    });
  };

  toggles.forEach((toggle) => {
    toggle.addEventListener('click', () => {
      const isDark = document.documentElement.classList.contains('dark');
      const nextTheme = isDark ? 'light' : 'dark';

      applyTheme(nextTheme);
      saveTheme(nextTheme);
      syncThemeState();
      document.dispatchEvent(new Event('theme:changed'));
    });
  });

  syncThemeState();
}

function initSidebar() {
  const body = document.body;
  const toggles = document.querySelectorAll('[data-sidebar-toggle]');
  const overlay = document.querySelector('[data-sidebar-overlay]');

  const openSidebar = () => body.classList.add('sidebar-open');
  const closeSidebar = () => body.classList.remove('sidebar-open');

  toggles.forEach((toggle) => {
    toggle.addEventListener('click', () => {
      if (body.classList.contains('sidebar-open')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });
  });

  overlay?.addEventListener('click', closeSidebar);

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeSidebar();
    }
  });
}

function initDialogs() {
  const openButtons = document.querySelectorAll('[data-dialog-open]');

  openButtons.forEach((button) => {
    button.addEventListener('click', () => {
      const target = button.getAttribute('data-dialog-open');
      const dialog = target ? document.getElementById(target) : null;

      if (dialog && typeof dialog.showModal === 'function') {
        dialog.showModal();
      }
    });
  });

  document.querySelectorAll('dialog').forEach((dialog) => {
    dialog.addEventListener('click', (event) => {
      const rect = dialog.getBoundingClientRect();
      const clickedInside =
        rect.top <= event.clientY &&
        event.clientY <= rect.top + rect.height &&
        rect.left <= event.clientX &&
        event.clientX <= rect.left + rect.width;

      if (!clickedInside) {
        dialog.close();
      }
    });

    dialog.querySelectorAll('[data-dialog-close]').forEach((closeButton) => {
      closeButton.addEventListener('click', () => dialog.close());
    });
  });
}

function createToastContainer() {
  let container = document.getElementById('app-toast-container');

  if (!container) {
    container = document.createElement('div');
    container.id = 'app-toast-container';
    container.className = 'fixed right-4 top-4 z-[70] flex w-[min(92vw,26rem)] flex-col gap-3';
    document.body.appendChild(container);
  }

  return container;
}

function pushToast({ title, message, tone = 'info' }) {
  const container = createToastContainer();
  const isDark = document.documentElement.classList.contains('dark');
  const palette = isDark
    ? {
      success: 'border-emerald-500/35 bg-emerald-500/10 text-emerald-200',
      error: 'border-rose-500/35 bg-rose-500/10 text-rose-200',
      info: 'border-brand-500/35 bg-brand-500/10 text-brand-200',
    }
    : {
      success: 'border-emerald-300 bg-emerald-50 text-emerald-900',
      error: 'border-rose-300 bg-rose-50 text-rose-900',
      info: 'border-brand-300 bg-brand-50 text-brand-900',
    };

  const closeButtonClass = isDark
    ? 'mt-0.5 rounded-lg px-2 py-1 text-xs font-semibold text-slate-300 hover:bg-slate-700/70'
    : 'mt-0.5 rounded-lg px-2 py-1 text-xs font-semibold text-slate-500 hover:bg-white/60';

  const closeLabel = 'Tutup';

  const toast = document.createElement('div');
  toast.className = `panel border ${palette[tone] ?? palette.info} translate-y-2 opacity-0 transition duration-300`;
  toast.innerHTML =
    '<div class="flex items-start justify-between gap-3 px-4 py-3">' +
    '<div>' +
    `<p class="text-sm font-semibold">${title}</p>` +
    `<p class="mt-1 text-sm leading-relaxed">${message}</p>` +
    '</div>' +
    `<button type="button" class="${closeButtonClass}">${closeLabel}</button>` +
    '</div>';

  const close = () => {
    toast.classList.add('translate-y-2', 'opacity-0');
    setTimeout(() => toast.remove(), 240);
  };

  toast.querySelector('button')?.addEventListener('click', close);
  container.appendChild(toast);

  requestAnimationFrame(() => {
    toast.classList.remove('translate-y-2', 'opacity-0');
  });

  setTimeout(close, 4500);
}

function initFlash() {
  if (window.__flashStatus) {
    pushToast({
      title: 'Berhasil',
      message: String(window.__flashStatus),
      tone: 'success',
    });
  }

  if (Array.isArray(window.__flashErrors) && window.__flashErrors.length > 0) {
    window.__flashErrors.forEach((errorMessage) => {
      pushToast({
        title: 'Perlu Perhatian',
        message: String(errorMessage),
        tone: 'error',
      });
    });
  }
}

function bindConfirmForms() {
  document.querySelectorAll('form.js-confirm').forEach((form) => {
    form.addEventListener('submit', (event) => {
      event.preventDefault();

      const title = form.dataset.confirmTitle || 'Lanjutkan tindakan ini?';
      const body = form.dataset.confirmText || 'Perubahan data akan langsung disimpan.';
      const buttonLabel = form.dataset.confirmButton || 'lanjut';

      if (window.confirm(`${title}\n\n${body}\n\nTekan OK untuk ${buttonLabel}.`)) {
        form.submit();
      }
    });
  });
}

function initDocsTabs() {
  const root = document.querySelector('[data-docs-root]');
  if (!root) {
    return;
  }

  const buttons = Array.from(root.querySelectorAll('[data-docs-tab-button]'));
  const panels = Array.from(root.querySelectorAll('[data-docs-tab-panel]'));
  const lightClasses = ['bg-brand-50', 'text-brand-700', 'border-brand-200'];
  const darkClasses = ['bg-brand-500/15', 'text-brand-300', 'border-brand-500/30'];

  const activateTab = (targetId) => {
    const isDark = document.documentElement.classList.contains('dark');

    buttons.forEach((button) => {
      const isActive = button.dataset.docsTabButton === targetId;

      button.classList.remove(...lightClasses, ...darkClasses);
      if (isActive) {
        button.classList.add(...(isDark ? darkClasses : lightClasses));
      }
    });

    panels.forEach((panel) => {
      panel.classList.toggle('hidden', panel.dataset.docsTabPanel !== targetId);
    });
  };

  buttons.forEach((button) => {
    button.addEventListener('click', () => {
      activateTab(button.dataset.docsTabButton);
    });
  });

  if (buttons[0]) {
    activateTab(buttons[0].dataset.docsTabButton);
  }

  document.addEventListener('theme:changed', () => {
    const current = buttons.find((button) =>
      button.classList.contains('bg-brand-50') || button.classList.contains('bg-brand-500/15'),
    );

    if (current) {
      activateTab(current.dataset.docsTabButton);
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  initThemeToggle();
  initSidebar();
  initDialogs();
  initFlash();
  bindConfirmForms();
  initDocsTabs();
});
