<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewReclamationNotification extends Notification
{
    use Queueable;

    protected $reclamation;

    public function __construct($reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle réclamation reçue')
                    ->line('Une nouvelle réclamation a été soumise par ' . $this->reclamation->eleve->user->name)
                    ->action('Voir la réclamation', url('/reclamations'))
                    ->line('Type: ' . ucfirst(str_replace('_', ' ', $this->reclamation->type)));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Nouvelle réclamation de ' . $this->reclamation->eleve->user->name,
            'link' => '/reclamations',
            'type' => 'new_reclamation'
        ];
    }
}