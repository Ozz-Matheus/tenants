<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Enums\RoleEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->formatStateUsing(fn (string $state) => RoleEnum::getLabelFromValue($state))
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state) => RoleEnum::getColorFromValue($state)),
                ToggleColumn::make('active')
                    ->sortable()
                    ->label(trans('tenant.columns.is_active'))
                    ->disabled(fn ($record) => $record->is(auth()->user())),
                TextColumn::make('email_verified_at')
                    ->label(__('user.email_verified_on'))
                    ->dateTime()
                    ->sortable()
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
            ])->defaultSort('id', 'desc')
            ->filters([
                TernaryFilter::make('active')
                    ->label(trans('tenant.columns.is_active')),
                TrashedFilter::make(),
            ])
            ->filtersTriggerAction(
                fn ($action) => $action->button()
            )
            ->filtersFormColumns(2)
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                ]),
            ]);
    }
}
