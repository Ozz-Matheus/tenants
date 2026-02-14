<?php

namespace App\Filament\Dashboard\Resources\Headquarters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HeadquarterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(table: 'headquarters', ignoreRecord: true)
                            ->placeholder(__('headquarter.name_form_placeholder'))
                            ->helperText(__('headquarter.name_form_helper')),

                        TextInput::make('acronym')
                            ->label(__('Acronym'))
                            ->alpha()
                            ->maxLength(255)
                            ->unique(table: 'headquarters', ignoreRecord: true)
                            ->disabled(fn (string $context) => $context === 'edit')
                            ->required(fn (string $context) => $context === 'create')
                            ->dehydrateStateUsing(
                                fn (?string $state) => mb_strtoupper($state ?? '', 'UTF-8')
                            )
                            ->extraInputAttributes(['style' => 'text-transform: uppercase']),

                    ]),

            ]);

    }
}
