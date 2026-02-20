<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Schemas;

use App\Enums\AutomationLevelEnum;
use App\Enums\FrequencyEnum;
use App\Enums\NatureOfControlEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ControlForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('nature_of_control')
                            ->label(__('Nature of Control'))
                            ->options(NatureOfControlEnum::class)
                            ->native(false)
                            ->required(),
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->required()
                            ->maxLength(255)
                            ->unique(),
                        Textarea::make('description')
                            ->label(__('Description'))
                            ->autosize()
                            ->columnSpanFull()
                            ->required(),
                        Select::make('automation_level')
                            ->label(__('Automation Level'))
                            ->options(AutomationLevelEnum::class)
                            ->native(false)
                            ->required(),
                        Select::make('frequency')
                            ->label(__('Frequency'))
                            ->options(FrequencyEnum::class)
                            ->native(false)
                            ->required(),
                        Select::make('responsible_id')
                            ->label(__('Responsible'))
                            ->relationship('responsible', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
            ]);
    }
}
