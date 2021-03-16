<?php

namespace App\Notifications\Muro;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaRespuestaNotification extends Notification
{
    use Queueable;

    protected $respuesta;
    
    public function __construct($respuesta)
    {
        $this->respuesta = $respuesta;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'usuario' => $this->respuesta->name,
            'muro_id' => $this->respuesta->muro_id,
            'division_id' => $this->respuesta->division_id,
            'institucion_id' => $this->respuesta->institucion_id,
        ];
    }
}
