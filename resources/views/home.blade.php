@extends('layouts.app')

@section('content')
    <main class="mx-auto max-w-[1440px] px-6" style="padding-block: var(--section-spacing);">
        <section class="flex flex-col items-start gap-6">
            <span class="rounded-full border border-border bg-surface px-4 py-1.5 text-sm text-text-secondary">
                Theme Engine — M1 preview
            </span>

            <h1 class="font-heading text-6xl font-bold leading-[1.05] text-text-primary">
                Every pixel here is a token,<br>not a hardcoded value.
            </h1>

            <p class="max-w-2xl font-body text-lg text-text-secondary">
                Colors, fonts, radius, shadows, and motion all come from the admin-editable
                theme settings. Change them in the Filament Theme Builder and reload — nothing
                on this page needs a code change to look completely different.
            </p>

            <div class="flex flex-wrap gap-4 pt-2">
                <button
                    class="bg-primary px-6 py-3 font-body font-semibold text-white transition hover:-translate-y-0.5"
                    style="border-radius: var(--radius-base); box-shadow: var(--shadow-elevation); transition-duration: calc(150ms * var(--motion-scale, 1));"
                >
                    Watch Live
                </button>
                <button
                    class="border border-border bg-transparent px-6 py-3 font-body font-semibold text-text-primary transition hover:-translate-y-0.5"
                    style="border-radius: var(--radius-base); transition-duration: calc(150ms * var(--motion-scale, 1));"
                >
                    Business Inquiries
                </button>
            </div>
        </section>

        <section class="mt-20 grid grid-cols-1 gap-6 sm:grid-cols-3">
            @foreach ([
                ['label' => 'Primary', 'var' => '--color-primary'],
                ['label' => 'Secondary', 'var' => '--color-secondary'],
                ['label' => 'Surface / Card', 'var' => '--color-card'],
            ] as $swatch)
                <div
                    class="bg-card p-6"
                    style="border: 1px solid var(--color-border); border-radius: var(--radius-base); box-shadow: var(--shadow-elevation);"
                >
                    <div
                        class="mb-4 h-12 w-12"
                        style="background: var({{ $swatch['var'] }}); border-radius: calc(var(--radius-base) / 2);"
                    ></div>
                    <p class="font-heading text-xl font-semibold text-text-primary">{{ $swatch['label'] }}</p>
                    <p class="font-body text-sm text-text-muted">{{ $swatch['var'] }}</p>
                </div>
            @endforeach
        </section>
    </main>
@endsection
