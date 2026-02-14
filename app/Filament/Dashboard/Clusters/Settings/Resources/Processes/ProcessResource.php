<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Processes;

use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Pages\CreateProcess;
use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Pages\EditProcess;
use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Pages\ListProcesses;
use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Schemas\ProcessForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\Processes\Tables\ProcessesTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\Process;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProcessResource extends Resource
{
    protected static ?string $model = Process::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Process');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Processes');
    }

    public static function getNavigationLabel(): string
    {
        return __('Processes');
    }

    public static function getNavigationGroup(): string
    {
        return __('Global Management');
    }

    public static function form(Schema $schema): Schema
    {
        return ProcessForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcessesTable::configure($table);
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
            'index' => ListProcesses::route('/'),
            'create' => CreateProcess::route('/create'),
            'edit' => EditProcess::route('/{record}/edit'),
        ];
    }
}
