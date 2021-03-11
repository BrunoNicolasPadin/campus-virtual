<?php

namespace App\Jobs\Users;

use App\Jobs\Deudores\InscripcionDestroyJob;
use App\Jobs\Eliminaciones\EliminarAlumno;
use App\Jobs\Evaluaciones\EntregaDestroyJob;
use App\Jobs\Instituciones\InstitucionDestroyJob;
use App\Jobs\Muro\PublicacionDestroyJob;
use App\Models\Deudores\Inscripcion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Instituciones\Institucion;
use App\Models\Muro\Muro;
use App\Models\Roles\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function handle()
    {
        if (Alumno::where('user_id', $this->user_id)->exists()) {
            $alumnos = Alumno::select('id', 'user_id')->where('user_id', $this->user_id)->get();
            foreach ($alumnos as $alumno) {

                $publicaciones = Muro::where('user_id', $alumno->user_id)->get();
                foreach ($publicaciones as $publicacion) {
                    PublicacionDestroyJob::dispatch($publicacion->id);
                }

                $entregas = Entrega::where('alumno_id', $alumno->id)->get();
                foreach ($entregas as $entrega) {
                    EntregaDestroyJob::dispatch($entrega->id);
                }

                $inscripciones = Inscripcion::where('alumno_id', $alumno->id)->get();
                foreach ($inscripciones as $inscripcion) {
                    InscripcionDestroyJob::dispatch($inscripcion->id);
                }

                EliminarAlumno::dispatch($alumno->id);
            }
        }

        if (Institucion::where('user_id', $this->user_id)->exists()) {
            $instituciones = Institucion::select('id')->where('user_id', $this->user_id)->get();
            foreach ($instituciones as $institucion) {
                InstitucionDestroyJob::dispatch($inscripcion->id);
            }
        }
    }
}
