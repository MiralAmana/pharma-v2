<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommandeStatutMisAJour extends Notification
{
    use Queueable;

    public function __construct(public Commande $commande)
    {
        //
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Commande '.$this->commande->reference.' — mise à jour');

        if ($this->commande->statut === 'validée') {
            $message->greeting('Bonne nouvelle !')
                ->line('Votre commande '.$this->commande->reference.' a été validée par la pharmacie.')
                ->line('Elle est en cours de préparation.');
        } else {
            $message->greeting('Commande annulée')
                ->line('Votre commande '.$this->commande->reference.' a été annulée.')
                ->line('Contactez la pharmacie si vous pensez qu\'il s\'agit d\'une erreur.');
        }

        return $message
            ->line('Montant total : '.number_format($this->commande->total, 0, ',', ' ').' FCFA')
            ->action('Voir mes commandes', route('client.commandes.index'));
    }
}
