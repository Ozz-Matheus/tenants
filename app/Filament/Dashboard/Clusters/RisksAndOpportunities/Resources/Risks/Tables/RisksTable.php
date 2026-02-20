<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RisksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classification_code')
                    ->label(__('Classification code'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->classification_code)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('process.title')
                    ->label(__('Process')),
                TextColumn::make('subprocess.title')
                    ->label(__('Subprocess')),
                ColumnGroup::make(__('Inherent risk'), [
                    TextColumn::make('inherentImpact.title')
                        ->label(__('Impact')),
                    TextColumn::make('inherentProbability.title')
                        ->label(__('Probability')),
                    TextColumn::make('inherentLevel.title')
                        ->label(__('Level'))
                        ->badge()
                        ->color(fn ($record) => $record->inherentLevel->color),
                ]),
                ColumnGroup::make(__('Residual risk'), [
                    TextColumn::make('residualImpact.title')
                        ->label(__('Impact')),
                    TextColumn::make('residualProbability.title')
                        ->label(__('Probability')),
                    TextColumn::make('residualLevel.title')
                        ->label(__('Level'))
                        ->badge()
                        ->color(fn ($record) => $record->residualLevel->color),
                ]),
                TextColumn::make('headquarter.name')
                    ->label(__('Headquarters'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
