<?php

namespace App\Http\Middleware\ExAlumnos;

use App\Models\Roles\Alumno;
use Closure;
use Illuminate\Http\Request;

class VerificarExAlumnoNuevo
{
    public function handle(Request $request, Closure $next)
    {
        $alumno = Alumno::findOrFail($request->alumno_id);
        if ($alumno->institucion_id == session('institucion_id')) {
            return $next($request);
        }
        abort(403, 'Este alumno no es de tu institucion.');
    }
}
