@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-[1440px] px-6" style="padding-block: var(--section-spacing);">
        <x-eyebrow icon="calendar">Events</x-eyebrow>
        <h1 class="font-heading text-4xl font-bold text-text-primary sm:text-5xl">What's Coming Up</h1>
        <p class="mt-4 max-w-2xl font-body text-lg text-text-secondary">
            Streaming events, charity marathons, tournament appearances, and meet-and-greets.
        </p>

        <div class="mt-10">
            @livewire('events-calendar')
        </div>
    </div>
@endsection
