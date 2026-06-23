<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbandonedCartNotification extends Notification
{
    use Queueable;

    public $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/cart');

        return (new MailMessage)
            ->subject('Tu carrito te espera ☕ - PROCAFES')
            ->greeting('Hola '.$notifiable->name)
            ->line('Notamos que dejaste productos en tu carrito.')
            ->line('Tienes '.count($this->items).' productos esperando por ti.')
            ->action('Ver mi carrito', $url)
            ->line('¡No pierdas tu café favorito!');
    }
}