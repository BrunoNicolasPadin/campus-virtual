<?php

namespace App\Jobs\Evaluaciones;

use App\Mail\CreacionEvaluacion;
use App\Models\Roles\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarEmailNuevaEvaluacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $evaluacion;

    public function __construct($evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }

    public function handle()
    {
        $alumnos = Alumno::where('division_id', $this->evaluacion->division_id)->get();

        $titulo = 'Nueva evaluación de ' . $this->evaluacion->asignatura->nombre;
        $email = 'gescolcontacto@gmail.com';
        $mensaje = $this->evaluacion->asignatura->nombre . 'creó un' . $this->evaluacion->tipo . ' para la fecha y hora ' . $this->evaluacion->fechaHoraRealizacion . ' y finalizará el ' . $this->evaluacion->fechaHoraFinalizacion;
        $asunto = 'Nueva evaluación';

        foreach ($alumnos as $alumno) {

            $alumno = Alumno::with('padres', 'padres.user')->findOrFail($alumno->id);
            $to_email = $alumno->user->email;

            $detalles = [
                'titulo' => $titulo,
                'email' => $email,
                'mensaje' => $mensaje,
                'asunto' => $asunto,
            ];

            Mail::to($to_email)->send(new CreacionEvaluacion($detalles));

            foreach ($alumno->padres as $padre) {

                $to_email = $padre->user->email;
                $detalles = [
                    'titulo' => $titulo . ' para tu  hijo/a '. $alumno->user->name,
                    'email' => $email,
                'mensaje' => $mensaje,
                'asunto' => $asunto,
                ];
                Mail::to($to_email)->send(new CreacionEvaluacion($detalles));
            }
        }
    }
}
