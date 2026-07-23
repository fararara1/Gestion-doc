<?php

namespace App\Notifications;

use App\Models\Document;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentShared extends Notification
{
    use Queueable;

    public function __construct(public Document $document, public User $sharedBy, public string $droit)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Document partagé avec vous : ' . $this->document->titre)
            ->line($this->sharedBy->prenom . ' ' . $this->sharedBy->nom . ' vous a partagé le document « ' . $this->document->titre . ' » avec un droit de ' . $this->droit . '.')
            ->action('Voir le document', route('documents.show', $this->document));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'document_id' => $this->document->id,
            'document_titre' => $this->document->titre,
            'shared_by_name' => $this->sharedBy->prenom . ' ' . $this->sharedBy->nom,
            'droit' => $this->droit,
            'document_url' => route('documents.show', $this->document),
        ];
    }
}
