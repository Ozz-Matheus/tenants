<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Pages\CreateDocRecovery;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Pages\EditDocRecovery;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Pages\ListDocRecoveries;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Schemas\DocRecoveryForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Tables\DocRecoveriesTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\DocRecovery;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DocRecoveryResource extends Resource
{
    protected static ?string $model = DocRecovery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('Doc Recovery');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Doc Recoveries');
    }

    public static function getNavigationLabel(): string
    {
        return __('Doc Recoveries');
    }

    public static function getNavigationGroup(): string
    {
        return __('Document Management');
    }

    public static function form(Schema $schema): Schema
    {
        return DocRecoveryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocRecoveriesTable::configure($table);
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
            'index' => ListDocRecoveries::route('/'),
            'create' => CreateDocRecovery::route('/create'),
            'edit' => EditDocRecovery::route('/{record}/edit'),
        ];
    }
}
