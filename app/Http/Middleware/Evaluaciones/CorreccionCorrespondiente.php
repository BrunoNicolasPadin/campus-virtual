<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\Correccion;
use App\Services\Roles\DocenteService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class CorreccionCorrespondiente
{
    protected $ruta;
    protected $docenteService;

    public function __construct(
        RutaService $ruta, 
        DocenteService $docenteService
    )

    {
        $this->ruta = $ruta;
        $this->docenteService = $docenteService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $correccion = Correccion::select('evaluaciones.institucion_id', 'evaluaciones.asignatura_id')
            ->join('entregas', 'entregas.id', 'correcciones.entrega_id')
            ->join('evaluaciones', 'evaluaciones.id', 'entregas.evaluacion_id')
            ->findOrFail($link[12]);

        if (session('tipo') == 'Docente') {
            if ($this->docenteService->verificarDocenteId($correccion->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Esta corrección no es tuya.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($correccion->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta corrección no forma parte de tu institución');
        }

        abort(403, 'No puedes estar aquí.');
    }
}
