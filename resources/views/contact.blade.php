@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl px-6" style="padding-block: var(--section-spacing);">
        <x-eyebrow icon="tag">Business Inquiries</x-eyebrow>
        <h1 class="font-heading text-4xl font-bold text-text-primary sm:text-5xl">Let's Work Together</h1>
        <p class="mt-4 font-body text-lg text-text-secondary">
            Sponsorships, product placements, event appearances — tell us about the campaign and we'll
            follow up within 48 hours. Prefer the numbers first? Check the
            <a href="{{ route('media-kit') }}" class="text-text-primary underline">Media Kit</a>.
        </p>

        <div class="mt-10">
            @livewire('contact-form')
        </div>
    </div>
@endsection
