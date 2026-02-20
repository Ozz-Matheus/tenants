<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocDispositions\Schemas;

use App\Enums\StorageMethodEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocDispositionForm
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
                        Select::make('storage_method')
                            ->label(__('doc.storage_method'))
                            ->options(StorageMethodEnum::class)
                            ->native(false)
                            ->disabled(fn (string $context) => $context === 'edit')
                            ->required(fn (string $context) => $context === 'create'),
                    ]),
            ]);
    }
}
