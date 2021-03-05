<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\Mesa;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class VerificarDesinscripcion
{
    protected $ruta;
    protected $obtenerFechaHoraService;
    protected $formatoService;

    public function __construct(
        RutaService $ruta,
        ObtenerFechaHoraService $obtenerFechaHoraService,
        CambiarFormatoFechaHora $formatoService,
    )

    {
        $this->ruta = $ruta;
        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->formatoService = $formatoService;
    }

    public function handle(Request $request, Closure $next)
    {
        if (session('tipo') == 'Alumno') {
            $link = $this->ruta->obtenerRoute();
            $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
            $mesa = Mesa::select('fechaHoraRealizacion')->findOrFail($link[10]);

            if ($fechaHora >= $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion)) {
                abort(403, 'No puedes desinscribirte despues de la fecha y hora de la mesa.');
            }
            return $next($request);
        }
        return $next($request);
    }
}
