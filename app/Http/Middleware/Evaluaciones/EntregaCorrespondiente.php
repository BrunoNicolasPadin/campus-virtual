<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\Entrega;
use App\Services\Roles\DocenteService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class EntregaCorrespondiente
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

        $entrega = Entrega::select('entregas.alumno_id', 'evaluaciones.asignatura_id', 'evaluaciones.institucion_id')
            ->join('evaluaciones', 'evaluaciones.id', 'entregas.evaluacion_id')
            ->join('divisiones', 'divisiones.id', 'evaluaciones.division_id')
            ->findOrFail($link[10]);

        if (session('tipo') == 'Docente') {
            if ($this->docenteService->verificarDocenteId($entrega->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Esta entrega de una evaluación no es de una asignatura en la que eres docente.');
        }

        if (session('tipo') == 'Alumno') {
            if ($entrega->alumno_id == session('tipo_id')) {
                return $next($request);
            }
            abort(403, 'Esta entrega no es tuya.');
        }

        if (session('tipo') == 'Padre') {
            if ($entrega->alumno_id == session('alumno_id')) {
                return $next($request);
            }
            abort(403, 'Esta entrega no es de tu hijo/a.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($entrega->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta entrega no forma parte de tu institución.');
        }

        abort(403, 'No puedes estar aquí.');
    }
}
