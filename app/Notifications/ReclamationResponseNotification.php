<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReclamationResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

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
        return (new MailMessage)
            ->subject('Réponse à votre réclamation')
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre réclamation a été traitée. Voici les détails :')
            ->line('Matière : ' . $this->reclamation->matiere->nom)
            ->line('Statut : ' . ucfirst($this->reclamation->statut))
            ->line('Réponse : ' . $this->reclamation->reponse_admin)
            ->action('Voir le bulletin', route('bulletins.show', [
                'annee_academique_id' => $this->reclamation->bulletin->periode->annee_academique_id
            ]))
            ->line('Merci pour votre confiance.')
            ->salutation('Cordialement,');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Réponse à votre réclamation: ' . ucfirst($this->reclamation->statut),
            'link' => route('bulletins.show', [
                'annee_academique_id' => $this->reclamation->bulletin->periode->annee_academique_id
            ]),
            'type' => 'reclamation_response',
            'status' => $this->reclamation->statut,
            'subject' => $this->reclamation->matiere->nom,
        ];
    }
}