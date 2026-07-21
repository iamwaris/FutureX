import gsap from 'gsap';

function motionScale() {
    const raw = getComputedStyle(document.documentElement).getPropertyValue('--motion-scale');
    const value = parseFloat(raw);
    return Number.isNaN(value) ? 1 : value;
}

function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
}

function initScrollReveal() {
    const targets = document.querySelectorAll('[data-animate]');

    if (motionScale() === 0 || prefersReducedMotion()) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -10% 0px' },
    );

    targets.forEach((el) => observer.observe(el));
}

/**
 * Subtle "magnetic" pull toward the cursor on primary CTAs — one of the
 * motion patterns the design brief explicitly calls for. Disabled under
 * reduced motion or when the animation intensity token is "none".
 */
function initMagneticButtons() {
    if (motionScale() === 0 || prefersReducedMotion()) {
        return;
    }

    document.querySelectorAll('[data-magnetic]').forEach((el) => {
        const strength = 0.25 * motionScale();

        el.addEventListener('mousemove', (event) => {
            const bounds = el.getBoundingClientRect();
            const x = event.clientX - bounds.left - bounds.width / 2;
            const y = event.clientY - bounds.top - bounds.height / 2;

            gsap.to(el, {
                x: x * strength,
                y: y * strength,
                duration: 0.3,
                ease: 'power2.out',
            });
        });

        el.addEventListener('mouseleave', () => {
            gsap.to(el, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.4)' });
        });
    });
}

function initCounters() {
    const counters = document.querySelectorAll('[data-counter-to]');

    if (counters.length === 0) {
        return;
    }

    const animate = (el) => {
        const target = parseFloat(el.dataset.counterTo);
        const duration = (motionScale() === 0 ? 0 : 1.2 * Math.max(motionScale(), 0.4)) * 1000;

        if (prefersReducedMotion() || duration === 0) {
            el.textContent = target.toLocaleString();
            return;
        }

        const proxy = { value: 0 };

        gsap.to(proxy, {
            value: target,
            duration: duration / 1000,
            ease: 'power2.out',
            onUpdate: () => {
                el.textContent = Math.round(proxy.value).toLocaleString();
            },
        });
    };

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animate(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.4 },
    );

    counters.forEach((el) => observer.observe(el));
}

document.addEventListener('DOMContentLoaded', () => {
    initScrollReveal();
    initMagneticButtons();
    initCounters();
});
