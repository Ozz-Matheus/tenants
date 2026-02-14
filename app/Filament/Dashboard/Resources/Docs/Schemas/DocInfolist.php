<?php

namespace App\Filament\Dashboard\Resources\Docs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make(__('Document Identification'))
                        ->schema([
                            TextEntry::make('classification_code')
                                ->label(__('doc.classification_code'))
                                ->weight('bold')
                                ->copyable(),
                            TextEntry::make('title')
                                ->label(__('Title'))
                                ->columnSpan(2),
                            TextEntry::make('type.title')
                                ->label(__('Doc type'))
                                ->badge(),
                            IconEntry::make('confidential')
                                ->label(__('doc.confidential'))
                                ->boolean()
                                ->trueColor('danger')
                                ->falseColor('gray'),
                            TextEntry::make('accessToAdditionalUsers.name')
                                ->label(__('Additional Users'))
                                // ->listWithLineBreaks()
                                ->badge()
                                ->visible(fn ($record) => $record->confidential)
                                ->columnSpan(3),
                        ])->columns(4),

                    // Sección: Contexto del Proceso
                    Section::make(__('Operational Context'))
                        ->schema([
                            TextEntry::make('process.title')
                                ->label(__('Process'))
                                ->icon('heroicon-m-cog'),
                            TextEntry::make('subprocess.title')
                                ->label(__('Sub process'))
                                ->icon('heroicon-m-arrow-right-circle'),
                            TextEntry::make('headquarter.name')
                                ->label(__('headquarter.model_label'))
                                ->icon('heroicon-m-building-office'),
                        ])->columns(3),
                ])->columnSpan(2),

                Group::make([
                    Section::make(__('Format Control'))
                        ->visible(fn ($record) => $record->doc_type_id === 1)
                        ->columns(2)
                        ->collapsible()
                        ->schema([
                            TextEntry::make('storage_method')
                                ->label(__('Storage method'))
                                ->listWithLineBreaks(),
                            TextEntry::make('retention_time')
                                ->label(__('Retention time'))
                                ->suffix(__(' months')),
                            TextEntry::make('recoveryMethod.title')
                                ->label(__('Recovery method')),
                            TextEntry::make('dispositionMethod.title')
                                ->label(__('Disposition method')),
                        ]),

                    Section::make(__('Metadata'))
                        ->columns(2)
                        ->collapsible()
                        ->schema([
                            TextEntry::make('createdBy.name')
                                ->label(__('Created by')),
                            TextEntry::make('created_at')
                                ->label(__('Created at'))
                                ->since(),
                            TextEntry::make('updatedBy.name')
                                ->label(__('Updated by')),
                            TextEntry::make('updated_at')
                                ->label(__('Updated at'))
                                ->since(),
                        ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
