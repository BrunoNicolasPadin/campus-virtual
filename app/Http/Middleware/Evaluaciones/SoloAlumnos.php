<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Roles\Alumno;
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
        abort(403, 'Solo los alumnos pueden realizar esta accion.');
    }
}
