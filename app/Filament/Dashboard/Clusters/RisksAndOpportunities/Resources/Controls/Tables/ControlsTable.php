<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ControlsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nature_of_control')
                    ->label(__('Nature of Control'))
                    ->searchable(),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('automation_level')
                    ->label(__('Automation Level'))
                    ->searchable(),
                TextColumn::make('frequency')
                    ->label(__('Frequency'))
                    ->searchable(),
                TextColumn::make('effectiveness_rating')
                    ->label(__('Effectiveness rating'))
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('effectiveness_level')
                    ->label(__('Effectiveness level'))
                    ->badge(),
                TextColumn::make('responsible.name')
                    ->label(__('Responsible'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
