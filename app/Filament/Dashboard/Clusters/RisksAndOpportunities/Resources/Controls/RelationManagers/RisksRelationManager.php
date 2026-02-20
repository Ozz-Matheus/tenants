<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\RelationManagers;

use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\RiskResource;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\Tables\RisksTable;
use Filament\Actions\Action;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RisksRelationManager extends RelationManager
{
    protected static string $relationship = 'risks';

    public function infolist(Schema $schema): Schema
    {
        return RiskResource::infolist($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('classification_code')
                    ->label(__('Classification Code'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->classification_code)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('process.title')
                    ->label(__('Process')),
                TextColumn::make('subprocess.title')
                    ->label(__('Subprocess')),
                ColumnGroup::make(__('Inherent risk'), [
                    TextColumn::make('inherentImpact.title')
                        ->label(__('Impact')),
                    TextColumn::make('inherentProbability.title')
                        ->label(__('Probability')),
                    TextColumn::make('inherentLevel.title')
                        ->label(__('Level'))
                        ->badge()
                        ->color(fn ($record) => $record->inherentLevel->color),
                ]),
                ColumnGroup::make(__('Residual risk'), [
                    TextColumn::make('residualImpact.title')
                        ->label(__('Impact')),
                    TextColumn::make('residualProbability.title')
                        ->label(__('Probability')),
                    TextColumn::make('residualLevel.title')
                        ->label(__('Level'))
                        ->badge()
                        ->color(fn ($record) => $record->residualLevel->color),
                ]),
                TextColumn::make('headquarter.name')
                    ->label(__('Headquarters'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->icon(Heroicon::Link)
                    ->tableSelect(RisksTable::class)
                    ->modalWidth(Width::FiveExtraLarge)
                    ->multiple()
                    ->attachAnother(false),
            ])
            ->recordActions([
                Action::make('go_to_risk')
                    ->label(__('Go'))
                    ->icon(Heroicon::ArrowTopRightOnSquare)
                    ->url(fn ($record) => RiskResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
                ViewAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([]);
    }
}
