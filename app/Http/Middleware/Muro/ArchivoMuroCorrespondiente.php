<?php

namespace App\Http\Middleware\Muro;

use App\Models\Muro\MuroArchivo;
use App\Services\Muro\EliminarService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class ArchivoMuroCorrespondiente
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

        $archivo = MuroArchivo::findOrFail($link[10]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($archivo->muro->user_id, $archivo->muro->division->institucion_id)) {
            return $next($request);
        }

        abort(403, 'Este archivo no es suyo.');
    }
}
