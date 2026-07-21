@php
    $socialLinks = [
        ['label' => 'Twitch', 'href' => '#'],
        ['label' => 'YouTube', 'href' => '#'],
        ['label' => 'Discord', 'href' => '#'],
        ['label' => 'X', 'href' => '#'],
        ['label' => 'Instagram', 'href' => '#'],
        ['label' => 'TikTok', 'href' => '#'],
    ];
@endphp

<footer class="border-t border-border">
    <div class="mx-auto max-w-[1440px] px-6 py-16">
        <div class="flex flex-col gap-10 lg:flex-row lg:justify-between">
            <div class="max-w-sm">
                <p class="font-heading text-lg font-bold text-text-primary">{{ config('app.name') }}</p>
                <p class="mt-3 font-body text-sm text-text-secondary">
                    Business inquiries: <a href="mailto:business@example.com" class="text-text-primary hover:underline">business@example.com</a>
                </p>
            </div>

            <div class="flex flex-wrap gap-x-8 gap-y-4">
                @foreach ($socialLinks as $link)
                    <a
                        href="{{ $link['href'] }}"
                        class="font-body text-sm text-text-secondary transition hover:text-text-primary"
                    >
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-12 flex flex-col gap-4 border-t border-border pt-6 text-sm text-text-muted sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-text-secondary">Privacy</a>
                <a href="#" class="hover:text-text-secondary">Terms</a>
            </div>
        </div>
    </div>
</footer>
