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

const setupCountdowns = () => {
    document.querySelectorAll('[data-countdown]').forEach((el) => {
        const endsAt = new Date(el.dataset.endsAt);

        const tick = () => {
            const diff = endsAt - new Date();
            if (Number.isNaN(diff)) {
                return;
            }
            if (diff <= 0) {
                el.textContent = '00:00';
                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            el.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        };

        tick();
        setInterval(tick, 1000);
    });
};

const setupClassSubjectFilter = () => {
    const classSelects = document.querySelectorAll('[data-class-room-select]');
    const subjectSelects = document.querySelectorAll('[data-subject-select]');

    if (!classSelects.length || !subjectSelects.length) {
        return;
    }

    const updateSubjects = (classSelect, subjectSelect) => {
        const classId = classSelect.value;
        const options = subjectSelect.querySelectorAll('option[data-classes]');

        options.forEach((option) => {
            const classes = option.dataset.classes ? option.dataset.classes.split(',') : [];
            const isAllowed = classId && classes.includes(classId);
            option.hidden = !isAllowed;
            if (!isAllowed && option.selected) {
                option.selected = false;
            }
        });
    };

    classSelects.forEach((classSelect) => {
        const subjectSelect = classSelect.closest('form')?.querySelector('[data-subject-select]');
        if (!subjectSelect) {
            return;
        }

        updateSubjects(classSelect, subjectSelect);
        classSelect.addEventListener('change', () => updateSubjects(classSelect, subjectSelect));
    });
};

const setupQuestionTypeToggle = () => {
    document.querySelectorAll('[data-question-type]').forEach((select) => {
        const form = select.closest('form');
        const choiceFields = form?.querySelector('[data-choice-fields]');
        if (!choiceFields) {
            return;
        }

        const update = () => {
            choiceFields.classList.toggle('hidden', select.value === 'text');
        };

        update();
        select.addEventListener('change', update);
    });
};

const setupPasswordResetToggle = () => {
    document.querySelectorAll('[data-reset-password-toggle]').forEach((button) => {
        const container = button.closest('div')?.parentElement;
        const fields = container?.querySelector('[data-reset-password-fields]');
        if (!fields) {
            return;
        }

        button.addEventListener('click', () => {
            const isHidden = fields.classList.toggle('hidden');
            if (isHidden) {
                fields.querySelectorAll('input').forEach((input) => {
                    input.value = '';
                });
            }
        });
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
    setupCountdowns();
    setupClassSubjectFilter();
    setupQuestionTypeToggle();
    setupPasswordResetToggle();
});
