<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Document;

class DocumentShared extends Notification
{
    use Queueable;

    public Document $document;
    public string $droit;

    public function __construct(Document $document, string $droit)
    {
        $this->document = $document;
        $this->droit = $droit;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('documents.show', $this->document);

        return (new MailMessage)
            ->subject('Document partagé avec vous : ' . $this->document->titre)
            ->greeting('Bonjour ' . $notifiable->prenom . ',')
            ->line('Le document **' . $this->document->titre . '** a été partagé avec vous.')
            ->line('**Droit d\'accès :** ' . $this->droit)
            ->action('Voir le document', $url)
            ->line('Merci d\'utiliser ' . config('app.name') . '.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'document_id' => $this->document->id,
            'document_titre' => $this->document->titre,
            'droit' => $this->droit,
            'message' => 'Le document "' . $this->document->titre . '" a été partagé avec vous en ' . $this->droit . '.',
        ];
    }
}
