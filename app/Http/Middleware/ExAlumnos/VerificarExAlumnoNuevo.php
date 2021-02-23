<?php

namespace App\Http\Middleware\ExAlumnos;

use App\Models\Roles\Alumno;
use App\Models\Roles\ExAlumno;
use Closure;
use Illuminate\Http\Request;

class VerificarExAlumnoNuevo
{
    public function handle(Request $request, Closure $next)
    {
        $alumno = Alumno::findOrFail($request->alumno_id);

        if ($alumno->institucion_id == session('institucion_id')) {
            if (ExAlumno::where('alumno_id', $alumno->id)->exists()) {
                abort(403, 'Este alumno ya esta incluido en la lista de ex alumnos.');
            }
            return $next($request);
        }
        abort(403, 'Este alumno no es de tu institución.');
    }
}
