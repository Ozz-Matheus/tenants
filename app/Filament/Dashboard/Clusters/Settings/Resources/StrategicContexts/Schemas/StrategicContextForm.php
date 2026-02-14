<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\StrategicContexts\Schemas;

use App\Enums\StrategicContextTypeEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StrategicContextForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('type')
                            ->label(__('Type'))
                            ->options(StrategicContextTypeEnum::class)
                            ->native(false)
                            ->required(),
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->required(),
                    ]),
            ]);
    }
}
