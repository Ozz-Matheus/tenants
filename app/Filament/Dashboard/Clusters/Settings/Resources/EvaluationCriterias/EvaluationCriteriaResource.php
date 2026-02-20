<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias;

use App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Pages\CreateEvaluationCriteria;
use App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Pages\EditEvaluationCriteria;
use App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Pages\ListEvaluationCriterias;
use App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Schemas\EvaluationCriteriaForm;
use App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Tables\EvaluationCriteriasTable;
use App\Filament\Dashboard\Clusters\Settings\SettingsCluster;
use App\Models\EvaluationCriteria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EvaluationCriteriaResource extends Resource
{
    protected static ?string $model = EvaluationCriteria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 6;

    public static function getModelLabel(): string
    {
        return __('Evaluation Criteria');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Evaluation Criterias');
    }

    public static function getNavigationLabel(): string
    {
        return __('Evaluation Criterias');
    }

    public static function getNavigationGroup(): string
    {
        return __('Risk Management');
    }

    public static function form(Schema $schema): Schema
    {
        return EvaluationCriteriaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EvaluationCriteriasTable::configure($table);
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
            'index' => ListEvaluationCriterias::route('/'),
            'create' => CreateEvaluationCriteria::route('/create'),
            'edit' => EditEvaluationCriteria::route('/{record}/edit'),
        ];
    }
}
