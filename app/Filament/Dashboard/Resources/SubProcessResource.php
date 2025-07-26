<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\SubProcessResource\Pages;
use App\Models\SubProcess;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubProcessResource extends Resource
{
    protected static ?string $model = SubProcess::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListSubProcesses::route('/'),
            'create' => Pages\CreateSubProcess::route('/create'),
            'edit' => Pages\EditSubProcess::route('/{record}/edit'),
        ];
    }
}
