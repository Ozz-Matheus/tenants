<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EffectivenessLevelRanges\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EffectivenessLevelRangeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('min_rating')
                            ->label(__('Minimum value'))
                            ->suffix('%')
                            ->numeric()
                            ->required(),
                        TextInput::make('max_rating')
                            ->label(__('Maximum value'))
                            ->suffix('%')
                            ->numeric()
                            ->required(),
                    ]),
            ]);
    }
}
