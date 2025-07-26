<?php

namespace App\Filament\Dashboard\Resources\ControlResource\RelationManagers;

use App\Services\ControlService;
use App\Traits\HasStandardFileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ControlFilesRelationManager extends RelationManager
{
    use HasStandardFileUpload;

    protected static string $relationship = 'controlFiles';

    protected static ?string $title = null;

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Support files');
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')
                ->label(__('Name'))
                ->formatStateUsing(fn (string $state) => ucfirst(pathinfo($state, PATHINFO_FILENAME)))
                ->searchable(),
            Tables\Columns\TextColumn::make('readable_mime_type')
                ->label(__('Type')),
            Tables\Columns\TextColumn::make('readable_size')
                ->label(__('Size')),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('Created at'))
                ->date('l, d \d\e F \d\e Y'),
        ])
            ->headerActions([
                Tables\Actions\Action::make('create')
                    ->label(__('New support files'))
                    ->button()
                    ->color('primary')
                    ->form([
                        static::baseFileUpload('path')
                            ->label(__('Files data'))
                            ->directory('audits/controls/files')
                            ->multiple()
                            ->maxParallelUploads(1)
                            ->columnSpanFull()
                            ->required(),
                    ])
                /* ->authorize(
                        fn () => app(TaskService::class)->canTaskUploadFollowUp($this->getOwnerRecord())
                    ) */
                    ->action(function (array $data) {
                        app(ControlService::class)->createFiles($this->getOwnerRecord(), $data);
                        /* redirect(ActionResource::getUrl('action_tasks.view', [
                        'action' => $this->getOwnerRecord()->action_id,
                        'record' => $this->getOwnerRecord()->id,
                        ])) */
                    }),
            ])
            ->actions([
                //
                Tables\Actions\Action::make('file')
                    ->label(__('Download'))
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('primary')
                    ->url(
                        fn ($record) => $record->url(),
                    )
                    ->openUrlInNewTab(false)
                    ->extraAttributes(fn ($record) => [
                        'download' => $record->name,
                    ]),
            ]);
    }
}
