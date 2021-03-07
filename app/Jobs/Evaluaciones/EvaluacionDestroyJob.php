<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Evaluaciones\Archivo;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EvaluacionDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $evaluacion_id;

    public function __construct($evaluacion_id)
    {
        $this->evaluacion_id = $evaluacion_id;
    }

    public function handle()
    {
        $archivos = Archivo::where('evaluacion_id', $this->evaluacion_id)->get();
        foreach ($archivos as $archivo) {
            Storage::delete('public/Evaluaciones/Archivos/' . $archivo->archivo);
        }

        $entregas = Entrega::where('evaluacion_id', $this->evaluacion_id)->get();
        foreach ($entregas as $entrega) {

            $this->dispatch(new EntregaDestroyJob($entrega->id));
        }

        Evaluacion::destroy($this->evaluacion_id);
    }
}
