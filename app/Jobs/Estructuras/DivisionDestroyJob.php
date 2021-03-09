<?php

namespace App\Jobs\Estructuras;

use App\Jobs\Asignaturas\AsignaturaDestroyJob;
use App\Jobs\Eliminaciones\EliminarDivision;
use App\Jobs\Muro\PublicacionDestroyJob;
use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use App\Models\Muro\Muro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DivisionDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $division_id;

    public function __construct($division_id)
    {
        $this->division_id = $division_id;
    }

    public function handle()
    {
        $asignaturas = Asignatura::where('division_id', $this->division_id)->get();
        foreach ($asignaturas as $asignatura) {
            AsignaturaDestroyJob::dispatch($asignatura->id);
        }

        $publicaciones = Muro::where('division_id', $this->division_id)->get();
        foreach ($publicaciones as $publicacion) {
            PublicacionDestroyJob::dispatch($publicacion->id);
        }

        EliminarDivision::dispatch($this->division_id);
    }
}
