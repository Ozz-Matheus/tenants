<?php

namespace App\Filament\Admin\Resources\Tenants\RelationManagers;

use App\Rules\ValidSubdomain;
use App\Support\AppHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DomainsRelationManager extends RelationManager
{
    protected static string $relationship = 'domains';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('domain')
                    ->required()
                    ->label(trans('tenant.domains.columns.domain'))
                    ->rule(new ValidSubdomain)
                    ->helperText(__('Only lowercase letters, numbers and hyphens (in: my-company)'))
                    ->prefix(request()->getScheme().'://')
                    ->suffix('.'.config('holdingtec.central_domain'))
                    ->maxLength(63),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('domain')
            ->columns([
                TextColumn::make('domain')
                    ->label(trans('tenant.domains.columns.domain')),
                TextColumn::make('full-domain')
                    ->label(trans('tenant.domains.columns.full'))
                    ->getStateUsing(fn ($record) => AppHelper::getTenantUrl($record->domain, '/')),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->createAnother(false),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
