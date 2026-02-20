<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues;

use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Pages\CreateItemValue;
use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Pages\EditItemValue;
use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Pages\ListItemValues;
use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Schemas\ItemValueForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Tables\ItemValuesTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\ItemValue;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemValueResource extends Resource
{
    protected static ?string $model = ItemValue::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 7;

    public static function getModelLabel(): string
    {
        return __('Item Value');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Item Values');
    }

    public static function getNavigationLabel(): string
    {
        return __('Item Values');
    }

    public static function getNavigationGroup(): string
    {
        return __('Risk Management');
    }

    public static function form(Schema $schema): Schema
    {
        return ItemValueForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemValuesTable::configure($table);
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
            'index' => ListItemValues::route('/'),
            'create' => CreateItemValue::route('/create'),
            'edit' => EditItemValue::route('/{record}/edit'),
        ];
    }
}
