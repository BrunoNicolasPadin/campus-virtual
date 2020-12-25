<?php

namespace App\Http\Middleware\Alumnos;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $tipo = Auth::user()->tipo;

        if ($tipo == 'Institución') {
            return $this->verificarInstitucion($next, $request, $link);
        }
        if (Alumno::where('id', $link[6])
            ->where('user_id', Auth::id())
            ->exists()) {
            return $next($request);
        }

        return abort(403, 'No puedes ver informacion de este alumno.');
    }

    public function verificarInstitucion($next, $request, $link)
    {
        $institucion = Institucion::where('user_id', Auth::id())->first();

        if (Alumno::where('id', $link[6])
            ->where('institucion_id', $institucion['id'])
            ->exists()) {
            return $next($request);
        }
        return abort(403, 'Este alumno no forma parte de su institucion.');
    }
}
