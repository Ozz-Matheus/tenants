<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Tables;

use App\Enums\CriteriaTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItemValuesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item_criteria_type')
                    ->label(__('Item Criteria Type'))
                    ->searchable(),
                TextColumn::make('strategic_context_type')
                    ->label(__('Strategic Context Type'))
                    ->searchable()
                    ->visible(fn ($livewire): bool => property_exists($livewire, 'activeTab') && $livewire->activeTab === CriteriaTypeEnum::IMPACT->value),
                TextColumn::make('strategicContext.title')
                    ->label(__('Strategic Context'))
                    ->searchable()
                    ->visible(fn ($livewire): bool => property_exists($livewire, 'activeTab') && $livewire->activeTab === CriteriaTypeEnum::IMPACT->value),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('value')
                    ->label(__('Value'))
                    ->suffix('%')
                    ->sortable(),
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
                SelectFilter::make('strategic_context_type')
                    ->label(__('Strategic Context Type'))
                    ->options(StrategicContextTypeEnum::class)
                    ->native(false)
                    ->visible(fn ($livewire): bool => property_exists($livewire, 'activeTab') && $livewire->activeTab === CriteriaTypeEnum::IMPACT->value),
            ])
            ->filtersTriggerAction(
                fn ($action) => $action->button()
            )
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
            ]);
    }
}
