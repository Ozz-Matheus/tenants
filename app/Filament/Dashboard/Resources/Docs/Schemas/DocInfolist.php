<?php

namespace App\Filament\Dashboard\Resources\Docs\Schemas;

use App\Models\DocType;
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
                            TextEntry::make('type.label')
                                ->label(__('Doc type'))
                                ->badge(),
                            IconEntry::make('confidential')
                                ->label(__('doc.confidential'))
                                ->boolean()
                                ->trueColor('danger')
                                ->falseColor('gray'),
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
                        ->visible(fn ($record) => $record->doc_type_id === DocType::where('name', 'format')->value('id'))
                        ->schema([
                            TextEntry::make('storageMethod.label')
                                ->label(__('Storage method'))
                                ->listWithLineBreaks(),
                            TextEntry::make('recoveryMethod.title')
                                ->label(__('Recovery method')),
                            TextEntry::make('dispositionMethod.title')
                                ->label(__('Disposition method')),
                        ]),

                    Section::make(__('Metadata'))
                        ->schema([
                            TextEntry::make('createdBy.name')
                                ->label(__('Created by')),
                            TextEntry::make('created_at')
                                ->label(__('Created at'))
                                ->dateTime(),
                            TextEntry::make('updated_at')
                                ->label(__('Updated at'))
                                ->since(),
                        ])->collapsible(),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
