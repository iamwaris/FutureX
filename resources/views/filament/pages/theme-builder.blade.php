<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="mt-6 flex justify-end">
            <x-filament::button type="submit">
                Save Theme
            </x-filament::button>
        </div>
    </form>

    <div
        class="mt-8"
        x-data
        x-on:theme-updated.window="$refs.preview.src = $refs.preview.src"
    >
        <h2 class="mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
            Live Preview
        </h2>
        <iframe
            x-ref="preview"
            src="{{ route('home') }}"
            class="h-[720px] w-full rounded-xl border border-gray-200 dark:border-gray-700"
        ></iframe>
    </div>
</x-filament-panels::page>
