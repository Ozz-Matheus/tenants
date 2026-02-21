<?php

namespace App\Filament\Dashboard\Clusters\OrganizationContext\Resources\LegalRequirements\Schemas;

use App\Enums\StatusEnum;
use App\Traits\HasStandardFileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LegalRequirementForm
{
    use HasStandardFileUpload;

    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Group::make()
                ->schema([
                    Section::make(__('legal_requirement.general_information'))
                        ->schema([
                            TextInput::make('name')
                                ->label(__('Name'))
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Select::make('type')
                                ->label(__('Type'))
                                ->options([
                                    'decree' => 'Decreto',
                                    'resolution' => 'Resolución',
                                    'law' => 'Ley',
                                ])
                                ->searchable(),
                            TextInput::make('issuer')
                                ->label(__('legal_requirement.issuer'))
                                ->maxLength(255),
                            TextInput::make('article')
                                ->label(__('legal_requirement.article'))
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label(__('Description'))
                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make(__('legal_requirement.evidence'))
                        ->schema([
                            static::baseFileUpload('path')
                                ->label(__('File'))
                                ->directory('legal/evidences')
                                ->preserveFilenames()
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(['lg' => 2]),

            Group::make()
                ->schema([
                    Section::make(__('legal_requirement.management'))
                        ->schema([
                            Select::make('responsible_by_id')
                                ->label(__('Responsible'))
                                ->relationship('responsibleBy', 'name')
                                ->searchable()
                                ->preload(),
                            Select::make('process_id')
                                ->label(__('Process'))
                                ->relationship('process', 'title')
                                ->searchable()
                                ->preload(),
                            Select::make('status')
                                ->label(__('Status'))
                                ->options(StatusEnum::class)
                                ->native(false),
                            Select::make('compliance')
                                ->label(__('legal_requirement.compliance'))
                                ->options([
                                    'yes' => 'Sí',
                                    'partial' => 'Parcial',
                                    'no' => 'No',
                                ]),
                        ]),

                    Section::make(__('legal_requirement.dates'))
                        ->schema([
                            DatePicker::make('publication_date')
                                ->label(__('legal_requirement.publication_date')),
                            DatePicker::make('last_review')
                                ->label(__('legal_requirement.last_review')),
                            DatePicker::make('next_review')
                                ->label(__('legal_requirement.next_review')),
                        ]),
                ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }
}
