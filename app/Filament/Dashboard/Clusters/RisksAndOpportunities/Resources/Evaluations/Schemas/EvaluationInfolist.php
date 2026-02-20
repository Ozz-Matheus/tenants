<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Evaluations\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EvaluationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                Group::make()
                    ->schema([
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
                    ])->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make()
                            ->schema([
                                TextEntry::make('effectiveness_rating')
                                    ->label(__('Effectiveness rating'))
                                    ->suffix('%'),
                                TextEntry::make('effectiveness_level')
                                    ->label(__('Effectiveness level'))
                                    ->badge(),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }
}
