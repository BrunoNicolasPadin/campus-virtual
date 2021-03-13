<?php

namespace App\Notifications\Evaluaciones;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaRespuestaNotification extends Notification
{
    use Queueable;

    protected $evaluacionRespuesta;
    
    public function __construct($evaluacionRespuesta)
    {
        $this->evaluacionRespuesta = $evaluacionRespuesta;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'usuario' => $this->evaluacionRespuesta->name,
            'asignatura' => $this->evaluacionRespuesta->nombre,
            'evaluacion' => $this->evaluacionRespuesta->titulo,
        ];
    }
}
