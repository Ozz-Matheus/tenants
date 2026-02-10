<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\Subprocesses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubprocessForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn (string $context) => $context === 'edit')
                            ->required(fn (string $context) => $context === 'create'),
                        TextInput::make('acronym')
                            ->label(__('Acronym'))
                            ->alpha()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn (string $context) => $context === 'edit')
                            ->required(fn (string $context) => $context === 'create')
                            ->dehydrateStateUsing(
                                fn (?string $state) => mb_strtoupper($state ?? '', 'UTF-8')
                            )
                            ->extraInputAttributes(['style' => 'text-transform: uppercase']),
                        Select::make('process_id')
                            ->label(__('Process'))
                            ->relationship('process', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

            ]);
    }
}
