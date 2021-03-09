<?php

namespace App\Jobs\Estructuras;

use App\Jobs\Evaluaciones\EvaluacionDestroyJob;
use App\Jobs\Muro\PublicacionDestroyJob;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Muro\Muro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LimpiarDivisionesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $division_id;

    public function __construct(
        $division_id,
    )
    {
        $this->division_id = $division_id;
    }

    public function handle()
    {
        $evaluaciones = Evaluacion::where('division_id', $this->division_id)->get();
        foreach ($evaluaciones as $evaluacion) {
            EvaluacionDestroyJob::dispatch($evaluacion->id);
        }

        $publicaciones = Muro::where('division_id', $this->division_id)->get();
        foreach ($publicaciones as $publicacion) {
            PublicacionDestroyJob::dispatch($publicacion->id);
        }
    }
}
