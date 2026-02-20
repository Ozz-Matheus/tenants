<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Tables;

use App\Enums\CriteriaTypeEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EvaluationCriteriasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                TextColumn::make('min')
                    ->label(__('Minimum value'))
                    ->sortable(),
                TextColumn::make('max')
                    ->label(__('Maximum value'))
                    ->sortable(),
                TextColumn::make('weight')
                    ->label(__('Weight'))
                    ->sortable()
                    ->visible(fn ($livewire): bool => property_exists($livewire, 'activeTab') && $livewire->activeTab !== CriteriaTypeEnum::LEVEL->value),
                TextColumn::make('color')
                    ->label(__('Color'))
                    ->visible(fn ($livewire): bool => property_exists($livewire, 'activeTab') && $livewire->activeTab === CriteriaTypeEnum::LEVEL->value),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
