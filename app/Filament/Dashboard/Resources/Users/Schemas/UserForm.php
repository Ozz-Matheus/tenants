<?php

namespace App\Filament\Dashboard\Resources\Users\Schemas;

use App\Enums\RoleEnum;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

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
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
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
                    ]),

                Section::make(__('user.assignment_section'))
                    ->columns(2)
                    ->schema([
                        CheckboxList::make('subprocesses')
                            ->relationship('subprocesses', 'title')
                            ->label(__('user.assigned_subprocesses'))
                            ->reactive()
                            ->afterStateUpdated(function ($get, $set, $state, $record) {
                                if (! $record) {
                                    return;
                                }

                                // Subprocesos donde el usuario es líder
                                $locked = $record->leaderOf->pluck('id')->toArray();

                                // Forzar que siempre estén presentes
                                $set('subprocesses', array_unique(array_merge($state ?? [], $locked)));

                                // Sincronizar liderazgo
                                $leaderOf = $get('leaderOf') ?? [];
                                $set('leaderOf', array_intersect($leaderOf, $get('subprocesses')));
                            })
                            ->searchable()
                            ->bulkToggleable()
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->helperText(
                                fn (string $context) => $context === 'edit'
                                    ? __('user.unlink_leader_warning')
                                    : null
                            )->columns(2),
                        CheckboxList::make('leaderOf')
                            ->relationship(
                                name: 'leaderOf',
                                titleAttribute: 'title',
                                modifyQueryUsing: function (Builder $query, $get) {
                                    return $query->whereIn('id', $get('subprocesses'));
                                }
                            )
                            ->reactive()
                            ->label(__('user.leader_of'))
                            ->searchable()
                            ->bulkToggleable()
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->helperText(
                                fn (string $context) => $context === 'edit'
                                    ? __('user.leadership_options_help')
                                    : null
                            )
                            ->columns(2),
                    ]),

                Section::make(__('user.headquarters_status_section'))
                    ->columns(2)
                    ->schema([
                        Toggle::make('view_all_headquarters')
                            ->label(__('user.view_all_headquarters'))
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->helperText(__('It allows the user to view the content of all headquarters.'))
                            ->inline(false),
                        Toggle::make('interact_with_all_headquarters')
                            ->label(__('user.interact_all_headquarters'))
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->helperText(__('user.interact_all_help'))
                            ->inline(false),
                        Select::make('headquarter_id')
                            ->label(__('headquarter.plural_model_label'))
                            ->relationship('headquarter', 'name')
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->native(false)
                            ->required()
                            ->default(1),
                        Toggle::make('active')
                            ->label(trans('tenant.columns.is_active'))
                            ->disabled(fn (?User $record) => $record ? auth()->user()->isProtectedFrom($record) : false)
                            ->helperText(__('user.toggle_user_access'))
                            ->required()
                            ->default(true)
                            ->inline(false),
                    ]),

            ])->columns(1);
    }
}
