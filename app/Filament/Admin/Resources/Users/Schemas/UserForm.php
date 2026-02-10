<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Enums\RoleEnum;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make()
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('Email'))
                            ->email()
                            ->unique(table: 'users', ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->maxLength(255)
                            ->nullable()
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context) => $context === 'create')
                            ->helperText(
                                fn (string $context) => $context === 'edit'
                                    ? __('user.leave_empty_to_keep_password')
                                    : null
                            ),
                        CheckboxList::make('roles')
                            ->label(__('Roles'))
                            ->relationship(
                                name: 'roles',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query
                                    ->when(! auth()->user()->hasRole(RoleEnum::SUPER_ADMIN), fn ($q) => $q->where('name', '!=', RoleEnum::SUPER_ADMIN))
                            )
                            ->bulkToggleable()
                            ->getOptionLabelFromRecordUsing(fn ($record) => RoleEnum::getLabelFromValue($record->name))
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->columnSpanFull()
                            ->columns(3),
                        Toggle::make('active')
                            ->label(trans('tenant.columns.is_active'))
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->helperText(__('user.toggle_user_access'))
                            ->required()
                            ->default(true),

                    ]),

            ])->columns(1);
    }
}
