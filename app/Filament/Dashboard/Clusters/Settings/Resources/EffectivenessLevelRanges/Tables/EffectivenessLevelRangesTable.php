<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EffectivenessLevelRangesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('effectiveness_level')
                    ->label(__('Effectiveness Level'))
                    ->badge(),
                TextColumn::make('min_rating')
                    ->label(__('Min Rating'))
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('max_rating')
                    ->label(__('Max Rating'))
                    ->suffix('%')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
            ]);
    }
}
