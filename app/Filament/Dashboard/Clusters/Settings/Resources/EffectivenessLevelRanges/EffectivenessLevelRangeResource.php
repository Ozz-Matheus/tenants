<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges;

use App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Pages\CreateEffectivenessLevelRange;
use App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Pages\EditEffectivenessLevelRange;
use App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Pages\ListEffectivenessLevelRanges;
use App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Schemas\EffectivenessLevelRangeForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Tables\EffectivenessLevelRangesTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\EffectivenessLevelRange;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EffectivenessLevelRangeResource extends Resource
{
    protected static ?string $model = EffectivenessLevelRange::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'effectiveness_level';

    protected static ?int $navigationSort = 8;

    public static function getModelLabel(): string
    {
        return __('Effectiveness Level Range');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Effectiveness Level Ranges');
    }

    public static function getNavigationLabel(): string
    {
        return __('Effectiveness Level Ranges');
    }

    public static function getNavigationGroup(): string
    {
        return __('Risk Management');
    }

    public static function form(Schema $schema): Schema
    {
        return EffectivenessLevelRangeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EffectivenessLevelRangesTable::configure($table);
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
            'index' => ListEffectivenessLevelRanges::route('/'),
            'create' => CreateEffectivenessLevelRange::route('/create'),
            'edit' => EditEffectivenessLevelRange::route('/{record}/edit'),
        ];
    }
}
