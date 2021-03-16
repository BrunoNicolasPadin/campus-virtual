<?php

namespace App\Jobs\Evaluaciones;

use App\Jobs\Eliminaciones\EliminarEva;
use App\Models\Evaluaciones\Archivo;
use App\Models\Evaluaciones\Entrega;
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
            Storage::disk('s3')->delete('Evaluaciones/Archivos/' . $archivo->archivo);
        }

        $entregas = Entrega::where('evaluacion_id', $this->evaluacion_id)->get();
        foreach ($entregas as $entrega) {

            EntregaDestroyJob::dispatch($entrega->id);
        }

        EliminarEva::dispatch($this->evaluacion_id);
    }
}
