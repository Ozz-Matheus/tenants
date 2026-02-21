<?php

namespace App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements;

use App\Filament\Dashboard\Clusters\OrganizationContext\OrganizationContextCluster;
use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Pages\CreateLegalRequirement;
use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Pages\EditLegalRequirement;
use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Pages\ListLegalRequirements;
use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Schemas\LegalRequirementForm;
use App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Tables\LegalRequirementsTable;
use App\Models\LegalRequirement;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LegalRequirementResource extends Resource
{
    protected static ?string $model = LegalRequirement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Scale;

    protected static ?string $cluster = OrganizationContextCluster::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('legal_requirement.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('legal_requirement.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return LegalRequirementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LegalRequirementsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLegalRequirements::route('/'),
            'create' => CreateLegalRequirement::route('/create'),
            'edit' => EditLegalRequirement::route('/{record}/edit'),
        ];
    }
}
