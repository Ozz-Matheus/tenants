<x-filament-panels::page.simple>
    <x-slot name="heading">
        {{ $this->getHeading() }}
    </x-slot>

    <x-slot name="subheading">
        {{$this->getSubHeading()}}
    </x-slot>

    <form wire:submit="store" class="space-y-6">

        {{ $this->form }}

        <x-filament::button type="submit" class="w-full">
            {{ $this->getHeading() }}
        </x-filament::button>

    </form>
</x-filament-panels::page.simple>