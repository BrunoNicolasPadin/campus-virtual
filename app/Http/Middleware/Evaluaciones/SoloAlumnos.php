<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloAlumnos
{
    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Alumno' && Alumno::where('user_id', Auth::id())->exists()) {
            return $next($request);
        }
        if (session('tipo') == 'Padre' && Padre::where('user_id', Auth::id())->exists()) {
            return $next($request);
        }

        abort(403, 'Solo los alumnos y padres pueden realizar esta acción.');
    }
}
