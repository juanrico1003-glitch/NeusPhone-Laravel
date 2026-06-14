<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = route('password.reset', ['token' => $this->token, 'correo' => $notifiable->getEmailForPasswordReset()]);

        return (new MailMessage)
            ->subject('Restablece tu contraseña - NeusPhone')
            ->greeting('¡Hola, ' . ($notifiable->nombres ?? '') . '!')
            ->line('Recibiste este correo porque solicitaste restablecer tu contraseña en NeusPhone.')
            ->action('Restablecer contraseña', $url)
            ->line('Este enlace expirará en 60 minutos.')
            ->line('Si no solicitaste este cambio, puedes ignorar este mensaje.');
    }
}
