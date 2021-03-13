<?php

namespace App\Notifications\Libretas;

use App\Models\Libretas\Libreta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActualizacionLibretaNotification extends Notification
{
    use Queueable;

    protected $calificacion;
    
    public function __construct($calificacion)
    {
        $this->calificacion = $calificacion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $libreta = Libreta::with('asignatura')->findOrFail($this->calificacion->libreta_id);

        return [
            'calificacion' => $this->calificacion->calificacion,
            'periodo' => $this->calificacion->periodo,
            'asignatura' => $libreta->asignatura->nombre,
        ];
    }
}
