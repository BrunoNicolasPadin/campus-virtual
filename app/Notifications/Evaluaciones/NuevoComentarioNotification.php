<?php

namespace App\Notifications\Evaluaciones;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoComentarioNotification extends Notification
{
    use Queueable;

    protected $evaluacionComentario;
    
    public function __construct($evaluacionComentario)
    {
        $this->evaluacionComentario = $evaluacionComentario;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'usuario' => $this->evaluacionComentario->name,
            'asignatura' => $this->evaluacionComentario->nombre,
            'evaluacion' => $this->evaluacionComentario->titulo,
        ];
    }
}
