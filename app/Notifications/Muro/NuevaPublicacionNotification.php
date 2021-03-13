<?php

namespace App\Notifications\Muro;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaPublicacionNotification extends Notification
{
    use Queueable;

    protected $muro;
    
    public function __construct($muro)
    {
        $this->muro = $muro;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'usuario' => $this->muro->name,
        ];
    }
}
