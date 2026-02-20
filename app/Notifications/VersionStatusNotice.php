<?php

namespace App\Notifications;

use App\Enums\StatusEnum;
use App\Filament\Pages\FileViewer;
use App\Models\DocVersion;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VersionStatusNotice extends Notification
{
    use Queueable;

    private DocVersion $version;

    private ?StatusEnum $status;

    private ?string $messageBody;

    /**
     * Create a new notification instance.
     */
    public function __construct(DocVersion $version, ?StatusEnum $status = null, ?string $messageBody = null)
    {
        $this->version = $version;
        $this->status = $status;
        $this->messageBody = $messageBody;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('emails.document_status_change.subject_email'))
            ->view('emails.version-status', [
                'user' => $notifiable,
                'version' => $this->version,
                'statusLabel' => $this->status?->getLabel(),
                'statusColor' => $this->status?->getColor(),
                'messageBody' => $this->messageBody,
            ]);
    }

    /**
     * Guardar la notificación en la base de datos (para Filament).
     */
    public function toDatabase(User $notifiable)
    {
        return FilamentNotification::make()
            ->title($this->version->file?->name)
            ->body(__('doc.version.status_notice').': '.$this->status?->getLabel())
            ->icon($this->status?->getIcon())
            ->color($this->status?->getColor())
            ->actions([
                Action::make('go_to_version')
                    ->label(__('Open'))
                    ->color($this->status?->getColor())
                    ->url(FileViewer::getUrl(['file' => $this->version->file]))
                    ->openUrlInNewTab(),
            ])
            ->getDatabaseMessage();
    }
}
