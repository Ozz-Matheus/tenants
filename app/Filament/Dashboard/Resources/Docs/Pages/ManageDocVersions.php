<?php

namespace App\Filament\Dashboard\Resources\Docs\Pages;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Filament\Dashboard\Resources\Docs\DocResource;
use App\Filament\Pages\FileViewer;
use App\Models\Subprocess;
use App\Services\VersionService;
use App\Services\VersionStatusService;
use App\Support\AppNotifier;
use App\Traits\HasStandardFileUpload;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ManageDocVersions extends ManageRelatedRecords
{
    use HasStandardFileUpload;

    protected static string $resource = DocResource::class;

    protected static string $relationship = 'versions';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;

    public function getTitle(): string
    {
        return __('Version History');
    }

    public static function getNavigationLabel(): string
    {
        return __('Versions');
    }

    protected function getHeaderActions(): array
    {

        return [
            Action::make('context')
                ->label($this->record?->getContextPath())
                ->icon(Heroicon::InformationCircle)
                ->disabled()
                ->color('gray'),

            CreateAction::make()
                ->label(__('New Version'))
                ->modalHeading() // Acá se le puede poner el titulo que se quiera al modal.
                ->createAnother(false)
                ->icon(Heroicon::DocumentPlus)
                ->modalWidth('2xl')
                ->schema([
                    static::baseFileUpload('path')
                        ->label(__('File'))
                        ->directory('docs/versions')
                        ->storeFileNamesIn('original_file_name')
                        ->required(),
                    Select::make('leads')
                        ->label(__('leads'))
                        ->required()
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->options(function () {
                            return Subprocess::find($this->record->subprocess_id)
                                ?->leaders()
                                ->pluck('users.name', 'users.id')
                                ?? [];
                        }),
                    Textarea::make('comment')
                        ->label(__('Comment'))
                        ->required()
                        ->maxLength(255),

                ])
                ->action(function (array $data, CreateAction $action) {

                    if (! auth()->user()->canAccessSubProcess($this->record->subprocess_id)) {
                        AppNotifier::danger(
                            __('Document'),
                            __('Not authorized to access this subprocess.'),
                            true
                        );
                        $action->halt();
                    }

                    app(VersionService::class)->createVersion($this->record, $data);
                }),
            Action::make('back')
                ->label(__('Return'))
                ->url(fn (): string => DocResource::getUrl('view', ['record' => $this->record]))
                ->icon(Heroicon::ArrowLeft)
                ->color('gray'),
        ];
    }

    public function getSubheading(): ?string
    {
        return $this->record?->title;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('version')
            ->columns([
                TextColumn::make('file.name')
                    ->label(__('Name'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->file->name)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->formatStateUsing(fn (string $state) => ucfirst(pathinfo($state, PATHINFO_FILENAME)))
                    ->searchable(),
                TextColumn::make('file.readable_mime_type')
                    ->label(__('Type')),
                TextColumn::make('file.readable_size')
                    ->label(__('Size'))
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('version')
                    ->label(__('Version'))
                    ->sortable(),
                TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->comment)
                    ->copyable()
                    ->copyMessage(__('Copied to clipboard'))
                    ->searchable(),
                TextColumn::make('createdBy.name')
                    ->label(__('Created by'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('sha256_hash')
                    ->label(__('Sha256_hash'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->sortable()
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('id', 'desc')
            ->filters([
                //
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options(StatusEnum::toOptions())
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->query(function (Builder $query, array $data): Builder {
                        $values = $data['values'] ?? [];

                        if (empty($values)) {
                            return $query;
                        }

                        return $query->whereIn('status', $values);
                    }),
            ])
            ->filtersTriggerAction(
                fn ($action) => $action->button()
            )
            ->recordActions([
                Action::make('file')
                    ->label(__('View File'))
                    ->icon('heroicon-s-eye')
                    ->color('gray')
                    ->url(fn ($record) => FileViewer::getUrl(['file' => $record->file]))
                    ->visible(
                        fn ($record) => auth()->user()->canAccessSubProcess($record->doc->subprocess_id)
                    ),
                ActionGroup::make([
                    Action::make('pending')
                        ->label(StatusEnum::PENDING->getLabel())
                        ->icon(StatusEnum::PENDING->getIcon())
                        ->color(StatusEnum::PENDING->getColor())
                        ->requiresConfirmation()
                        ->action(function ($record, array $data) {

                            app(VersionStatusService::class)->pending($record);

                            AppNotifier::success(
                                __('Version successfully ').StatusEnum::PENDING->getLabel()
                            );
                        })
                        ->visible(function ($record) {
                            return auth()->user()->canPending($record)
                                && $record->status === StatusEnum::DRAFT
                                && $record->isLatestVersion();
                        }),
                    DeleteAction::make()
                        ->visible(function () {
                            return auth()->user()->hasRole(RoleEnum::SUPER_ADMIN);
                        }),
                ])->color('primary')->link()->label(false)->tooltip('Actions'),
            ]);
    }
}
