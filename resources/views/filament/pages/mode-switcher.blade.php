<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        @foreach ($modes as $mode)
            <div class="rounded-xl border border-gray-200 p-6 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-gray-950 dark:text-white">{{ $mode->label }}</h3>
                    @if ($activeModeKey === $mode->key)
                        <span class="rounded-full bg-primary-50 px-2.5 py-1 text-xs font-medium text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                            Active
                        </span>
                    @endif
                </div>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ $mode->description }}</p>

                <x-filament::button
                    class="mt-4"
                    color="gray"
                    :disabled="$activeModeKey === $mode->key"
                    wire:click="activate({{ $mode->id }})"
                >
                    {{ $activeModeKey === $mode->key ? 'Currently Active' : 'Activate' }}
                </x-filament::button>
            </div>
        @endforeach
    </div>

    @if ($activeModeKey)
        <div class="mt-6 rounded-xl border border-gray-200 p-6 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                A mode is currently active. Restoring will return the theme and homepage layout to
                exactly how they were before it was turned on.
            </p>
            <x-filament::button class="mt-4" color="danger" wire:click="deactivate">
                Restore Default
            </x-filament::button>
        </div>
    @endif
</x-filament-panels::page>
