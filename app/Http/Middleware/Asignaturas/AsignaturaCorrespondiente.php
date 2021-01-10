<?php

namespace App\Http\Middleware\Asignaturas;

use App\Models\Asignaturas\Asignatura;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class AsignaturaCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $asignatura = Asignatura::find($link[8]);

        if ($asignatura->division->institucion_id == session('institucion_id')) {
            return $next($request);
        }
        abort(403, 'Esta asignatura no forma parte de la institucion de la que formas parte.');
    }
}
