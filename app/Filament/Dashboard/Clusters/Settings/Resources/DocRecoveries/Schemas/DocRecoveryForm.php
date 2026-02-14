<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\DocRecoveries\Schemas;

use App\Enums\DocStorageEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocRecoveryForm
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
                        Select::make('storage_id')
                            ->label(__('Storage method'))
                            ->options(DocStorageEnum::class)
                            ->disabled(fn (string $context) => $context === 'edit')
                            ->required(fn (string $context) => $context === 'create'),
                    ]),
            ]);
    }
}
