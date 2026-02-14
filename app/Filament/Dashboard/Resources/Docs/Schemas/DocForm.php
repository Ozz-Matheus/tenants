<?php

namespace App\Filament\Dashboard\Resources\Docs\Schemas;

use App\Enums\DocStorageEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Icon;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class DocForm
{
    public static function configure(Schema $schema): Schema
    {
        $docTypeFormat = fn ($get) => (int) $get('doc_type_id') === 1;

        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Select::make('headquarter_id')
                                    ->label(__('headquarter.model_label'))
                                    ->relationship('headquarter', 'name')
                                    ->native(false)
                                    ->columnSpanFull()
                                    ->required(fn () => auth()->user()->interact_with_all_headquarters === (bool) true)
                                    ->visible(fn () => auth()->user()->interact_with_all_headquarters === (bool) true),
                                TextInput::make('title')
                                    ->label(__('Title'))
                                    ->required()
                                    ->columnSpanFull()
                                    ->maxLength(255),
                                Select::make('process_id')
                                    ->label(__('Process'))
                                    ->relationship('process', 'title')
                                    ->afterStateUpdated(fn ($set) => $set('subprocess_id', null))
                                    ->native(false)
                                    ->reactive()
                                    ->required(),
                                Select::make('subprocess_id')
                                    ->label(__('Subprocess'))
                                    ->relationship(
                                        name: 'subprocess',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('process_id', $get('process_id'))
                                    )
                                    ->native(false)
                                    ->required(),
                                Select::make('doc_type_id')
                                    ->label(__('Doc type'))
                                    ->relationship('type', 'title')
                                    ->afterStateUpdated(function ($set) {
                                        $set('storage_method', null);
                                        $set('retention_time', null);
                                        $set('recovery_method_id', null);
                                        $set('disposition_method_id', null);
                                    })
                                    ->columnSpanFull()
                                    ->native(false)
                                    ->reactive()
                                    ->required(),
                                Select::make('storage_method')
                                    ->label(__('Storage method'))
                                    ->options(DocStorageEnum::class)
                                    ->afterStateUpdated(function ($set) {
                                        $set('retention_time', null);
                                        $set('recovery_method_id', null);
                                        $set('disposition_method_id', null);
                                    })
                                    ->reactive()
                                    ->native(false)
                                    ->visible($docTypeFormat)
                                    ->required($docTypeFormat),
                                TextInput::make('retention_time')
                                    ->label(__('Retention time'))
                                    ->afterLabel(Icon::make(Heroicon::InformationCircle)->tooltip(__('Retention time in months')))
                                    ->numeric()
                                    ->visible($docTypeFormat)
                                    ->required($docTypeFormat),
                                Select::make('recovery_method_id')
                                    ->label(__('Recovery method'))
                                    ->relationship(
                                        name: 'recoveryMethod',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('storage_id', $get('storage_method'))
                                    )
                                    ->native(false)
                                    ->preload()
                                    ->visible($docTypeFormat)
                                    ->required($docTypeFormat),
                                Select::make('disposition_method_id')
                                    ->label(__('Disposition method'))
                                    ->relationship(
                                        name: 'dispositionMethod',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('storage_id', $get('storage_method'))
                                    )
                                    ->native(false)
                                    ->preload()
                                    ->visible($docTypeFormat)
                                    ->required($docTypeFormat),
                            ]),
                    ])->columnSpan(['lg' => 2]),
                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Toggle::make('confidential')
                                    ->label(__('doc.confidential'))
                                    ->afterLabel(Icon::make(Heroicon::InformationCircle)
                                        ->tooltip(__('Restricts the document to users outside the subprocess, except those authorized in the dropdown menu')))
                                    ->afterStateUpdated(fn ($set) => $set('accessToAdditionalUsers', null))
                                    ->columnSpanFull()
                                    ->reactive(),
                                Select::make('accessToAdditionalUsers')
                                    ->label(__('doc.access_additional_users'))
                                    ->relationship(
                                        name: 'accessToAdditionalUsers',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query) => $query->withoutSuperAdmin()
                                    )
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->visible(fn ($get) => $get('confidential') === true),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}
