<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts;

use App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Pages\CreateStrategicContext;
use App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Pages\EditStrategicContext;
use App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Pages\ListStrategicContexts;
use App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Schemas\StrategicContextForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Tables\StrategicContextsTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\StrategicContext;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StrategicContextResource extends Resource
{
    protected static ?string $model = StrategicContext::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return StrategicContextForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StrategicContextsTable::configure($table);
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
            'index' => ListStrategicContexts::route('/'),
            'create' => CreateStrategicContext::route('/create'),
            'edit' => EditStrategicContext::route('/{record}/edit'),
        ];
    }
}
