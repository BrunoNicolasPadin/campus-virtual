<?php

namespace App\Http\Middleware\Muro;

use App\Models\Muro\MuroRespuesta;
use App\Services\Muro\EliminarService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RespuestaMuroCorrespondiente
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

        $respuesta = MuroRespuesta::select('muro.user_id', 'divisiones.institucion_id')
            ->join('muro', 'muro.id', 'muro_archivos.muro_id')
            ->join('divisiones', 'divisiones.id', 'muro.division_id')
            ->findOrFail($link[10]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($respuesta->user_id, $respuesta->institucion_id)) {
            return $next($request);
        }
        abort(403, 'Esta respuesta no es tuya.');
    }
}
