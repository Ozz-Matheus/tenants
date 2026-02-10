<x-filament-panels::page.simple>
    <x-slot name="heading">
        {{ $this->getHeading() }}
    </x-slot>

    <x-slot name="subheading">
        {{$this->getSubHeading()}}
    </x-slot>

    <form wire:submit="store" class="space-y-6">

        {{ $this->form }}
        <div class="noUi-pips-horizontal">
            <div class="CodeMirror-lines">
                <x-filament::button type="submit" class="w-full" color="info">
                    {{ $this->getHeading() }}
                </x-filament::button>
            </div>
        </div>
    </form>
</x-filament-panels::page.simple>