<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold mb-2">Roles del usuario:</h2>
        <ul class="list-disc list-inside">
            @forelse ($roles as $role)
                <li>{{ $role }}</li>
            @empty
                <li>No tiene roles asignados.</li>
            @endforelse
        </ul>
        <h2 class="text-lg font-bold mb-2">Permisos vía Roles:</h2>
        <ul class="list-disc list-inside">
            @foreach ($permissionsViaRoles as $permission)
                <li>{{ $permission->name }}</li>
            @endforeach
        </ul>
    </x-filament::card>
</x-filament::widget>
