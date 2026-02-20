<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages\CreateControl;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages\EditControl;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages\ListControls;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages\ManageEvaluations;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages\ViewControl;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\RelationManagers\RisksRelationManager;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Schemas\ControlForm;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Schemas\ControlInfolist;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Tables\ControlsTable;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\RisksAndOpportunitiesCluster;
use App\Models\Control;
use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ControlResource extends Resource
{
    protected static ?string $model = Control::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Stop;

    protected static ?string $cluster = RisksAndOpportunitiesCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Control');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Controls');
    }

    public static function getNavigationLabel(): string
    {
        return __('Controls');
    }

    public static function form(Schema $schema): Schema
    {
        return ControlForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ControlInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ControlsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RisksRelationManager::class,
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([

            // Pestaña 1: Información General
            ViewControl::class,

            // Pestaña 2: Lista de Evaluaciones
            ManageEvaluations::class,

        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListControls::route('/'),
            'create' => CreateControl::route('/create'),
            'view' => ViewControl::route('/{record}'),
            'edit' => EditControl::route('/{record}/edit'),
            'evaluations' => ManageEvaluations::route('/{record}/evaluations'),
        ];
    }
}
