<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Pages;

use App\Enums\EffectivenessLevelEnum;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\ControlResource;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\EvaluationResource;
use App\Models\EffectivenessLevelRange;
use App\Services\FileService;
use App\Traits\HasStandardFileUpload;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\Slider\Enums\PipsMode;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ManageEvaluations extends ManageRelatedRecords
{
    use HasStandardFileUpload;

    protected static string $resource = ControlResource::class;

    public static function getSubNavigationPosition(): SubNavigationPosition
    {
        return SubNavigationPosition::Top;
    }

    protected static string $relationship = 'evaluations';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;

    public function getTitle(): string
    {
        return __('Evaluation');
    }

    public static function getNavigationLabel(): string
    {
        return __('Evaluations');
    }

    protected function getHeaderActions(): array
    {

        return [

            CreateAction::make()
                ->label(__('Create Evaluation'))
                ->icon(Heroicon::PlusCircle)
                ->createAnother(false)
                ->schema([
                    Section::make()
                        ->columns(2)
                        ->columnSpanFull()
                        ->schema([
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

                    Section::make()
                        ->columns(2)
                        ->schema([
                            Slider::make('effectiveness_rating')
                                ->label(__('Effectiveness rating'))
                                ->range(minValue: 0, maxValue: 100)
                                ->fillTrack()
                                ->reactive()
                                ->afterStateUpdated(function ($set, $state) {
                                    $range = EffectivenessLevelRange::where('min_rating', '<=', $state)
                                        ->where('max_rating', '>=', $state)
                                        ->first();

                                    if ($range) {
                                        $set('effectiveness_level', $range->effectiveness_level->value);
                                    }
                                })
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

                ])
                ->action(function (array $data) {
                    $owner = $this->getOwnerRecord();
                    $evaluation = $owner->evaluations()->create([
                        'created_by_id' => auth()->id(),
                        'updated_by_id' => auth()->id(),
                        ...$data,
                    ]);
                    app(FileService::class)->createFiles($evaluation, $data);
                }),
            Action::make('back')
                ->label(__('Back'))
                ->url(fn (): string => ControlResource::getUrl('view', ['record' => $this->record]))
                ->icon(Heroicon::ArrowLeft)
                ->color('gray'),
        ];
    }

    public function getSubheading(): ?string
    {
        return $this->record?->title;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('evaluator.name')
                    ->label(__('Evaluator')),
                TextColumn::make('design_is_suitable')
                    ->label(__('Design Suitable'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => (bool) $state ? __('Yes') : __('No'))
                    ->color(fn ($state) => (bool) $state ? 'success' : 'danger'),
                TextColumn::make('period_from')
                    ->label(__('Period From'))
                    ->date(),
                TextColumn::make('period_to')
                    ->label(__('Period To'))
                    ->date(),
                TextColumn::make('effectiveness_rating')
                    ->label(__('Effectiveness Rating'))
                    ->numeric()
                    ->suffix('%'),
                TextColumn::make('effectiveness_level')
                    ->label(__('Effectiveness Level'))
                    ->badge(),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->filtersTriggerAction(
                fn ($action) => $action->button()
            )
            ->recordActions([
                Action::make('go_to_evaluation')
                    ->label(__('Go'))
                    ->icon(Heroicon::ArrowTopRightOnSquare)
                    ->url(fn ($record) => EvaluationResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
                ViewAction::make()
                    ->schema([
                        Section::make()
                            ->columns(2)
                            ->columnSpanFull()
                            ->schema([
                                TextEntry::make('control.title')
                                    ->label(__('Control')),
                                TextEntry::make('title')
                                    ->label(__('Title')),
                                TextEntry::make('evaluator.name')
                                    ->label(__('Evaluator')),
                            ]),

                        Section::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('design_is_suitable')
                                    ->label(__('Is the design suitable?'))
                                    ->columnSpanFull()
                                    ->badge()
                                    ->formatStateUsing(fn (bool $state) => $state ? __('Yes') : __('No'))
                                    ->color(fn (bool $state) => $state ? 'success' : 'danger'),
                                TextEntry::make('period_from')
                                    ->label(__('Period from'))
                                    ->since(),
                                TextEntry::make('period_to')
                                    ->label(__('Period to'))
                                    ->since(),
                                TextEntry::make('observations')
                                    ->label(__('Observations'))
                                    ->columnSpanFull(),
                                TextEntry::make('requires_rca')
                                    ->label(__('Requires RCA')),
                                RepeatableEntry::make('files')
                                    ->columnSpanFull()
                                    ->table([
                                        TableColumn::make('Name'),
                                        TableColumn::make('Type'),
                                        TableColumn::make('Size'),
                                        TableColumn::make('Created at'),
                                        TableColumn::make('Actions'),
                                    ])
                                    ->schema([
                                        TextEntry::make('name')
                                            ->limit(30)
                                            ->tooltip(fn ($record) => $record->name)
                                            ->copyable()
                                            ->copyMessage(__('Name copied'))
                                            ->formatStateUsing(fn (string $state) => ucfirst(pathinfo($state, PATHINFO_FILENAME))),
                                        TextEntry::make('readable_mime_type'),
                                        TextEntry::make('readable_size'),
                                        TextEntry::make('created_at')
                                            ->date(),
                                        Actions::make([
                                            Action::make('files')
                                                ->label(__('Download'))
                                                ->icon('heroicon-o-document-arrow-down')
                                                ->color('primary')
                                                ->url(
                                                    fn ($record) => $record->url(),
                                                )
                                                ->openUrlInNewTab(false)
                                                ->extraAttributes(fn ($record) => [
                                                    'download' => $record->name,
                                                ]),
                                        ]),
                                    ]),
                            ]),

                        Section::make()
                            ->columns(2)
                            ->schema([
                                TextEntry::make('effectiveness_rating')
                                    ->label(__('Effectiveness rating'))
                                    ->suffix('%'),
                                TextEntry::make('effectiveness_level')
                                    ->label(__('Effectiveness level'))
                                    ->badge(),
                            ]),
                    ]),
            ])
            ->toolbarActions([]);
    }
}
