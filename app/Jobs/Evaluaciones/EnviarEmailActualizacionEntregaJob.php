<?php

namespace App\Jobs\Evaluaciones;

use App\Mail\ActualizacionEntrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Roles\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarEmailActualizacionEntregaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entrega;

    public function __construct($entrega)
    {
        $this->entrega = $entrega;
    }

    public function handle()
    {
        $alumno = Alumno::with('padres', 'padres.user')->find($this->entrega->alumno_id);
        $to_email = $alumno->user->email;
        $evaluacion = Evaluacion::with('asignatura')->findOrFail($this->entrega->evaluacion_id);

        $email = 'gescolcontacto@gmail.com';
        $mensaje = 'Calificación: ' . $this->entrega->calificacion . ' | Comentario: ' . $this->entrega->comentario;
        $asunto = 'Actualización en la entraga de la asignatura ' . $evaluacion->asignatura->nombre;

        $detalles = [
            'titulo' => 'Nueva actualización en tu entrega en ' . $evaluacion->asignatura->nombre,
            'email' => $email,
            'mensaje' => $mensaje,
            'asunto' => $asunto,
        ];

        Mail::to($to_email)->send(new ActualizacionEntrega($detalles));

        foreach ($alumno->padres as $padre) {

            $to_email = $padre->user->email;
            $detalles = [
                'titulo' => 'Nueva actualización en la entrega de '. $alumno->user->name.  'en la asignatura ' . $evaluacion->asignatura->nombre,
                'email' => $email,
                'mensaje' => $mensaje,
                'asunto' => $asunto,
            ];
            
            Mail::to($to_email)->send(new ActualizacionEntrega($detalles));
        }
    }
}
