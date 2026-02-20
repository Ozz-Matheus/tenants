<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\EvaluationCriterias\Schemas;

use App\Enums\CriteriaTypeEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EvaluationCriteriaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('criteria_type')
                            ->label(__('Criteria Type'))
                            ->options(CriteriaTypeEnum::class)
                            ->native(false)
                            ->reactive()
                            ->required(),
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Textarea::make('description')
                            ->label(__('Description'))
                            ->columnSpanFull()
                            ->autosize(),
                        TextInput::make('min')
                            ->label(__('Minimum value'))
                            ->required()
                            ->numeric(),
                        TextInput::make('max')
                            ->label(__('Maximum value'))
                            ->required()
                            ->numeric(),
                        TextInput::make('weight')
                            ->label(__('Weight'))
                            ->numeric()
                            ->step(0.01)
                            ->visible(fn ($get) => $get('criteria_type') !== CriteriaTypeEnum::LEVEL)
                            ->required(fn ($get) => $get('criteria_type') !== CriteriaTypeEnum::LEVEL),
                        Select::make('color')
                            ->label(__('Color'))
                            ->options([
                                'red' => __('Red'),
                                'blue' => __('Blue'),
                                'green' => __('Green'),
                                'yellow' => __('Yellow'),
                            ])
                            ->native(false)
                            ->visible(fn ($get) => $get('criteria_type') === CriteriaTypeEnum::LEVEL)
                            ->required(fn ($get) => $get('criteria_type') === CriteriaTypeEnum::LEVEL),
                    ]),
            ]);
    }
}
