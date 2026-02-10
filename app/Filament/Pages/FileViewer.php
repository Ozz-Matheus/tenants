<?php

namespace App\Filament\Pages;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Filament\Dashboard\Resources\Docs\DocResource;
use App\Models\Doc;
use App\Models\DocVersion;
use App\Models\File;
use App\Models\UserVersionDecision;
use App\Services\VersionStatusService;
use App\Support\AppNotifier;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class FileViewer extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;

    protected string $view = 'filament.pages.file-viewer';

    public ?File $file = null;

    public ?Doc $doc = null;

    public $status = null;

    public $isConfidential = false;

    public static function getSlug(?Panel $panel = null): string
    {
        return 'file-viewer/{file}';
    }

    public function getTitle(): string
    {
        return __('File Viewer');
    }

    public function mount(File $file): void
    {
        $this->file = $file;

        if ($this->file->fileable_type === DocVersion::class) {

            $docVersion = DocVersion::findOrFail($this->file->fileable_id);

            $this->doc = Doc::findOrFail($docVersion->doc_id);

            $user = auth()->user();

            // Lógica de Confidencialidad
            if (! $this->doc->isAccessibleBy($user)) {

                AppNotifier::danger(
                    __('Document'),
                    __('You do not have permission to view this document.'),
                    true
                );

                abort(403);
            }

            $this->status = $this->file->fileable->status;
            $this->isConfidential = (bool) $this->doc->confidential;
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                UserVersionDecision::query()
                    // Filtramos solo si el archivo actual es una versión
                    ->where('version_id', $this->file->fileable_type === DocVersion::class ? $this->file->fileable_id : 0)
            )
            ->heading(__('Decision History'))
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('Leader'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('Decision'))
                    ->badge(),

                TextColumn::make('comment')
                    ->label(__('Comment'))
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->comment),

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
            ])
            ->recordActions([
                // APPROVED
                Action::make('approved')
                    ->label(StatusEnum::APPROVED->getLabel())
                    ->icon(StatusEnum::APPROVED->getIcon())
                    ->color(StatusEnum::APPROVED->getColor())
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn (UserVersionDecision $record) => $this->canVote($record))
                    ->action(fn (UserVersionDecision $record) => $this->updateDecision($record, StatusEnum::APPROVED, __('Approved version'))),
                // REJECTED
                Action::make('rejected')
                    ->label(StatusEnum::REJECTED->getLabel())
                    ->icon(StatusEnum::REJECTED->getIcon())
                    ->color(StatusEnum::REJECTED->getColor())
                    ->button()
                    ->form([
                        Textarea::make('comment')
                            ->label(__('Confirm Rejection'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder(__('Reason for rejection?')),
                    ])
                    ->visible(fn (UserVersionDecision $record) => $this->canVote($record))
                    ->action(fn (UserVersionDecision $record, array $data) => $this->updateDecision($record, StatusEnum::REJECTED, $data['comment'])),
                DeleteAction::make()
                    ->visible(function ($record) {
                        $user = auth()->user();

                        return $user && $user->hasRole(RoleEnum::SUPER_ADMIN);
                    }),
            ])
            ->paginated(false); // Opcional: Desactivar paginación si son pocos registros
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('Return'))
                ->url(fn (): string => $this->doc ? DocResource::getUrl('versions', ['record' => $this->doc]) : back()->getTargetUrl())
                ->icon(Heroicon::ArrowLeft)
                ->color('gray'),

        ];
    }

    public function getBreadcrumbs(): array
    {
        // Validación extra por si se visualiza un archivo que no es DocVersion
        if (! $this->doc) {
            return [];
        }

        return [
            DocResource::getUrl('index') => __('Documents'),
            DocResource::getUrl('view', ['record' => $this->doc->id]) => $this->doc->title,
            DocResource::getUrl('versions', ['record' => $this->doc->id]) => __('Versions'),
            false => __('File Viewer'),
        ];
    }

    public function getSubheading(): ?HtmlString
    {
        return new HtmlString('<strong class="text-gray-950">'.__('File name : ').'</strong>'.e($this->file->name));
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function canVote(UserVersionDecision $record): bool
    {
        // Regla de Propiedad: El usuario solo puede votar sobre SU propio registro.
        if ($record->user_id !== auth()->id()) {
            return false;
        }

        return $record->status == StatusEnum::PENDING;
    }

    protected function updateDecision(UserVersionDecision $record, ?StatusEnum $status, ?string $comment = null)
    {
        if (in_array($status, [StatusEnum::APPROVED, StatusEnum::REJECTED], true)) {

            $record->update([
                'status' => $status,
                'comment' => $comment,
            ]);

            $this->checkAndUpdateVersionStatus($record, $status);

            AppNotifier::success(__('Decision saved successfully'));
        }
    }

    protected function checkAndUpdateVersionStatus(UserVersionDecision $voterDecision, ?StatusEnum $status): bool
    {
        // Accedemos a la versión del documento a través de la relación.
        $version = $voterDecision->version;
        $currentUser = auth()->user();

        // Cuento todos los votantes asignados a esta versión.
        $totalDecisions = $version->leads()->count();

        if ($totalDecisions === 0) {
            return false;
        }

        // Instancia del servicio
        $versionStatusService = app(VersionStatusService::class);

        // Lógica de RECHAZO Inmediato (Voto de rechazo) ---
        // Si *cualquier* votante coloca 'rejected'.
        if ($status === StatusEnum::REJECTED) {

            // Llamamos al servicio para manejar el rechazo
            $versionStatusService->rejected($version);

            return true;
        }

        // Lógica de APROBACIÓN Total (Solo si el voto actual fue 'approved') ---
        if ($status === StatusEnum::APPROVED) {

            $approvedStatus = StatusEnum::APPROVED;

            // Contamos cuántas decisiones han sido *aprobadas*.
            $approvedCount = $version->leads()->wherePivot('status', $approvedStatus)->count();

            // Si el número de aprobados es igual al total de votantes, significa que todos votaron 'approved'.
            if ($approvedCount === $totalDecisions) {

                // Llamamos al servicio para manejar la aprobación
                $versionStatusService->approved($version);

                return true;
            }
        }

        return false; // La votación sigue pendiente (aún hay votos en 'pending').
    }
}
