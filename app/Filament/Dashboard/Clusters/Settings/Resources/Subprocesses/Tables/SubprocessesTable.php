<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class SubprocessesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('process.title')
                    ->collapsible(),
            ])->collapsedGroupsByDefault(true)
            ->defaultGroup('process.title')
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                TextColumn::make('leaders.name')
                    ->label(__('Leaders'))
                    ->limit(30)
                    ->tooltip(
                        fn ($record) => $record->leaders->pluck('name')->join(', ')
                    ),
                TextColumn::make('acronym')
                    ->label(__('Acronym'))
                    ->searchable(),
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
            ])->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('process_id')
                    ->label(__('Process'))
                    ->relationship('process', 'title')
                    ->multiple()
                    ->searchable(),
            ])
            ->filtersTriggerAction(
                fn ($action) => $action->button()
            )
            ->filtersFormColumns(2)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([]),
            ]);
    }
}
