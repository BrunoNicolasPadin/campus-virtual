<?php

namespace App\Http\Middleware\Muro;

use App\Models\Muro\Muro;
use App\Services\Muro\EliminarService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class PublicacionCorrespondiente
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

        $publicacion = Muro::select('muro.user_id', 'divisiones.institucion_id')
            ->join('divisiones', 'divisiones.id', 'muro.division_id')
            ->findOrFail($link[8]);

        if ($this->eliminarService->verificarUsuarioParaEliminar($publicacion->user_id, $publicacion->institucion_id)) {
            return $next($request);
        }
        abort(403, 'Esta publicación no es tuya.');
    }
}
