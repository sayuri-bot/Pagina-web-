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
        ->view('emails.abandoned-cart', [
            'user' => $notifiable,
            'items' => $this->items,
            'url' => $url
        ]);
}
}