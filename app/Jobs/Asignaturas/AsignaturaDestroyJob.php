<?php

namespace App\Jobs\Asignaturas;

use App\Jobs\Deudores\MesaDestroyJob;
use App\Jobs\Evaluaciones\EvaluacionDestroyJob;
use App\Jobs\Materiales\GrupoDestroyJob;
use App\Models\Asignaturas\Asignatura;
use App\Models\Deudores\Mesa;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Materiales\Grupo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AsignaturaDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $asignatura_id;

    public function __construct($asignatura_id)
    {
        $this->asignatura_id = $asignatura_id;
    }

    public function handle()
    {
        $grupos = Grupo::where('asignatura_id', $this->asignatura_id)->get();
        foreach ($grupos as $grupo) {
            $this->dispatch(new GrupoDestroyJob($grupo->id));
        }

        $evaluaciones = Evaluacion::where('asignatura_id', $this->asignatura_id)->get();
        foreach ($evaluaciones as $evaluacion) {
            $this->dispatch(new EvaluacionDestroyJob($evaluacion->id));
        }

        $mesas = Mesa::where('asignatura_id', $this->asignatura_id)->get();
        foreach ($mesas as $mesa) {
            $this->dispatch(new MesaDestroyJob($mesa->id));
        }

        Asignatura::destroy($this->asignatura_id);
    }
}
