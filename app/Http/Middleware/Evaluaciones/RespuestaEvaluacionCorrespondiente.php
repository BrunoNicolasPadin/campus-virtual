<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\EvaluacionRespuesta;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RespuestaEvaluacionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $respuesta = EvaluacionRespuesta::find($link[12]);

        if ($respuesta->user_id == Auth::id()) {
            return $next($request);
        }

        abort(403, 'Esta respuesta no es tuyo.');
    }
}