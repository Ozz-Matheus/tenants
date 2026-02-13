<?php

namespace App\Filament\Dashboard\Resources\Audit;

use App\Filament\Dashboard\Resources\Audit\Pages\ListAudits;
use App\Filament\Dashboard\Resources\Audit\Pages\ViewAudit;
use App\Filament\Dashboard\Resources\Audit\Schemas\AuditInfolist;
use App\Filament\Dashboard\Resources\Audit\Tables\AuditsTable;
use App\Models\AuditLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AuditResource extends Resource
{
    protected static ?string $model = AuditLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog8Tooth;

    protected static ?int $navigationSort = 41;

    public static function getModelLabel(): string
    {
        return __('Change');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Changes');
    }

    public static function getNavigationLabel(): string
    {
        return __('Changes');
    }

    public static function getNavigationGroup(): string
    {
        return __('Change Logs');
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuditInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuditsTable::configure($table);
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
            'index' => ListAudits::route('/'),
            'view' => ViewAudit::route('/{record}'),
        ];
    }
}
