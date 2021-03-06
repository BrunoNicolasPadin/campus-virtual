<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\EvaluacionComentario;
use App\Services\Muro\EliminarService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class ComentarioCorrespondiente
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

        $comentario = EvaluacionComentario::select('evaluaciones_comentarios.user_id', 'evaluaciones.institucion_id')
            ->join('evaluaciones', 'evaluaciones.id', 'evaluaciones_comentarios.evaluacion_id')
            ->findOrFail($link[10]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($comentario->user_id, $comentario->institucion_id)) {
            return $next($request);
        }

        abort(403, 'Este comentario no es tuyo.');
    }
}
