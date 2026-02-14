<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Schemas;

use App\Enums\RiskTreatmentEnum;
use App\Enums\RiskTypeEnum;
use App\Enums\StrategicContextTypeEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class RiskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
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
                        Select::make('process_id')
                            ->label(__('Process'))
                            ->relationship('process', 'title')
                            ->afterStateUpdated(fn ($set) => $set('subprocess_id', null))
                            ->native(false)
                            ->reactive()
                            ->required(),
                        Select::make('subprocess_id')
                            ->label(__('Sub process'))
                            ->relationship(
                                name: 'subprocess',
                                titleAttribute: 'title',
                                modifyQueryUsing: fn ($query, $get) => $query->where('process_id', $get('process_id'))
                            )
                            ->native(false)
                            ->required(),

                    ]),
                Group::make()
                    ->columnSpan(['lg' => 2])
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->columnSpanFull()
                            ->schema([
                                Select::make('risk_type')
                                    ->label(__('Risk Type'))
                                    ->options(RiskTypeEnum::class)
                                    ->native(false)
                                    ->required(),
                                Select::make('strategic_context_type')
                                    ->label(__('Strategic Context Type'))
                                    ->options(StrategicContextTypeEnum::class)
                                    ->afterStateUpdated(fn ($set) => $set('impactItems', [
                                        ['strategic_context_id' => null, 'description' => null, 'value_id' => null],
                                    ]))
                                    ->native(false)
                                    ->reactive()
                                    ->required(),
                                TextInput::make('inherent_impact')
                                    ->label('Inherent Impact')
                                    ->disabled(),
                                Repeater::make('impactItems')
                                    ->relationship()
                                    ->label(__('Impact Items'))
                                    ->columnSpanFull()
                                    ->table([
                                        TableColumn::make(__('Item'))
                                            ->width('250px')
                                            ->markAsRequired(),
                                        TableColumn::make(__('Description'))
                                            ->markAsRequired(),
                                        TableColumn::make(__('Value'))
                                            ->width('200px')
                                            ->markAsRequired(),
                                    ])
                                    ->compact()
                                    ->schema([
                                        Select::make('strategic_context_id')
                                            ->relationship(
                                                name: 'strategicContext',
                                                titleAttribute: 'title',
                                                modifyQueryUsing: fn ($query, $get) => $query->where('type', $get('../../strategic_context_type'))->orderBy('id', 'asc')
                                            )
                                            ->native(false)
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->required(),
                                        Textarea::make('description')
                                            ->label(__('Description'))
                                            ->autosize()
                                            ->required(),
                                        Select::make('value_id')
                                            ->relationship(
                                                name: 'itemValue',
                                                titleAttribute: 'title',
                                                modifyQueryUsing: fn ($query, $get) => $query
                                                    ->where('strategic_context_id', $get('strategic_context_id'))
                                                    ->where('item_type', 1)
                                                    ->orderBy('id', 'asc')
                                            )
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title} - {$record->value}%")
                                            ->native(false)
                                            ->required(),
                                    ]),

                                /* **************** */

                                TextInput::make('inherent_probability')
                                    ->label('Inherent Probability')
                                    ->disabled(),
                                Repeater::make('probabilityItems')
                                    ->relationship()
                                    ->label(__('Probability Items'))
                                    ->columnSpanFull()
                                    ->table([
                                        TableColumn::make(__('Causes'))
                                            ->width('250px')
                                            ->markAsRequired(),
                                        TableColumn::make(__('Description'))
                                            ->markAsRequired(),
                                        TableColumn::make(__('Value'))
                                            ->width('200px')
                                            ->markAsRequired(),
                                    ])
                                    ->compact()
                                    ->schema([
                                        Select::make('cause_id')
                                            ->relationship(
                                                name: 'cause',
                                                titleAttribute: 'title',
                                            )
                                            ->createOptionForm([
                                                TextInput::make('title')
                                                    ->label(__('Title'))
                                                    ->required(),
                                            ])
                                            ->preload()
                                            ->searchable()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->native(false)
                                            ->required(),
                                        Textarea::make('description')
                                            ->label(__('Description'))
                                            ->autosize()
                                            ->required(),
                                        Select::make('value_id')
                                            ->relationship(
                                                name: 'itemValue',
                                                titleAttribute: 'title',
                                                modifyQueryUsing: fn ($query) => $query
                                                    ->where('item_type', 2)
                                                    ->orderBy('id', 'asc')
                                            )
                                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->title} - {$record->value}%")
                                            ->native(false)
                                            ->required(),
                                    ]),
                                TextInput::make('inherent_level')
                                    ->label('Inherent Level')
                                    ->disabled(),
                                Select::make('treatment')
                                    ->label(__('Treatment'))
                                    ->options(RiskTreatmentEnum::class)
                                    ->native(false)
                                    ->required(),
                            ]),
                    ]),
                Group::make()
                    ->columnSpan(['lg' => 1])
                    ->schema([
                        Section::make(__('Information'))
                            ->icon(Heroicon::InformationCircle)
                            ->schema([
                                TextEntry::make('info')
                                    ->default('Aqui ira la información de los valores y descripciónes de todo lo referente a la evaluación
                                    - Los valores y descripciones de los elementos.
                                    - Los valores y descripciones del impacto y probabilidad
                                    - Los valores y descripciones del nivel de riesgo'),
                            ]),
                    ]),
            ])->columns(3);
    }
}
