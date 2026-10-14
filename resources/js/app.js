document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
    const toggle = dropdown.querySelector('[data-dropdown-toggle]');
    const menu = dropdown.querySelector('[data-dropdown-menu]');

    if (!toggle || !menu) {
        return;
    }

    const closeMenu = () => {
        menu.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';

        document.querySelectorAll('[data-dropdown]').forEach((otherDropdown) => {
            otherDropdown.querySelector('[data-dropdown-menu]')?.classList.remove('is-open');
            otherDropdown.querySelector('[data-dropdown-toggle]')?.setAttribute('aria-expanded', 'false');
        });

        if (!isOpen) {
            menu.classList.add('is-open');
            toggle.setAttribute('aria-expanded', 'true');
        }
    });

    document.addEventListener('click', (event) => {
        if (event.target instanceof Node && !dropdown.contains(event.target)) {
            closeMenu();
        }
    });

    dropdown.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
            toggle.focus();
        }
    });
});

document.querySelectorAll('[data-carousel]').forEach((carousel) => {
    const slides = Array.from(carousel.querySelectorAll('[data-carousel-slide]'));
    const previousButton = carousel.querySelector('[data-carousel-prev]');
    const nextButton = carousel.querySelector('[data-carousel-next]');

    if (slides.length === 0 || !previousButton || !nextButton) {
        return;
    }

    let activeSlide = 0;

    const showSlide = (index) => {
        activeSlide = (index + slides.length) % slides.length;

        slides.forEach((slide, slideIndex) => {
            slide.setAttribute('aria-hidden', String(slideIndex !== activeSlide));
        });
    };

    previousButton.addEventListener('click', () => showSlide(activeSlide - 1));
    nextButton.addEventListener('click', () => showSlide(activeSlide + 1));
    showSlide(activeSlide);

    let slideInterval = window.setInterval(() => showSlide(activeSlide + 1), 5000);
    const resetTimer = () => {
        window.clearInterval(slideInterval);
        slideInterval = window.setInterval(() => showSlide(activeSlide + 1), 5000);
    };

    previousButton.addEventListener('click', resetTimer);
    nextButton.addEventListener('click', resetTimer);
});

const dependencyFilter = document.querySelector('#select-dependencia');

if (dependencyFilter instanceof HTMLSelectElement) {
    const directorCards = document.querySelectorAll('.director-card[data-dependencia]');

    dependencyFilter.addEventListener('change', () => {
        directorCards.forEach((card) => {
            card.hidden = dependencyFilter.value !== 'todas'
                && card.getAttribute('data-dependencia') !== dependencyFilter.value;
        });
    });
}

let fontSize = 100;
const fontSizeStep = 5;
const minimumFontSize = 90;
const maximumFontSize = 130;
const increaseFontButton = document.querySelector('#btn-increase-font');
const decreaseFontButton = document.querySelector('#btn-decrease-font');
const contrastButton = document.querySelector('#btn-contrast');

increaseFontButton?.addEventListener('click', () => {
    fontSize = Math.min(fontSize + fontSizeStep, maximumFontSize);
    document.documentElement.style.fontSize = `${fontSize}%`;
});

decreaseFontButton?.addEventListener('click', () => {
    fontSize = Math.max(fontSize - fontSizeStep, minimumFontSize);
    document.documentElement.style.fontSize = `${fontSize}%`;
});

contrastButton?.addEventListener('click', () => {
    const isHighContrast = document.body.classList.toggle('high-contrast');
    contrastButton.setAttribute('aria-pressed', String(isHighContrast));
});
