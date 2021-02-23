<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\EvaluacionRespuesta;
use App\Services\Muro\EliminarService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RespuestaEvaluacionCorrespondiente
{
    protected $ruta;
    protected $eliminarService;

    public function __construct(
        RutaService $ruta,
        EliminarService $eliminarService,
    )

    {
        $this->ruta = $ruta;
        $this->eliminarService = $eliminarService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $respuesta = EvaluacionRespuesta::findOrFail($link[12]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($respuesta->user_id, $respuesta->comentario->evaluacion->institucion_id)) {
            return $next($request);
        }
        abort(403, 'Esta respuesta no es tuya.');
    }
}
