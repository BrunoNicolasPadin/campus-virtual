<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Roles\Alumno;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarInscripcion
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

            if ($fechaHora >= $this->formatoService->cambiarFormatoParaComparar($mesa->fechaHoraRealizacion)) {
                abort(403, 'No puedes inscribirte despues de la fecha y hora de la mesa.');
            }

            $alumno = Alumno::where('user_id', Auth::id())->where('institucion_id', session('institucion_id'))->first();

            if (Inscripcion::where('alumno_id', $alumno->id)->where('mesa_id', $link[10])->exists()) {
                abort(403, 'No puede inscribirse dos veces.');
            }
            return $next($request);
        }
        abort(403, 'No puedes estar aqui.');
        
    }
}
