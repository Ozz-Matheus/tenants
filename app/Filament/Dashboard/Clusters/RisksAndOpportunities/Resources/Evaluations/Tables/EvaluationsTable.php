<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EvaluationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('control.title')
                    ->label(__('Control')),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('evaluator.name')
                    ->label(__('Evaluator')),
                TextColumn::make('design_is_suitable')
                    ->label(__('Design Suitable'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => (bool) $state ? __('Yes') : __('No'))
                    ->color(fn ($state) => (bool) $state ? 'success' : 'danger'),
                TextColumn::make('period_from')
                    ->label(__('Period From'))
                    ->date(),
                TextColumn::make('period_to')
                    ->label(__('Period To'))
                    ->date(),
                TextColumn::make('effectiveness_rating')
                    ->label(__('Effectiveness Rating'))
                    ->numeric()
                    ->suffix('%'),
                TextColumn::make('effectiveness_level')
                    ->label(__('Effectiveness Level'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }
}
