// Gestion du thème clair / sombre / système. La classe .dark sur <html> pilote tout le CSS
// (variables de couleur + surcharges Tailwind dans app.css). La préférence est mémorisée dans
// localStorage ; "system" (par défaut) suit le thème du système et se met à jour en direct si
// l'utilisateur change de thème OS pendant que la page est ouverte.
const STORAGE_KEY = 'theme';
const media = window.matchMedia('(prefers-color-scheme: dark)');

function effectiveIsDark(pref) {
    return pref === 'dark' || (pref === 'system' && media.matches);
}

function applyTheme(pref) {
    document.documentElement.classList.toggle('dark', effectiveIsDark(pref));
    document.querySelectorAll('[data-theme-option]').forEach((btn) => {
        const active = btn.dataset.themeOption === pref;
        btn.setAttribute('aria-pressed', active ? 'true' : 'false');
        btn.classList.toggle('theme-toggle-active', active);
    });
}

window.setTheme = function (pref) {
    localStorage.setItem(STORAGE_KEY, pref);
    applyTheme(pref);
};

document.addEventListener('DOMContentLoaded', () => {
    applyTheme(localStorage.getItem(STORAGE_KEY) || 'system');
});

media.addEventListener('change', () => {
    if ((localStorage.getItem(STORAGE_KEY) || 'system') === 'system') {
        applyTheme('system');
    }
});

document.addEventListener('click', (event) => {
    const btn = event.target.closest('[data-theme-option]');
    if (btn) {
        window.setTheme(btn.dataset.themeOption);
    }
});
