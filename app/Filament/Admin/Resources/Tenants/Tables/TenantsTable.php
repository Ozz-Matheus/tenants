<?php

namespace App\Filament\Admin\Resources\Tenants\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['domains', 'ownerBy']))
            ->columns([
                TextColumn::make('id')
                    ->label(__('tenant.identifier'))
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->fontFamily('mono'),

                TextColumn::make('name')
                    ->label(trans('tenant.columns.name'))
                    ->searchable()
                    ->description(fn ($record) => $record->admin_url)
                    ->url(fn ($record) => $record->admin_url, shouldOpenInNewTab: true),

                ToggleColumn::make('is_active')
                    ->sortable()
                    ->label(trans('tenant.columns.is_active')),
                TextColumn::make('ownerBy.name')
                    ->label(__('Created by'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(trans('tenant.columns.is_active')),
                SelectFilter::make('owner_by_id')
                    ->label(__('Created by'))
                    ->relationship('ownerBy', 'name', fn ($query) => $query->orderBy('name'))
                    ->searchable()
                    ->preload(false),
            ])
            ->filtersTriggerAction(
                fn ($action) => $action->button()
            )
            ->filtersFormColumns(2)
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('view')
                    ->label(trans('tenant.actions.view'))
                    ->tooltip(trans('tenant.actions.view'))
                    ->iconButton()
                    ->icon('heroicon-s-link')
                    ->url(fn ($record) => $record->admin_url, shouldOpenInNewTab: true)
                    ->openUrlInNewTab(),
                EditAction::make()
                    ->label(trans('tenant.actions.edit'))
                    ->tooltip(trans('tenant.actions.edit'))
                    ->iconButton(),
                DeleteAction::make()
                    ->label(trans('tenant.actions.delete'))
                    ->tooltip(trans('tenant.actions.delete'))
                    ->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
