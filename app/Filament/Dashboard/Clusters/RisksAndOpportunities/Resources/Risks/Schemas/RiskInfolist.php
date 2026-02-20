<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class RiskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Identification'))
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('classification_code')
                            ->label(__('Classification Code'))
                            ->weight(FontWeight::Bold),
                        TextEntry::make('title')
                            ->label(__('Title')),
                        TextEntry::make('description')
                            ->label(__('Description'))
                            ->columnSpanFull()
                            ->markdown(),
                        TextEntry::make('process.title')
                            ->label(__('Process')),
                        TextEntry::make('subprocess.title')
                            ->label(__('Subprocess')),
                    ]),

                Section::make(__('Evaluation'))
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('risk_type')
                            ->label(__('Risk Type'))
                            ->badge(),
                        TextEntry::make('strategic_context_type')
                            ->label(__('Strategic Context Type'))
                            ->badge(),
                        TextEntry::make('treatment')
                            ->label(__('Treatment'))
                            ->badge(),
                    ]),

                Section::make(__('Inherent Risk'))
                    ->columns(3)
                    ->schema([
                        TextEntry::make('inherentImpact.title')
                            ->label(__('Inherent Impact'))
                            ->formatStateUsing(fn ($record) => $record->inherentImpact ? "{$record->inherentImpact->title} - {$record->inherentImpact->weight}" : null),
                        TextEntry::make('inherentProbability.title')
                            ->label(__('Inherent Probability'))
                            ->formatStateUsing(fn ($record) => $record->inherentProbability ? "{$record->inherentProbability->title} - {$record->inherentProbability->weight}" : null),
                        TextEntry::make('inherentLevel.title')
                            ->label(__('Inherent Level'))
                            ->badge()
                            ->color(fn ($record) => $record->inherentLevel->color),
                    ]),

                Section::make(__('Residual Risk'))
                    ->columns(3)
                    ->visible(fn ($record) => $record->residual_impact_id || $record->residual_probability_id)
                    ->schema([
                        TextEntry::make('residualImpact.title')
                            ->label(__('Residual Impact'))
                            ->formatStateUsing(fn ($record) => $record->residualImpact ? "{$record->residualImpact->title} - {$record->residualImpact->weight}" : null),
                        TextEntry::make('residualProbability.title')
                            ->label(__('Residual Probability'))
                            ->formatStateUsing(fn ($record) => $record->residualProbability ? "{$record->residualProbability->title} - {$record->residualProbability->weight}" : null),
                        TextEntry::make('residualLevel.title')
                            ->label(__('Residual Level'))
                            ->badge()
                            ->color(fn ($record) => $record->residualLevel->color),
                    ]),

                Section::make(__('Analysis Details'))
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('impactItems')
                            ->label(__('Impact Items'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('strategicContext.title')
                                            ->label(__('Strategic Context'))
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('description')
                                            ->label(__('Description')),
                                        TextEntry::make('itemValue.title')
                                            ->label(__('Value'))
                                            ->badge()
                                            ->formatStateUsing(fn ($record) => "{$record->itemValue->title} ({$record->itemValue->value}%)"),
                                    ]),
                            ])
                            ->columnSpanFull(),

                        RepeatableEntry::make('probabilityItems')
                            ->label(__('Probability Items'))
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('cause.title')
                                            ->label(__('Cause'))
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('description')
                                            ->label(__('Description')),
                                        TextEntry::make('itemValue.title')
                                            ->label(__('Value'))
                                            ->badge()
                                            ->formatStateUsing(fn ($record) => "{$record->itemValue->title} ({$record->itemValue->value}%)"),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
