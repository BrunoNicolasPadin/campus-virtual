<?php

namespace App\Http\Middleware\Divisiones;

use App\Models\Estructuras\FormaEvaluacion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class FormaEvaluacionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $formaEvaluacion = FormaEvaluacion::find($link[6]);

        if ($formaEvaluacion->institucion_id  == session('institucion_id')) {
            return $next($request);
        }
        abort(403, 'Esta forma de evaluación no es de tu institución.');
    }
}
