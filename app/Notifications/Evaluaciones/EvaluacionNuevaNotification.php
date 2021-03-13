<?php

namespace App\Notifications\Evaluaciones;

use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EvaluacionNuevaNotification extends Notification
{
    use Queueable;

    protected $evaluacion;
    
    public function __construct($evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $formatoFechaHora = new CambiarFormatoFechaHora();
        return [
            'titulo' => $this->evaluacion->titulo,
            'tipo' => $this->evaluacion->tipo,
            'fechaHoraRealizacion' => $formatoFechaHora->cambiarFormatoParaMostrar($this->evaluacion->fechaHoraRealizacion),
            'fechaHoraFinalizacion' => $formatoFechaHora->cambiarFormatoParaMostrar($this->evaluacion->fechaHoraFinalizacion),
            'asignatura' => $this->evaluacion->asignatura->nombre,
        ];
    }
}
