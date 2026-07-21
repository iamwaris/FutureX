/**
 * Computes each stream's next real occurrence from its ISO weekday +
 * UTC hour, displays it in the visitor's own local time (the brief's
 * "timezone conversion" requirement), and live-ticks a countdown to
 * the soonest one. Placeholder schedule data lives in the Blade view;
 * this only does the date math.
 */
function nextOccurrence(weekday, hourUTC) {
    const now = new Date();
    const currentWeekdayUTC = now.getUTCDay() === 0 ? 7 : now.getUTCDay();

    let dayDiff = weekday - currentWeekdayUTC;

    const result = new Date(now);
    result.setUTCDate(now.getUTCDate() + dayDiff);
    result.setUTCHours(hourUTC, 0, 0, 0);

    if (result <= now) {
        result.setUTCDate(result.getUTCDate() + 7);
    }

    return result;
}

function formatCountdown(ms) {
    if (ms <= 0) {
        return 'Starting soon';
    }

    const hours = Math.floor(ms / 3_600_000);
    const minutes = Math.floor((ms % 3_600_000) / 60_000);
    const seconds = Math.floor((ms % 60_000) / 1000);

    if (hours > 0) {
        return `${hours}h ${minutes}m`;
    }

    return `${minutes}m ${seconds}s`;
}

export function initSchedule() {
    const cards = document.querySelectorAll('.schedule-day');

    if (cards.length === 0) {
        return;
    }

    const todayWeekdayLocal = new Date().getDay() === 0 ? 7 : new Date().getDay();
    let soonest = null;

    cards.forEach((card) => {
        const weekday = parseInt(card.dataset.weekday, 10);

        if (weekday === todayWeekdayLocal) {
            card.classList.add('schedule-today');
        }

        if (card.dataset.hourUtc === undefined) {
            return;
        }

        const occurrence = nextOccurrence(weekday, parseInt(card.dataset.hourUtc, 10));
        const timeEl = card.querySelector('.local-time');

        if (timeEl) {
            timeEl.textContent = occurrence.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        }

        if (!soonest || occurrence < soonest) {
            soonest = occurrence;
        }
    });

    const countdownEl = document.querySelector('[data-countdown]');

    if (!countdownEl || !soonest) {
        return;
    }

    const tick = () => {
        countdownEl.textContent = formatCountdown(soonest - new Date());
    };

    tick();
    setInterval(tick, 1000);
}
