<?php

namespace App\Notifications\Deudores;

use App\Models\Asignaturas\Asignatura;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ActualizacionMesaNotification extends Notification
{
    use Queueable;

    protected $mesa;
    
    public function __construct($mesa)
    {
        $this->mesa = $mesa;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $formatoFechaHora = new CambiarFormatoFechaHora();
        $asignatura = Asignatura::select('nombre')->findOrFail($this->mesa->asignatura_id);

        return [
            'fechaHoraRealizacion' => $formatoFechaHora->cambiarFormatoParaMostrar($this->mesa->fechaHoraRealizacion),
            'asignatura' => $asignatura->nombre,
        ];
    }
}
