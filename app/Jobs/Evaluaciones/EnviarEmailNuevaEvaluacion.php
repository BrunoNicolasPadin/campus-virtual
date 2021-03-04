<?php

namespace App\Jobs\Evaluaciones;

use App\Events\EvaluacionCreada;
use App\Models\Evaluaciones\Entrega;
use App\Models\Roles\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarEmailNuevaEvaluacion implements ShouldQueue
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

        foreach ($alumnos as $alumno) {

            $entrega = new Entrega();
            $entrega->evaluacion_id = $this->evaluacion->id;
            $entrega->alumno_id = $alumno->id;
            $entrega->save();

            event(new EvaluacionCreada($this->evaluacion, $alumno));
        }
    }
}
