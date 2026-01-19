import './bootstrap';

const toggleTheme = () => {
    const html = document.documentElement;
    const isDark = html.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    updateThemeIcons();
};

const updateThemeIcons = () => {
    const isDark = document.documentElement.classList.contains('dark');
    document.querySelectorAll('[data-theme-icon="dark"]').forEach((icon) => {
        icon.classList.toggle('hidden', !isDark);
    });
    document.querySelectorAll('[data-theme-icon="light"]').forEach((icon) => {
        icon.classList.toggle('hidden', isDark);
    });
};

const setupDropdowns = () => {
    document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
        const trigger = dropdown.querySelector('[data-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-dropdown-menu]');

        if (!trigger || !menu) {
            return;
        }

        const close = () => menu.classList.add('hidden');
        const open = () => menu.classList.remove('hidden');

        trigger.addEventListener('click', (event) => {
            event.stopPropagation();
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', close);
        dropdown.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                close();
                trigger.focus();
            }
        });
    });
};

const setupMobileNav = () => {
    const toggle = document.querySelector('[data-mobile-nav-toggle]');
    const nav = document.querySelector('[data-mobile-nav]');

    if (!toggle || !nav) {
        return;
    }

    toggle.addEventListener('click', () => {
        nav.classList.toggle('hidden');
    });
};

const setupFlash = () => {
    document.querySelectorAll('[data-flash]').forEach((el) => {
        setTimeout(() => {
            el.classList.add('hidden');
        }, 2000);
    });
};

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', toggleTheme);
    });

    updateThemeIcons();
    setupDropdowns();
    setupMobileNav();
    setupFlash();
});
