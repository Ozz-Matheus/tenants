<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RisksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->description),
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
