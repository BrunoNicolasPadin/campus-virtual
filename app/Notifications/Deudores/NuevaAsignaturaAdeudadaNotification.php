<?php

namespace App\Notifications\Deudores;

use App\Models\Asignaturas\Asignatura;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaAsignaturaAdeudadaNotification extends Notification
{
    use Queueable;

    protected $alumnoDeudor;
    
    public function __construct($alumnoDeudor)
    {
        $this->alumnoDeudor = $alumnoDeudor;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $asignatura = Asignatura::select('nombre')->findOrFail($this->alumnoDeudor->asignatura_id);

        return [
            'asignatura' => $asignatura->nombre,
        ];
    }
}
