<?php

namespace App\Filament\Dashboard\Resources\Docs\Tables;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Doc;
use App\Models\User;
use App\Services\VersionService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classification_code')
                    ->label(__('Classification code'))
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
                TextColumn::make('type.label')
                    ->label(__('Doc type')),
                TextColumn::make('process.title')
                    ->label(__('Process')),
                TextColumn::make('subprocess.title')
                    ->label(__('Subprocess')),
                TextColumn::make('latestVersion.status')
                    ->label(__('Status'))
                    ->badge()
                    ->placeholder('-'),
                TextColumn::make('latestVersion.version')
                    ->label(__('Version'))
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('confidential')
                    ->label(__('Confidential'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => (bool) $state ? __('Private') : __('Public'))
                    ->color(fn ($state) => (bool) $state ? 'warning' : 'success'),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->sortable()
                    ->since()
                    ->dateTooltip()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->sortable()
                    ->since()
                    ->dateTooltip()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('doc_type_id')
                    ->label(__('Doc type'))
                    ->relationship('type', 'label')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('process_id')
                    ->label(__('Process'))
                    ->relationship('process', 'title')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('subprocess_id')
                    ->label(__('Sub Process'))
                    ->relationship('subprocess', 'title')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options(StatusEnum::toOptions())
                    ->multiple()
                    ->query(function (Builder $query, array $data): Builder {
                        $values = $data['values'] ?? [];

                        if (empty($values)) {
                            return $query;
                        }

                        return $query->whereHas(
                            'latestVersion',
                            fn (Builder $q) => $q->whereIn('status', $values)
                        );
                    }),
                TernaryFilter::make('confidential')
                    ->label(__('Confidential'))
                    ->trueLabel(__('Private'))
                    ->falseLabel(__('Public'))
                    ->native(false),
                SelectFilter::make('headquarter_id')
                    ->label(__('Headquarters'))
                    ->relationship('headquarter', 'name')
                    ->native(false)
                    ->visible(fn () => auth()->user()->view_all_headquarters === (bool) true),
                TrashedFilter::make()
                    ->native(false),
            ])
            ->filtersTriggerAction(
                fn ($action) => $action->button()
            )
            ->filtersFormColumns(2)
            ->recordActions([
                ViewAction::make(),
                Action::make('latestApprovedVersion')
                    ->label(__('Download'))
                    ->icon(Heroicon::DocumentArrowDown)
                    ->color('primary')
                    ->url(fn (Doc $record) => $record->approvedVersionUrl())
                    ->openUrlInNewTab(false)
                    ->visible(fn (Doc $record) => $record->isAccessibleBy(auth()->user()))
                    ->disabled(fn (Doc $record) => ! $record->hasApprovedVersion())
                    ->extraAttributes(fn ($record) => [
                        'download' => $record->latestApprovedVersion?->file->name,
                    ]),
                ActionGroup::make([

                    Action::make('update_additional_users')
                        ->label(__('Update additional users'))
                        ->icon('heroicon-o-arrow-path')
                        ->color('primary')
                        ->schema(function ($record) {

                            // Helpers para no repetir tanto fn($get) / fn($set)
                            $isPrivate = fn ($get): bool => $get('confidential') === true;
                            $resetAccess = fn ($set) => $set('users', null);

                            return [
                                Toggle::make('confidential')
                                    ->label(__('Confidential'))
                                    ->inline(false)
                                    ->default($record->confidential)
                                    ->afterStateUpdated($resetAccess)
                                    ->columnSpanFull()
                                    ->reactive(),

                                Select::make('users')
                                    ->label(__('Access to additional users'))
                                    ->options(User::pluck('name', 'id'))
                                    ->default($record?->accessToAdditionalUsers?->pluck('id')->toArray())
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->visible($isPrivate),
                            ];
                        })
                        ->authorize(fn ($record): bool => auth()->user()->isLeaderOfSubProcess($record->subprocess_id))
                        ->action(function ($record, array $data) {

                            app(VersionService::class)->updateConfidentiality($record, $data);
                        }),
                    DeleteAction::make(), // Envía a papelera
                    RestoreAction::make(),      // Recupera de papelera
                    ForceDeleteAction::make()
                        ->visible(fn ($record): bool => auth()->user()->hasRole(RoleEnum::SUPER_ADMIN)), // Borrado físico permanente
                ])->color('primary')->link()->label(false)->tooltip('Actions'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                    // ForceDeleteBulkAction::make(),
                    // RestoreBulkAction::make(),
                ]),
            ]);
    }
}
