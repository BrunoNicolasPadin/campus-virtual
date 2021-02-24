<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\Archivo;
use App\Services\Roles\DocenteService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class ArchivoCorrespondiente
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

        $archivo = Archivo::select('evaluaciones.asignatura_id', 'divisiones.institucion_id')
            ->join('evaluaciones', 'evaluaciones.id', 'evaluaciones_comentarios.evaluacion_id')
            ->join('divisiones', 'divisiones.id', 'muro.division_id')
            ->first($link[10]);

        if (session('tipo') == 'Docente') {

            if ($this->docenteService->verificarDocenteId($archivo->evaluacion->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Este archivo no forma parte de una evaluación tuya.');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($archivo->evaluacion->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este archivo no forman parte de tu institución.');
        }
        abort(403, 'No puedes estar aquí.');
    }
}
