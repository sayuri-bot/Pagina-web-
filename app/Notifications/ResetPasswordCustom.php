<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordCustom extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/reset-password/'.$this->token.'?email='.$notifiable->email);

    return (new MailMessage)
        ->subject('Recuperar contraseña - PROCAFES')
        ->line('Haz clic en el botón para cambiar tu contraseña')
        ->action('Restablecer contraseña', $url)
        ->line('Si no solicitaste esto, ignora este mensaje.');
        }
}