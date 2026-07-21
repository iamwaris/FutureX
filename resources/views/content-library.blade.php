@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-[1440px] px-6" style="padding-block: var(--section-spacing);">
        <x-eyebrow icon="play">Content Library</x-eyebrow>
        <h1 class="font-heading text-4xl font-bold text-text-primary sm:text-5xl">Watch Everything</h1>
        <p class="mt-4 max-w-2xl font-body text-lg text-text-secondary">
            Every video, clip, short, and stream VOD in one place — search, filter by category, or
            browse by type.
        </p>

        <div class="mt-10">
            @livewire('content-library')
        </div>
    </div>
@endsection
