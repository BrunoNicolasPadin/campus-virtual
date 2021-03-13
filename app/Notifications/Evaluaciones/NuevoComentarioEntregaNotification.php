<?php

namespace App\Notifications\Evaluaciones;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoComentarioEntregaNotification extends Notification
{
    use Queueable;

    protected $entregaComentario;
    
    public function __construct($entregaComentario)
    {
        $this->entregaComentario = $entregaComentario;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'usuario' => $this->entregaComentario->name,
            'asignatura' => $this->entregaComentario->nombre,
            'evaluacion' => $this->entregaComentario->titulo,
        ];
    }
}
