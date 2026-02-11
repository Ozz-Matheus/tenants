<?php

namespace App\Filament\Admin\Resources\Tenants\Pages;

use App\Filament\Admin\Resources\Tenants\TenantResource;
use App\Services\TenantCreatorService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected static bool $canCreateAnother = false;

    // Propiedad para controlar el flujo entre métodos
    protected bool $isLinkingExisting = false;

    protected function handleRecordCreation(array $data): Model
    {
        // Agregamos el owner
        $data['owner_by_id'] = auth()->id();

        // Detectamos si es importación basada en el Toggle del form
        $this->isLinkingExisting = $data['link_existing_db'] ?? false;

        if ($this->isLinkingExisting) {
            // FLUJO A: Importar DB existente
            // TenantCreatorService::create se encarga de saveQuietly, dominios y setup completo.
            return TenantCreatorService::create($data);
        }

        // FLUJO B: Crear nuevo Tenant
        // Dejamos que el paquete tenacy cree el tenant, database y lance los seeds.
        $record = parent::handleRecordCreation(collect($data)->except(['domain', 'link_existing_db'])->toArray());
        $record->domains()->create(['domain' => $data['domain']]);

        return $record;
    }

    protected function afterCreate(): void
    {
        // FLUJO A :
        // Si importamos una DB existente, el Service ya hizo todo el setup. Salimos.
        if ($this->isLinkingExisting) {
            return;
        }

        // 2. Configurar el Super Admin solamente.
        TenantCreatorService::setup(
            $this->record,
            runMigrations: false,
            runSeeds: false
        );
    }
}
