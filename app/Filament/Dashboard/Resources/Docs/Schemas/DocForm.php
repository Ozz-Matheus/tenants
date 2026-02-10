<?php

namespace App\Filament\Dashboard\Resources\Docs\Schemas;

use App\Models\DocType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocForm
{
    public static function configure(Schema $schema): Schema
    {
        $docTypeFormat = fn ($get) => (int) $get('doc_type_id') === DocType::where('name', 'format')->value('id');

        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Select::make('headquarter_id')
                                    ->label(__('Headquarter'))
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
                                    ->relationship('type', 'label')
                                    ->afterStateUpdated(function ($set) {
                                        $set('storage_method_id', null);
                                        $set('recovery_method_id', null);
                                        $set('disposition_method_id', null);
                                    })
                                    ->columnSpanFull()
                                    ->native(false)
                                    ->reactive()
                                    ->required(),
                                Select::make('storage_method_id')
                                    ->label(__('Storage method'))
                                    ->relationship('storageMethod', 'label')
                                    ->afterStateUpdated(function ($set) {
                                        $set('recovery_method_id', null);
                                        $set('disposition_method_id', null);
                                    })
                                    ->reactive()
                                    ->native(false)
                                    ->visible($docTypeFormat)
                                    ->required($docTypeFormat),
                                Select::make('recovery_method_id')
                                    ->label(__('Recovery method'))
                                    ->relationship(
                                        name: 'recoveryMethod',
                                        titleAttribute: 'title',
                                        modifyQueryUsing: fn ($query, $get) => $query->where('storage_id', $get('storage_method_id'))
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
                                        modifyQueryUsing: fn ($query, $get) => $query->where('storage_id', $get('storage_method_id'))
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
                                    ->label(__('Confidential'))
                                    ->inline(false)
                                    ->afterStateUpdated(fn ($set) => $set('accessToAdditionalUsers', null))
                                    ->columnSpanFull()
                                    ->reactive(),
                                Select::make('accessToAdditionalUsers')
                                    ->label(__('Access to additional users'))
                                    ->relationship('accessToAdditionalUsers', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->visible(fn ($get) => $get('confidential') === true),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}
