<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\AuditCriteriaResource\Pages;
use App\Models\AuditCriteria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuditCriteriaResource extends Resource
{
    protected static ?string $model = AuditCriteria::class;

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): string
    {
        return __('Audit Management');
    }

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?int $navigationSort = 16;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->sortable()
                    ->date('l, d \d\e F \d\e Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->sortable()
                    ->date('l, d \d\e F \d\e Y')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuditCriterias::route('/'),
            'create' => Pages\CreateAuditCriteria::route('/create'),
            'edit' => Pages\EditAuditCriteria::route('/{record}/edit'),
        ];
    }
}
