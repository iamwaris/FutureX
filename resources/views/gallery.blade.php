@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-[1440px] px-6" style="padding-block: var(--section-spacing);">
        <x-eyebrow icon="camera">Gallery</x-eyebrow>
        <h1 class="font-heading text-4xl font-bold text-text-primary sm:text-5xl">Behind the Scenes</h1>
        <p class="mt-4 max-w-2xl font-body text-lg text-text-secondary">
            Events, meetups, conventions, and everything else that doesn't fit in a stream.
        </p>

        <div class="mt-10">
            @livewire('gallery-grid')
        </div>
    </div>
@endsection
