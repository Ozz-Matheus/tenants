<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages\CreateCause;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages\EditCause;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages\ListCauses;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Pages\ViewCause;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Schemas\CauseForm;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Schemas\CauseInfolist;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Causes\Tables\CausesTable;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\RisksAndOpportunitiesCluster;
use App\Models\Cause;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CauseResource extends Resource
{
    protected static ?string $model = Cause::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = RisksAndOpportunitiesCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Cause');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Causes');
    }

    public static function getNavigationLabel(): string
    {
        return __('Causes');
    }

    public static function form(Schema $schema): Schema
    {
        return CauseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CauseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CausesTable::configure($table);
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
            'index' => ListCauses::route('/'),
            'create' => CreateCause::route('/create'),
            'view' => ViewCause::route('/{record}'),
            'edit' => EditCause::route('/{record}/edit'),
        ];
    }
}
