<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses;

use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Pages\CreateSubprocess;
use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Pages\EditSubprocess;
use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Pages\ListSubprocesses;
use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Schemas\SubprocessForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Tables\SubprocessesTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\Subprocess;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SubprocessResource extends Resource
{
    protected static ?string $model = Subprocess::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Subprocess');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Subprocesses');
    }

    public static function getNavigationLabel(): string
    {
        return __('Subprocesses');
    }

    public static function getNavigationGroup(): string
    {
        return __('Global Management');
    }

    public static function form(Schema $schema): Schema
    {
        return SubprocessForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubprocessesTable::configure($table);
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
            'index' => ListSubprocesses::route('/'),
            'create' => CreateSubprocess::route('/create'),
            'edit' => EditSubprocess::route('/{record}/edit'),
        ];
    }
}
