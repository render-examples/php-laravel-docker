<?php

namespace App\Notifications;

use App\Models\Reclamation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReclamationNotification extends Notification
{
    protected $reclamation;

    public function __construct($reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $eleve = $this->reclamation->eleve->user->nom_complet ?? 'Élève inconnu';
        return (new MailMessage)
            ->subject('Nouvelle réclamation de '.$eleve)
            ->greeting('Bonjour')
            ->line("Une nouvelle réclamation a été déposée par l'élève **$eleve**.")
            ->line("Type : {$this->reclamation->type}")
            ->line("Matière : {$this->reclamation->matiere->nom}")
            ->action('Voir les réclamations', url(route('reclamations.index')))
            ->line('Merci de traiter cette réclamation dans les plus brefs délais.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Nouvelle réclamation de ' . ($this->reclamation->eleve->user->nom_complet ?? 'Élève inconnu'),
            'reclamation_id' => $this->reclamation->id,
            'url' => route('reclamations.index'),
        ];
    }
}
