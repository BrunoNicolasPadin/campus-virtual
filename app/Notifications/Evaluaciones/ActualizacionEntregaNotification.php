<?php

namespace App\Notifications\Evaluaciones;

use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActualizacionEntregaNotification extends Notification
{
    use Queueable;

    protected $entrega;
    
    public function __construct($entrega)
    {
        $this->entrega = $entrega;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $evaluacion = Evaluacion::with('asignatura')->findOrFail($this->entrega->evaluacion_id);

        return [
            'calificacion' => $this->entrega->calificacion,
            'comentario' => $this->entrega->comentario,
            'evaluacion' => $evaluacion->titulo,
            'asignatura' => $evaluacion->asignatura->nombre,
        ];
    }
}
