<?php

namespace App\Http\Middleware\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitucionYaCreada
{
    public function handle(Request $request, Closure $next)
    {
        if (Institucion::where('user_id', Auth::id())
            ->exists()) {
            return abort(403, 'Usted ya esta registrado como institucion.');
        }

        if (Directivo::where('user_id', Auth::id())
            ->exists()) {
            return abort(403, 'Usted ya esta registrado con otro tipo de cuenta (Directivo)');
        }

        if (Docente::where('user_id', Auth::id())
            ->exists()) {
            return abort(403, 'Usted ya esta registrado con otro tipo de cuenta (Docente)');
        }

        if (Alumno::where('user_id', Auth::id())
            ->exists()) {
            return abort(403, 'Usted ya esta registrado con otro tipo de cuenta (Alumno)');
        }

        if (Padre::where('user_id', Auth::id())
            ->exists()) {
            return abort(403, 'Usted ya esta registrado con otro tipo de cuenta (Padre)');
        }

        return $next($request);
    }
}
