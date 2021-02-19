<?php

namespace App\Http\Middleware\Docentes;

use App\Models\Roles\Docente;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class DocenteCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $docente = Docente::find($link[6]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($docente->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este docente no forma parte de tu institución.');
        }

        if (session('tipo') == 'Docente') {
            if ($docente->id == session('tipo_id')) {
                return $next($request);
            }
            abort(403, 'Este docente no eres tú.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
