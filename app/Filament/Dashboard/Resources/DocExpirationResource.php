<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\DocExpirationResource\Pages;
use App\Models\DocExpiration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocExpirationResource extends Resource
{
    protected static ?string $model = DocExpiration::class;

    protected static ?string $navigationGroup = null;

    public static function getNavigationGroup(): string
    {
        return __('Document Management');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('doc_type_id')
                    ->relationship('docType', 'title')
                    ->label(__('Doc type'))
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('management_review_years')
                    ->label(__('Management review year'))
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('central_expiration_years')
                    ->label(__('Central expiration year'))
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('docType.title')
                    ->label(__('Doc type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('management_review_years')
                    ->label(__('Management review year'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('central_expiration_years')
                    ->label(__('Central expiration year'))
                    ->numeric()
                    ->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocExpirations::route('/'),
            'create' => Pages\CreateDocExpiration::route('/create'),
            'edit' => Pages\EditDocExpiration::route('/{record}/edit'),
        ];
    }
}
