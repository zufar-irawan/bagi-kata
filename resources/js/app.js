const THEME_STORAGE_KEY = 'bagi-kata-appearance';
const APPEARANCE_OPTIONS = ['light', 'dark', 'system'];

const applyAppearance = (value) => {
    const appearance = APPEARANCE_OPTIONS.includes(value) ? value : 'system';
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    document.documentElement.setAttribute('data-flux-appearance', appearance);

    if (appearance === 'dark') {
        document.documentElement.classList.add('dark');
    } else if (appearance === 'light') {
        document.documentElement.classList.remove('dark');
    } else {
        document.documentElement.classList.toggle('dark', prefersDark);
    }

    document.querySelectorAll('[data-appearance-option]').forEach((item) => {
        const isActive = item.dataset.appearanceOption === appearance;
        item.classList.toggle('font-semibold', isActive);
        item.classList.toggle('text-zinc-900', isActive);
        item.classList.toggle('dark:text-zinc-100', isActive);
        item.setAttribute('aria-checked', isActive ? 'true' : 'false');

        const check = item.querySelector('[data-appearance-check]');
        if (check) {
            check.classList.toggle('hidden', !isActive);
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const stored = localStorage.getItem(THEME_STORAGE_KEY);
    applyAppearance(stored || 'system');

    document.querySelectorAll('[data-appearance-option]').forEach((item) => {
        item.addEventListener('click', () => {
            const value = item.dataset.appearanceOption || 'system';
            localStorage.setItem(THEME_STORAGE_KEY, value);
            applyAppearance(value);
        });
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        const storedAppearance = localStorage.getItem(THEME_STORAGE_KEY) || 'system';
        if (storedAppearance === 'system') {
            applyAppearance('system');
        }
    });
});
