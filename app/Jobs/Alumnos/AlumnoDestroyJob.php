<?php

namespace App\Jobs\Alumnos;

use App\Jobs\Deudores\InscripcionDestroyJob;
use App\Jobs\Eliminaciones\EliminarAlumno;
use App\Jobs\Evaluaciones\EntregaDestroyJob;
use App\Jobs\Muro\PublicacionDestroyJob;
use App\Models\Deudores\Inscripcion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Muro\Muro;
use App\Models\Roles\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AlumnoDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $alumno_id;

    public function __construct($alumno_id)
    {
        $this->alumno_id = $alumno_id;
    }

    public function handle()
    {
        $alumno = Alumno::select('user_id')->findOrFail($this->alumno_id);

        $publicaciones = Muro::where('user_id', $alumno->user_id)->get();
        foreach ($publicaciones as $publicacion) {
            PublicacionDestroyJob::dispatch($publicacion->id);
        }

        $entregas = Entrega::where('alumno_id', $this->alumno_id)->get();
        foreach ($entregas as $entrega) {
            EntregaDestroyJob::dispatch($entrega->id);
        }

        $inscripciones = Inscripcion::where('alumno_id', $this->alumno_id)->get();
        foreach ($inscripciones as $inscripcion) {
            InscripcionDestroyJob::dispatch($inscripcion->id);
        }

        EliminarAlumno::dispatch($this->alumno_id);
    }
}
