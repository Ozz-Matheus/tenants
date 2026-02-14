<?php

namespace App\Filament\Dashboard\Resources\Docs;

use App\Filament\Dashboard\Resources\Docs\Pages\CreateDoc;
use App\Filament\Dashboard\Resources\Docs\Pages\EditDoc;
use App\Filament\Dashboard\Resources\Docs\Pages\ListDocs;
use App\Filament\Dashboard\Resources\Docs\Pages\ManageDocVersions;
use App\Filament\Dashboard\Resources\Docs\Pages\ViewDoc;
use App\Filament\Dashboard\Resources\Docs\Schemas\DocForm;
use App\Filament\Dashboard\Resources\Docs\Schemas\DocInfolist;
use App\Filament\Dashboard\Resources\Docs\Tables\DocsTable;
use App\Models\Doc;
use BackedEnum;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocResource extends Resource
{
    protected static ?string $model = Doc::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('doc.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('doc.plural_model_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('doc.plural_model_label');
    }

    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Schema $schema): Schema
    {
        return DocForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DocInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([

            // Pestaña 1: Información General
            ViewDoc::class,

            // Pestaña 2: Lista de Versiones
            ManageDocVersions::class,

        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocs::route('/'),
            'create' => CreateDoc::route('/create'),
            'view' => ViewDoc::route('/{record}'),
            'versions' => ManageDocVersions::route('/{record}/versions'),
            // 'edit' => EditDoc::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['type', 'process', 'subprocess', 'latestVersion', 'headquarter']);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
