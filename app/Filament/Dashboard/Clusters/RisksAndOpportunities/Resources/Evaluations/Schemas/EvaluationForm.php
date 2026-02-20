<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Schemas;

use App\Enums\EffectivenessLevelEnum;
use App\Models\EffectivenessLevelRange;
use App\Traits\HasStandardFileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\Slider\Enums\PipsMode;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class EvaluationForm
{
    use HasStandardFileUpload;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Select::make('control_id')
                            ->label(__('Control'))
                            ->relationship('control', 'title')
                            ->preload()
                            ->searchable()
                            ->required(),
                        TextInput::make('title')
                            ->label(__('Title'))
                            ->required()
                            ->maxLength(255)
                            ->unique(),
                        Select::make('evaluator_id')
                            ->label(__('Evaluator'))
                            ->relationship('evaluator', 'name')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ]),
                Group::make()
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->schema([
                                Toggle::make('design_is_suitable')
                                    ->label(__('Is the design suitable?'))
                                    ->columnSpanFull()
                                    ->onColor('success')
                                    ->offColor('danger'),
                                DatePicker::make('period_from')
                                    ->label(__('Period from'))
                                    ->maxDate(today())
                                    ->closeOnDateSelection()
                                    ->native(false)
                                    ->afterStateUpdated(function ($set) {
                                        $set('period_to', null);
                                    })
                                    ->reactive()
                                    ->required(),
                                DatePicker::make('period_to')
                                    ->label(__('Period to'))
                                    ->minDate(fn ($get) => $get('period_from'))
                                    ->maxDate(today())
                                    ->closeOnDateSelection()
                                    ->native(false)
                                    ->disabled(fn ($get) => empty($get('period_from')))
                                    ->required(),
                                Textarea::make('observations')
                                    ->label(__('Observations'))
                                    ->autosize()
                                    ->columnSpanFull(),
                                Toggle::make('requires_rca')
                                    ->label(__('Requires RCA')),
                                static::baseFileUpload('path')
                                    ->label(__('File'))
                                    ->directory('evaluations/files')
                                    ->storeFileNamesIn('name')
                                    ->multiple()
                                    ->columnSpanFull()
                                    ->required(),
                            ]),
                    ])->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                Slider::make('effectiveness_rating')
                                    ->label(__('Effectiveness rating'))
                                    ->range(minValue: 0, maxValue: 100)
                                    ->fillTrack()
                                    ->vertical()
                                    ->extraAttributes(['style' => 'height: 300px;'])
                                    ->reactive()
                                    ->afterStateUpdated(function ($set, $state) {
                                        $range = EffectivenessLevelRange::where('min_rating', '<=', $state)
                                            ->where('max_rating', '>=', $state)
                                            ->first();

                                        if ($range) {
                                            $set('effectiveness_level', $range->effectiveness_level->value);
                                        }
                                    })
                                    /* ->tooltips(RawJs::make(<<<'JS'
                                        `${$value.toFixed(0)}%`
                                    JS)) */
                                    ->step(10)
                                    ->pips(PipsMode::Steps, density: 5)
                                    ->pipsFormatter(RawJs::make(<<<'JS'
                                        `${$value.toFixed(0)}%`
                                    JS)),
                                Select::make('effectiveness_level')
                                    ->label(__('Effectiveness level'))
                                    ->options(EffectivenessLevelEnum::class)
                                    ->dehydrated()
                                    ->disabled(),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}
