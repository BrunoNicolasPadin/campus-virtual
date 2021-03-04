<?php

namespace App\Listeners;

use App\Events\InscripcionActualizada;
use App\Mail\ActualizacionInscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Roles\Alumno;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailInscripcion
{
    public function __construct()
    {
        //
    }

    public function handle(InscripcionActualizada $event)
    {
        $alumno = Alumno::with('padres', 'padres.user')->find($event->inscripcion->alumno_id);
        $to_email = $alumno->user->email;
        $mesa = Mesa::with('asignatura')->findOrFail($event->inscripcion->mesa_id);

        $detalles = [
            'titulo' => 'Nueva actualización en tu entrega en la asignatura que adeudas ' . $mesa->asignatura->nombre,
            'email' => 'gescolcontacto@gmail.com',
            'mensaje' => 'Tu calificacion: ' . $event->inscripcion->calificacion . ' | Comentario: ' . $event->inscripcion->comentario,
            'asunto' => 'Actualización en la entraga de la asignatura que adeudas ' . $mesa->asignatura->nombre,
        ];

        Mail::to($to_email)->send(new ActualizacionInscripcion($detalles));

        foreach ($alumno->padres as $padre) {

            $to_email = $padre->user->email;
            $detalles = [
                'titulo' => 'Nueva actualización en la entrega de tu hijo/a '. $alumno->user->name.  'en la asignatura que adeuda ' . $mesa->asignatura->nombre,
                'email' => 'gescolcontacto@gmail.com',
                'mensaje' => 'La calificacion: ' . $event->entrega->calificacion . ' | Comentario: ' . $event->entrega->comentario,
                'asunto' => 'Actualización en la entraga de la asignatura que adeuda ' . $mesa->asignatura->nombre,
            ];
            
            Mail::to($to_email)->send(new ActualizacionInscripcion($detalles));
        }
    }
}
