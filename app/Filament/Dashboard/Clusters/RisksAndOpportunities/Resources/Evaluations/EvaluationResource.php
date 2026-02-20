<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Pages\CreateEvaluation;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Pages\ListEvaluations;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Pages\ViewEvaluation;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Schemas\EvaluationForm;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Schemas\EvaluationInfolist;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Tables\EvaluationsTable;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\RisksAndOpportunitiesCluster;
use App\Models\Evaluation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EvaluationResource extends Resource
{
    protected static ?string $model = Evaluation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Stop;

    protected static ?string $cluster = RisksAndOpportunitiesCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Evaluation');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Evaluations');
    }

    public static function getNavigationLabel(): string
    {
        return __('Evaluations');
    }

    public static function form(Schema $schema): Schema
    {
        return EvaluationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EvaluationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EvaluationsTable::configure($table);
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
            'index' => ListEvaluations::route('/'),
            'create' => CreateEvaluation::route('/create'),
            'view' => ViewEvaluation::route('/{record}'),
        ];
    }
}
