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
        $alumno = Alumno::with('padres', 'padres.user')->find($event->entrega->alumno_id);
        $to_email = $alumno->user->email;

        $detalles = [
            'titulo' => 'Nueva actualización en tu entrega de ' . $event->entrega->evaluacion->titulo . ' para ' . $event->entrega->evaluacion->asignatura->nombre,
            'email' => 'gescolcontacto@gmail.com',
            'mensaje' => 'Tu calificacion: ' . $event->entrega->calificacion . ' | Comentario: ' . $event->entrega->comentario,
            'asunto' => 'Actualización en la entraga',
        ];

        Mail::to($to_email)->send(new ActualizacionEntrega($detalles));

        foreach ($alumno->padres as $padre) {

            $to_email = $padre->user->email;
            $detalles = [
                'titulo' => 'Nueva actualización en la entrega de '. $event->entrega->evaluacion->titulo .' de tu hijo/a '. $alumno->user->name . ' para ' . $event->entrega->evaluacion->asignatura->nombre,
                'email' => 'gescolcontacto@gmail.com',
                'mensaje' => 'La calificacion: ' . $event->entrega->calificacion . ' | Comentario: ' . $event->entrega->comentario,
                'asunto' => 'Actualización en la entraga',
            ];
            
            Mail::to($to_email)->send(new ActualizacionEntrega($detalles));
        }
    }
}
