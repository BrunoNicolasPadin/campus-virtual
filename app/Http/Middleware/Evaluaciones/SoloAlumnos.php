<?php

namespace App\Http\Middleware\Evaluaciones;

use Closure;
use Illuminate\Http\Request;

class SoloAlumnos
{
    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($this->rolesService->verificarRol()) {
                return $next($request);
            }
        }
        abort(403, 'Solo los alumnos y padres pueden realizar esta acción.');
    }
}
