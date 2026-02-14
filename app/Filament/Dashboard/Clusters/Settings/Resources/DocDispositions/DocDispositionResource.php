<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions;

use App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Pages\CreateDocDisposition;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Pages\EditDocDisposition;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Pages\ListDocDispositions;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Schemas\DocDispositionForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Tables\DocDispositionsTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\DocDisposition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DocDispositionResource extends Resource
{
    protected static ?string $model = DocDisposition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('Doc Disposition');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Doc Dispositions');
    }

    public static function getNavigationLabel(): string
    {
        return __('Doc Dispositions');
    }

    public static function getNavigationGroup(): string
    {
        return __('Document Management');
    }

    public static function form(Schema $schema): Schema
    {
        return DocDispositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocDispositionsTable::configure($table);
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
            'index' => ListDocDispositions::route('/'),
            'create' => CreateDocDisposition::route('/create'),
            'edit' => EditDocDisposition::route('/{record}/edit'),
        ];
    }
}
