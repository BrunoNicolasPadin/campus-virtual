<?php

namespace App\Observers;

use App\Jobs\Libretas\CrearLibretaJob;
use App\Models\Roles\Alumno;
/* use App\Models\Roles\ExAlumno; */

class AlumnoObserver
{
    public function created(Alumno $alumno)
    {
        CrearLibretaJob::dispatch($alumno);
    }

    public function updated(Alumno $alumno)
    {
        if ($alumno->isDirty('division_id')) {
            /* ExAlumno::where('alumno_id', $alumno->id)->delete(); */
            CrearLibretaJob::dispatch($alumno);
        }
    }
}
