<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Pages\CreateDocType;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Pages\EditDocType;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Pages\ListDocTypes;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Schemas\DocTypeForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocTypes\Tables\DocTypesTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\DocType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DocTypeResource extends Resource
{
    protected static ?string $model = DocType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('doc.type.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('doc.type.plural_model_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('doc.type.plural_model_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('doc.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return DocTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocTypesTable::configure($table);
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
            'index' => ListDocTypes::route('/'),
            'create' => CreateDocType::route('/create'),
            'edit' => EditDocType::route('/{record}/edit'),
        ];
    }
}
