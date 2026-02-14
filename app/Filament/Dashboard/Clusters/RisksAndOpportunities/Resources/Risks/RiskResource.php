<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages\CreateRisk;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages\EditRisk;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages\ListRisks;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Pages\ViewRisk;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Schemas\RiskForm;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Schemas\RiskInfolist;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Tables\RisksTable;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\RisksAndOpportunitiesCluster;
use App\Models\Risk;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RiskResource extends Resource
{
    protected static ?string $model = Risk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = RisksAndOpportunitiesCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Risk');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Risks');
    }

    public static function getNavigationLabel(): string
    {
        return __('Risks');
    }

    public static function form(Schema $schema): Schema
    {
        return RiskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RiskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RisksTable::configure($table);
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
            'index' => ListRisks::route('/'),
            'create' => CreateRisk::route('/create'),
            'view' => ViewRisk::route('/{record}'),
            'edit' => EditRisk::route('/{record}/edit'),
        ];
    }
}
