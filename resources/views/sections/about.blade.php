@php
    $timeline = [
        ['year' => '2019', 'text' => 'Started streaming part-time alongside a full-time job.'],
        ['year' => '2021', 'text' => 'Hit 10K followers and went full-time creator.'],
        ['year' => '2023', 'text' => 'Signed first brand partnership and launched the community Discord.'],
        ['year' => '2025', 'text' => 'Ran the first charity marathon, raising funds for a local cause.'],
    ];
@endphp

<x-section id="about">
    <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
        <div>
            <x-eyebrow icon="camera">Our Journey</x-eyebrow>
            <h2 class="font-heading text-3xl font-bold text-text-primary sm:text-4xl">The Story So Far</h2>
            <p class="mt-6 font-body text-lg leading-relaxed text-text-secondary">
                What started as a way to unwind after work turned into a full-time career built on
                consistency, community, and a genuine love for the craft. Every stream, video, and
                collaboration is built around one mission: make this a place people want to belong to.
            </p>

            <div class="mt-8 grid grid-cols-3 gap-3">
                @for ($i = 0; $i < 3; $i++)
                    <div
                        class="relative flex aspect-square items-center justify-center overflow-hidden border border-border"
                        style="border-radius: var(--radius-base); background: linear-gradient(135deg, var(--color-primary), var(--color-secondary)); opacity: 0.85;"
                    >
                        <x-ui-icon name="camera" solid class="h-6 w-6 text-white/70" />
                    </div>
                @endfor
            </div>
            <a href="#" class="mt-3 flex items-center gap-1 font-body text-sm text-text-secondary hover:text-text-primary">
                View full gallery <x-ui-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <ol class="relative border-l border-border pl-8">
            @foreach ($timeline as $item)
                <li class="mb-10 last:mb-0">
                    <span
                        class="absolute -left-[7px] mt-1.5 h-3.5 w-3.5 rounded-full bg-primary"
                    ></span>
                    <p class="font-heading text-sm font-semibold text-text-muted">{{ $item['year'] }}</p>
                    <p class="mt-1 font-body text-text-primary">{{ $item['text'] }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</x-section>
