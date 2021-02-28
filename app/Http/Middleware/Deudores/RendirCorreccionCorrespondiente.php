<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\RendirCorreccion;
use App\Services\Roles\DocenteService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class RendirCorreccionCorrespondiente
{
    protected $ruta;
    protected $docenteService;

    public function __construct(RutaService $ruta, DocenteService $docenteService)
    {
        $this->ruta = $ruta;
        $this->docenteService = $docenteService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();
        $correccion = RendirCorreccion::select('mesas.asignatura_id', 'mesas.institucion_id')
            ->join('anotados', 'anotados.id', 'rendir_correcciones.anotado_id')
            ->join('mesas', 'mesas.id', 'anotados.mesa_id')
            ->findOrFail($link[14]);

        if (session('tipo') == 'Docente') {
            if ($this->docenteService->verificarDocenteId($correccion->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura a la que pertenece esta corrección.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($correccion->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta corrección no es de tu institución');
        }
    }
}
