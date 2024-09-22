<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <x-filament::button type="submit">
            Save Mail Settings
        </x-filament::button>
    </form>
</x-filament::page>
