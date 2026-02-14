<?php

namespace App\Filament\Dashboard\Resources\Headquarters;

use App\Filament\Dashboard\Resources\Headquarters\Pages\CreateHeadquarter;
use App\Filament\Dashboard\Resources\Headquarters\Pages\EditHeadquarter;
use App\Filament\Dashboard\Resources\Headquarters\Pages\ListHeadquarters;
use App\Filament\Dashboard\Resources\Headquarters\Schemas\HeadquarterForm;
use App\Filament\Dashboard\Resources\Headquarters\Tables\HeadquartersTable;
use App\Models\Headquarter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HeadquarterResource extends Resource
{
    protected static ?string $model = Headquarter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog8Tooth;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 44;

    public static function getModelLabel(): string
    {
        return __('headquarter.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('headquarter.plural_model_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('headquarter.plural_model_label');
    }

    public static function getNavigationGroup(): string
    {
        return __('headquarter.navigation_group');
    }

    public static function form(Schema $schema): Schema
    {
        return HeadquarterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HeadquartersTable::configure($table);
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
            'index' => ListHeadquarters::route('/'),
            'create' => CreateHeadquarter::route('/create'),
            'edit' => EditHeadquarter::route('/{record}/edit'),
        ];
    }
}
