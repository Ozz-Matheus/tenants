<?php

namespace App\Filament\Dashboard\Clusters\Settings\Resources\ItemValues\Schemas;

use App\Enums\CriteriaTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemValueForm
{
    public static function configure(Schema $schema): Schema
    {
        $criteriaTypeImpact = CriteriaTypeEnum::IMPACT;

        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('item_criteria_type')
                            ->label(__('Item Criteria Type'))
                            ->columnSpan(2)
                            ->options(
                                collect(CriteriaTypeEnum::cases())
                                    ->reject(fn ($case) => $case === CriteriaTypeEnum::LEVEL)
                                    ->mapWithKeys(fn ($case) => [$case->value => $case->getLabel()])
                            )
                            ->native(false)
                            ->reactive()
                            ->required(),
                        Select::make('strategic_context_type')
                            ->label(__('Strategic Context Type'))
                            ->options(StrategicContextTypeEnum::class)
                            ->native(false)
                            ->reactive()
                            ->visible(fn ($get) => $get('item_criteria_type') === $criteriaTypeImpact->value)
                            ->required(fn ($get) => $get('item_criteria_type') === $criteriaTypeImpact->value),
                        Select::make('strategic_context_id')
                            ->label(__('Strategic Context'))
                            ->relationship(
                                name: 'strategicContext',
                                titleAttribute: 'title',
                                modifyQueryUsing: fn ($query, $get) => $query->where('type', $get('strategic_context_type'))->orderBy('id', 'asc'),
                            )
                            ->native(false)
                            ->visible(fn ($get) => $get('item_criteria_type') === $criteriaTypeImpact->value)
                            ->required(fn ($get) => $get('item_criteria_type') === $criteriaTypeImpact->value),
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('value')
                            ->label(__('Value'))
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->helperText(__('Enter a value between 0 and 100'))
                            ->required(),
                        Textarea::make('description')
                            ->label(__('Description'))
                            ->autosize()
                            ->columnSpanFull()
                            ->required(),
                    ]),
            ]);
    }
}
