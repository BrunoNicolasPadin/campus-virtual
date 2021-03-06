<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\EntregaComentario;
use App\Services\Muro\EliminarService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class EntregaComentarioCorrespondiente
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

        $comentario = EntregaComentario::select('evaluaciones.institucion_id', 'entregas_comentarios.user_id')
            ->join('entregas', 'entregas.id', 'entregas_comentarios.entrega_id')
            ->join('evaluaciones', 'evaluaciones.id', 'entregas.evaluacion_id')
            ->findOrFail($link[12]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($comentario->user_id, $comentario->institucion_id)) {
            return $next($request);
        }

        abort(403, 'Este comentario no es tuyo.');
    }
}
