@php
    $navLinks = [
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'About', 'href' => '#about'],
        ['label' => 'Content', 'href' => route('content-library')],
        ['label' => 'Schedule', 'href' => '#schedule'],
        ['label' => 'Community', 'href' => '#community'],
        ['label' => 'Sponsors', 'href' => route('sponsors')],
        ['label' => 'Shop', 'href' => '#shop'],
        ['label' => 'Contact', 'href' => route('contact')],
    ];
@endphp

<header
    x-data="{ mobileOpen: false }"
    class="sticky top-0 z-50 border-b border-border bg-background/80 backdrop-blur"
>
    <nav class="mx-auto flex max-w-[1440px] items-center justify-between gap-4 px-6 py-4">
        <a href="/" class="font-heading text-lg font-bold text-text-primary">
            {{ config('app.name') }}
        </a>

        <ul class="hidden items-center gap-6 lg:flex">
            @foreach ($navLinks as $link)
                <li>
                    <a
                        href="{{ $link['href'] }}"
                        class="font-body text-sm text-text-secondary transition hover:text-text-primary"
                    >
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="hidden items-center gap-4 lg:flex">
            @livewire('nav-live-indicator')

            @include('partials.theme-toggle')

            <a
                href="#live-status"
                data-magnetic
                class="bg-primary px-5 py-2.5 font-body text-sm font-semibold text-white transition hover:-translate-y-0.5"
                style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
            >
                Watch Live
            </a>
        </div>

        <button
            type="button"
            class="text-text-primary lg:hidden"
            x-on:click="mobileOpen = !mobileOpen"
            aria-label="Toggle navigation menu"
        >
            <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </nav>

    <div
        x-show="mobileOpen"
        x-cloak
        x-transition
        class="border-t border-border px-6 pb-6 lg:hidden"
    >
        <ul class="flex flex-col gap-4 pt-4">
            @foreach ($navLinks as $link)
                <li>
                    <a
                        href="{{ $link['href'] }}"
                        x-on:click="mobileOpen = false"
                        class="font-body text-text-secondary transition hover:text-text-primary"
                    >
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mt-6 flex items-center justify-between">
            @include('partials.theme-toggle')

            <a
                href="#live-status"
                class="bg-primary px-5 py-2.5 font-body text-sm font-semibold text-white"
                style="border-radius: var(--radius-base);"
            >
                Watch Live
            </a>
        </div>
    </div>
</header>
