<?php

namespace App\Notifications\Deudores;

use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoComentarioNotification extends Notification
{
    use Queueable;

    protected $comentarioInscripcion;
    
    public function __construct($comentarioInscripcion)
    {
        $this->comentarioInscripcion = $comentarioInscripcion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $formatoFechaHora = new CambiarFormatoFechaHora();
        return [
            'usuario' => $this->comentarioInscripcion->name,
            'asignatura' => $this->comentarioInscripcion->nombre,
            'fechaHoraRealizacion' => $formatoFechaHora->cambiarFormatoParaMostrar($this->comentarioInscripcion->fechaHoraRealizacion),
        ];
    }
}
