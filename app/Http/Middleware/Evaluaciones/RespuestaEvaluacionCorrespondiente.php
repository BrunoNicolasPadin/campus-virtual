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

        $respuesta = EvaluacionRespuesta::select('evaluaciones_respuestas.user_id', 'evaluaciones.institucion_id')
            ->join('evaluaciones_comentarios', 'evaluaciones_comentarios.id', 'evaluaciones_respuestas.comentario_id')
            ->join('evaluaciones', 'evaluaciones.id', 'evaluaciones_comentarios.evaluacion_id')
            ->findOrFail($link[12]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($respuesta->user_id, $respuesta->institucion_id)) {
            return $next($request);
        }
        abort(403, 'Esta respuesta no es tuya.');
    }
}
