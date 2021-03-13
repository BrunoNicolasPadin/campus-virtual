<?php

namespace App\Notifications\Deudores;

use App\Models\Deudores\Mesa;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActualizacionInscripcionNotification extends Notification
{
    use Queueable;

    protected $inscripcion;
    
    public function __construct($inscripcion)
    {
        $this->inscripcion = $inscripcion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $formatoFechaHora = new CambiarFormatoFechaHora();
        $mesa = Mesa::with('asignatura')->findOrFail($this->inscripcion->mesa_id);

        return [
            'calificacion' => $this->inscripcion->calificacion,
            'comentario' => $this->inscripcion->comentario,
            'fechaHoraRealizacion' => $formatoFechaHora->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
            'asignatura' => $mesa->asignatura->nombre,
        ];
    }
}
