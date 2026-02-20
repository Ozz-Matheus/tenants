<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ControlInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nature_of_control')
                            ->label(__('Nature of Control')),
                        TextEntry::make('title')
                            ->label(__('Title')),
                        TextEntry::make('description')
                            ->label(__('Description'))
                            ->columnSpanFull(),
                        TextEntry::make('automation_level')
                            ->label(__('Automation Level'))
                            ->badge(),
                        TextEntry::make('frequency')
                            ->label(__('Frequency'))
                            ->badge(),
                        TextEntry::make('responsible.name')
                            ->label(__('Responsible')),
                        TextEntry::make('effectiveness_rating')
                            ->label(__('Effectiveness rating'))
                            ->suffix('%'),
                        TextEntry::make('effectiveness_level')
                            ->label(__('Effectiveness level'))
                            ->badge(),
                    ]),
            ]);
    }
}
