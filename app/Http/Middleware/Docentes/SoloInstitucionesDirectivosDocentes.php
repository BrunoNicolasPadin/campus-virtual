<?php

namespace App\Http\Middleware\Docentes;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloInstitucionesDirectivosDocentes
{
    public function handle(Request $request, Closure $next)
    {
        if (Institucion::where('user_id', Auth::id())
            ->exists()) {
            return $next($request);
        }

        if (Directivo::where('user_id', Auth::id())
            ->exists()) {
            return $next($request);
        }

        if (Docente::where('user_id', Auth::id())
            ->exists()) {
            return $next($request);
        }

        return abort(403, 'Usted no es una institucion o un directivo o un docente como para realizar tal accion.');
    }
}
