<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Schemas;

use App\Enums\CriteriaTypeEnum;
use App\Enums\RiskTreatmentEnum;
use App\Enums\RiskTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use App\Models\EvaluationCriteria;
use App\Models\ItemValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RiskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Identification'))
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->required()
                            ->maxLength(255)
                            ->unique(),
                        Textarea::make('description')
                            ->label(__('Description'))
                            ->autosize()
                            ->columnSpanFull()
                            ->required(),
                        Select::make('process_id')
                            ->label(__('Process'))
                            ->relationship('process', 'title')
                            ->afterStateUpdated(fn ($set) => $set('subprocess_id', null))
                            ->native(false)
                            ->reactive()
                            ->required(),
                        Select::make('subprocess_id')
                            ->label(__('Subprocess'))
                            ->relationship(
                                name: 'subprocess',
                                titleAttribute: 'title',
                                modifyQueryUsing: fn ($query, $get) => $query->where('process_id', $get('process_id'))
                            )
                            ->native(false)
                            ->required(),

                    ]),
                Section::make(__('Evaluation'))
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('risk_type')
                            ->label(__('Risk Type'))
                            ->options(RiskTypeEnum::class)
                            ->native(false)
                            ->required(),
                        Select::make('strategic_context_type')
                            ->label(__('Strategic Context Type'))
                            ->options(StrategicContextTypeEnum::class)
                            ->afterStateUpdated(fn ($set) => $set('impactItems', [
                                ['strategic_context_id' => null, 'description' => null, 'value_id' => null],
                            ]))
                            ->native(false)
                            ->reactive()
                            ->required(),
                        Select::make('inherent_impact_id')
                            ->label(__('Inherent Impact'))
                            ->relationship('inherentImpact', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title} - {$record->weight}<br><small>{$record->description}</small>")
                            ->allowHtml()
                            ->native(false)
                            ->reactive()
                            ->afterStateUpdated(fn ($set, $get) => self::calculateLevel($set, 'inherent_level_id', $get('inherent_impact_id'), $get('inherent_probability_id')))
                            ->required(),
                        Repeater::make('impactItems')
                            ->relationship()
                            ->label(__('Impact Items'))
                            ->columnSpanFull()
                            ->table([
                                TableColumn::make(__('Strategic Context'))
                                    ->width('250px')
                                    ->markAsRequired(),
                                TableColumn::make(__('Description'))
                                    ->markAsRequired(),
                                TableColumn::make(__('Value'))
                                    ->width('500px')
                                    ->markAsRequired(),
                            ])
                            ->compact()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                self::updateInherentCriteriaValue($state, $set, $get, 'inherent_impact_id', CriteriaTypeEnum::IMPACT);
                            })
                            ->schema([
                                Select::make('strategic_context_id')
                                    ->relationship(
                                        name: 'strategicContext',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('type', $get('../../strategic_context_type'))->orderBy('id', 'asc')
                                    )
                                    ->native(false)
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->required(),
                                Textarea::make('description')
                                    ->autosize()
                                    ->required(),
                                Select::make('value_id')
                                    ->relationship(
                                        name: 'itemValue',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query, $get) => $query
                                            ->where('strategic_context_id', $get('strategic_context_id'))
                                            ->where('item_criteria_type', CriteriaTypeEnum::IMPACT->value)
                                            ->orderBy('id', 'asc')
                                    )
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title} - {$record->value}%<br><small>{$record->description}</small>")
                                    ->allowHtml()
                                    ->native(false)
                                    ->reactive()
                                    ->afterStateUpdated(function ($get, $set) {
                                        self::updateInherentCriteriaValue($get('../../impactItems'), $set, $get, '../../inherent_impact_id', CriteriaTypeEnum::IMPACT);
                                    })
                                    ->required(),
                            ]),

                        /* **************** */

                        Select::make('inherent_probability_id')
                            ->label(__('Inherent Probability'))
                            ->relationship('inherentProbability', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title} - {$record->weight}<br><small>{$record->description}</small>")
                            ->allowHtml()
                            ->native(false)
                            ->reactive()
                            ->afterStateUpdated(fn ($set, $get) => self::calculateLevel($set, 'inherent_level_id', $get('inherent_impact_id'), $get('inherent_probability_id')))
                            ->required(),
                        Repeater::make('probabilityItems')
                            ->relationship()
                            ->label(__('Probability Items'))
                            ->columnSpanFull()
                            ->table([
                                TableColumn::make(__('Causes'))
                                    ->width('500px')
                                    ->markAsRequired(),
                                TableColumn::make(__('Description'))
                                    ->markAsRequired(),
                                TableColumn::make(__('Value'))
                                    ->width('250px')
                                    ->markAsRequired(),
                            ])
                            ->compact()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                self::updateInherentCriteriaValue($state, $set, $get, 'inherent_probability_id', CriteriaTypeEnum::PROBABILITY);
                            })
                            ->schema([
                                Select::make('cause_id')
                                    ->relationship(
                                        name: 'cause',
                                        titleAttribute: 'title',
                                    )
                                    ->createOptionForm([
                                        TextInput::make('title')
                                            ->label(__('Title'))
                                            ->required(),
                                    ])
                                    ->editOptionForm([
                                        TextInput::make('title')
                                            ->label(__('Title'))
                                            ->required(),
                                    ])
                                    ->preload()
                                    ->searchable()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->native(false)
                                    ->required(),
                                Textarea::make('description')
                                    ->autosize()
                                    ->required(),
                                Select::make('value_id')
                                    ->relationship(
                                        name: 'itemValue',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query) => $query
                                            ->where('item_criteria_type', CriteriaTypeEnum::PROBABILITY->value)
                                            ->orderBy('id', 'asc')
                                    )
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title} - {$record->value}%<br><small>{$record->description}</small>")
                                    ->allowHtml()
                                    ->native(false)
                                    ->reactive()
                                    ->afterStateUpdated(function ($get, $set) {
                                        self::updateInherentCriteriaValue($get('../../probabilityItems'), $set, $get, '../../inherent_probability_id', CriteriaTypeEnum::PROBABILITY);
                                    })
                                    ->required(),
                            ]),
                        Select::make('inherent_level_id')
                            ->label(__('Inherent Level'))
                            ->relationship('inherentLevel', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title}<br><small>{$record->description}</small>")
                            ->allowHtml()
                            ->native(false)
                            ->dehydrated()
                            ->disabled()
                            ->required(),
                        Select::make('treatment')
                            ->label(__('Treatment'))
                            ->options(RiskTreatmentEnum::class)
                            ->native(false)
                            ->required(),
                    ]),
            ]);
    }

    public static function updateInherentCriteriaValue($items, $set, $get, string $targetField, CriteriaTypeEnum $criteriaType): void
    {
        if (! is_array($items) || empty($items)) {
            $set($targetField, null);

            return;
        }

        $selectedIds = collect($items)
            ->pluck('value_id')
            ->filter()
            ->toArray();

        if (empty($selectedIds)) {
            $set($targetField, null);

            return;
        }

        $average = round(ItemValue::whereIn('id', $selectedIds)->pluck('value')->avg());

        $criteria = EvaluationCriteria::where('criteria_type', $criteriaType->value)
            ->where('min', '<=', $average)
            ->where('max', '>=', $average)
            ->first();

        $set($targetField, $criteria?->id);

        // Calcular Nivel automáticamente
        $isImpact = $criteriaType === CriteriaTypeEnum::IMPACT;
        $otherField = $isImpact
            ? str_replace('inherent_impact_id', 'inherent_probability_id', $targetField)
            : str_replace('inherent_probability_id', 'inherent_impact_id', $targetField);

        $levelField = str_replace(['inherent_impact_id', 'inherent_probability_id'], 'inherent_level_id', $targetField);

        $otherId = $get($otherField);
        $currentId = $criteria?->id;

        $impactId = $isImpact ? $currentId : $otherId;
        $probabilityId = $isImpact ? $otherId : $currentId;

        self::calculateLevel($set, $levelField, $impactId, $probabilityId);
    }

    public static function calculateLevel($set, $levelField, $impactId, $probabilityId): void
    {
        if (! $impactId || ! $probabilityId) {
            $set($levelField, null);

            return;
        }

        $impact = EvaluationCriteria::find($impactId);
        $probability = EvaluationCriteria::find($probabilityId);

        if (! $impact || ! $probability) {
            $set($levelField, null);

            return;
        }

        $result = $impact->weight * $probability->weight;

        $level = EvaluationCriteria::where('criteria_type', CriteriaTypeEnum::LEVEL->value)
            ->where('min', '<=', $result)
            ->where('max', '>=', $result)
            ->first();

        $set($levelField, $level?->id);
    }
}
