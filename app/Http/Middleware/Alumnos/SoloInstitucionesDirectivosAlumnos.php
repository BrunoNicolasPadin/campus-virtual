<?php

namespace App\Http\Middleware\Alumnos;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Padre;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloInstitucionesDirectivosAlumnos
{
    public function handle(Request $request, Closure $next)
    {
        $user_id = Auth::id();

        if (session('tipo') == 'Institucion' && Institucion::where('user_id', $user_id)
            ->exists()) {
            return $next($request);
        }

        if (session('tipo') == 'Directivo' && Directivo::where('user_id', $user_id)
            ->exists()) {
            return $next($request);
        }

        if (session('tipo') == 'Alumno' && Alumno::where('user_id', $user_id)
            ->exists()) {
            return $next($request);
        }

        if (session('tipo') == 'Padre' && Padre::where('user_id', $user_id)
            ->exists()) {
            return $next($request);
        }

        return abort(403, 'Usted no es una institucion o un directivo o un alumno como para realizar tal accion.');
    }
}
