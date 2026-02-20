<?php

namespace App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Risks\RelationManagers;

use App\Enums\EffectivenessLevelEnum;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\ControlResource;
use App\Filament\Dashboard\Clusters\RisksAndOpportunities\Resources\Controls\Tables\ControlsTable;
use Filament\Actions\Action;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DetachAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ControlsRelationManager extends RelationManager
{
    protected static string $relationship = 'controls';

    public function form(Schema $schema): Schema
    {
        return ControlResource::form($schema);
    }

    public function infolist(Schema $schema): Schema
    {
        return ControlResource::infolist($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('nature_of_control')
                    ->label(__('Nature of Control'))
                    ->searchable(),
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->title)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('automation_level')
                    ->label(__('Automation Level'))
                    ->searchable(),
                TextColumn::make('frequency')
                    ->label(__('Frequency'))
                    ->searchable(),
                TextColumn::make('effectiveness_rating')
                    ->label(__('Effectiveness rating'))
                    ->suffix('%')
                    ->sortable(),
                TextColumn::make('effectiveness_level')
                    ->label(__('Effectiveness level'))
                    ->badge(),
                TextColumn::make('responsible.name')
                    ->label(__('Responsible'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->icon(Heroicon::Link)
                    ->tableSelect(ControlsTable::class)
                    ->modalWidth(Width::FiveExtraLarge)
                    ->multiple()
                    ->attachAnother(false),
                CreateAction::make()
                    ->icon(Heroicon::PlusCircle)
                    ->mutateDataUsing(function (array $data): array {
                        $userId = auth()->id();

                        $data['effectiveness_rating'] = 0;
                        $data['effectiveness_level'] = EffectivenessLevelEnum::INEFFECTIVE;
                        $data['created_by_id'] = $userId;
                        $data['updated_by_id'] = $userId;

                        return $data;
                    }),
            ])
            ->recordActions([
                Action::make('go_to_control')
                    ->label(__('Go'))
                    ->icon(Heroicon::ArrowTopRightOnSquare)
                    ->url(fn ($record) => ControlResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
                ViewAction::make(),
                DetachAction::make(),
            ])
            ->toolbarActions([]);
    }
}
