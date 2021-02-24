<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\RendirComentario;
use App\Services\Muro\EliminarService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendirComentarioCorrespondiente
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

        $comentario = RendirComentario::select('comentario.user_id', 'alumnos.institucion_id')
            ->join('anotados', 'anotados.id', 'rendir_comentarios.anotado_id')
            ->join('alumnos', 'alumnos.id', 'anotados.alumno_id')
            ->first($link[14]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($comentario->user_id, $comentario->institucion_id)) {
            return $next($request);
        }
        abort(403, 'Este comentario no es tuyo.');
    }
}
