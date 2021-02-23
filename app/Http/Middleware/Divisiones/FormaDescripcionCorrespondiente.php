<?php

namespace App\Http\Middleware\Divisiones;

use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class FormaDescripcionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $formaDescripcion = FormaDescripcion::select('id')
            ->addSelect(
                ['institucion_id' => FormaEvaluacion::select('institucion_id')
                    ->whereColumn('id', 'forma_evaluacion_id')
                    ->limit(1)
                ])
            ->findOrFail($link[8]);

        if ($formaDescripcion->institucion_id  == session('institucion_id')) {
            return $next($request);
        }
        abort(403, 'Esta opción de forma de evaluación no es de tu institución.');
    }
}
