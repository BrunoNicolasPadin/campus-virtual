<?php

namespace App\Jobs\Estructuras;

use App\Jobs\Evaluaciones\EvaluacionDestroyJob;
use App\Jobs\Muro\PublicacionDestroyJob;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroArchivo;
use App\Services\Archivos\EliminarEntregasCorrecciones;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class LimpiarDivisiones implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $institucion_id;
    protected $request;

    public function __construct(
        $institucion_id, 
        $request,
    )
    {
        $this->institucion_id = $institucion_id;
        $this->request = $request;
    }

    public function handle()
    {
        for ($i=0; $i < count($this->request['division_id']); $i++) { 
            $this->dispatch(new EvaluacionDestroyJob($this->request['division_id']));
            $publicaciones = Muro::where('division_id', $this->request['division_id'])->get();
            foreach ($publicaciones as $publicacion) {
                $this->dispatch(new PublicacionDestroyJob($publicacion->id));
            }
        }
    }
}
