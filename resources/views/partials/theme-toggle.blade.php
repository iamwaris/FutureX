<button
    type="button"
    x-data="{
        light: localStorage.getItem('creatoros-theme') === 'light',
        toggle() {
            this.light = !this.light;
            localStorage.setItem('creatoros-theme', this.light ? 'light' : 'dark');
            document.documentElement.classList.toggle('dark', !this.light);
        },
    }"
    x-on:click="toggle()"
    class="flex h-9 w-9 items-center justify-center border border-border text-text-secondary transition hover:text-text-primary"
    style="border-radius: var(--radius-base);"
    aria-label="Toggle light and dark mode"
>
    <svg x-show="light" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
    <svg x-show="!light" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
    </svg>
</button>
