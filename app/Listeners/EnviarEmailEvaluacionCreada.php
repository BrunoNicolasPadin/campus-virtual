<?php

namespace App\Listeners;

use App\Events\EvaluacionCreada;
use App\Mail\CreacionEvaluacion;
use App\Models\Roles\Alumno;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EnviarEmailEvaluacionCreada
{
    public function __construct()
    {
        //
    }

    public function handle(EvaluacionCreada $event)
    {
        $alumno = Alumno::with('padres', 'padres.user')->findOrFail($event->alumno->id);
        $to_email = $alumno->user->email;

        $detalles = [
            'titulo' => 'Nueva evaluación de ' . $event->evaluacion->asignatura->nombre,
            'email' => 'gescolcontacto@gmail.com',
            'mensaje' => $event->evaluacion->asignatura->nombre . 'creó un' . $event->evaluacion->tipo . ' para la fecha y hora ' . $event->evaluacion->fechaHoraRealizacion . ' y finalizará el ' . $event->evaluacion->fechaHoraFinalizacion,
            'asunto' => 'Nueva evaluación',
        ];

        Mail::to($to_email)->send(new CreacionEvaluacion($detalles));

        foreach ($alumno->padres as $padre) {

            $to_email = $padre->user->email;
            $detalles = [
                'titulo' => 'Nueva evaluación de ' . $event->evaluacion->asignatura->nombre . ' para tu  hijo/a '. $alumno->user->name,
                'email' => 'gescolcontacto@gmail.com',
                'mensaje' => $event->evaluacion->asignatura->nombre . 'creó un' . $event->evaluacion->tipo . ' para la fecha y hora ' . $event->evaluacion->fechaHoraRealizacion . ' y finalizará el ' . $event->evaluacion->fechaHoraFinalizacion,
                'asunto' => 'Nueva evaluación',
            ];
            Mail::to($to_email)->send(new CreacionEvaluacion($detalles));
        }
    }
}
