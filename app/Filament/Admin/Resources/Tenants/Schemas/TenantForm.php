<?php

namespace App\Filament\Admin\Resources\Tenants\Schemas;

use App\Filament\Admin\Resources\Tenants\Pages;
use App\Rules\ExistingTenantDatabase;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateTenant)
                    ->schema([

                        Toggle::make('link_existing_db')
                            ->label(__('Link Existing Database'))
                            ->default(true)
                            ->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(fn ($set) => $set('id', null))
                            ->visible(fn () => App::isLocal()),

                        TextInput::make('name')
                            ->label(trans('tenant.columns.name'))
                            ->required()
                            ->live(onBlur: true)
                            ->unique(table: 'tenants', ignoreRecord: true)
                            ->afterStateUpdated(function ($set, $state, $livewire, $get) {
                                $set('domain', Str::of($state)->slug()->limit(63)->toString());
                                if (! $get('link_existing_db')) {
                                    $set('id', Str::of($state)->slug('_')->toString());
                                }
                            }),

                        TextInput::make('id')
                            ->label(trans('tenant.columns.unique_id'))
                            ->required()
                            ->unique(table: 'tenants', ignoreRecord: true)
                            ->rules([
                                fn ($get) => $get('link_existing_db')
                                    ? new ExistingTenantDatabase
                                    : null,
                            ]),

                        TextInput::make('domain')
                            ->columnSpanFull()
                            ->label(trans('tenant.columns.domain'))
                            ->required()
                            ->unique(table: 'domains', ignoreRecord: true)
                            ->prefix(request()->getScheme().'://')
                            ->suffix('.'.config('holdingtec.central_domain')),
                    ]),
            ])
            ->columns(1);
    }
}
