<?php

namespace App\Listeners;

use App\Events\EntregaActualizada;
use App\Mail\ActualizacionEntrega;
use App\Models\Roles\Alumno;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailEntrega
{
    public function __construct()
    {
        //
    }

    public function handle(EntregaActualizada $event)
    {
        $alumno = Alumno::find($event->entrega->alumno_id);
        $to_email = $alumno->user->email;

        $detalles = [
            'titulo' => 'Nueva actualización en tu entrega de ' . $event->entrega->evaluacion->titulo,
            'email' => 'gescolcontacto@gmail.com',
            'mensaje' => 'Tu calificacion: ' . $event->entrega->calificacion . ' | Comentario: ' . $event->entrega->comentario,
            'asunto' => 'Actualización en la entraga',
        ];

        Mail::to($to_email)->send(new ActualizacionEntrega($detalles));
        return back();
    }
}
