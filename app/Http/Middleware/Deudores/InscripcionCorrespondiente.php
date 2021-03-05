<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Roles\Alumno;
use App\Services\Asignaturas\VerificarAsignatura;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class InscripcionCorrespondiente
{
    protected $ruta;
    protected $asignaturaService;

    public function __construct(
        RutaService $ruta,
        VerificarAsignatura $asignaturaService,
    )

    {
        $this->ruta = $ruta;
        $this->asignaturaService = $asignaturaService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $inscripcion = Inscripcion::select('alumno_id')
            ->addSelect(
                ['institucion_id' => Alumno::select('institucion_id')
                    ->whereColumn('id', 'alumno_id')
                    ->limit(1),
                'asignatura_id' => Mesa::select('asignatura_id')
                    ->whereColumn('id', 'mesa_id')
                    ->limit(1)
                ])
            ->findOrFail($link[12]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo' ) {
            if (session('institucion_id') == $inscripcion->institucion_id) {
                return $next($request);
            }
            abort(403, 'Esta inscripción es de un alumno que no forma parte de tu institución.');
        }

        if (session('tipo') == 'Docente') {
            if ($this->asignaturaService->verificarDocente($inscripcion->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Usted no es docente de la asignatura en la que se inscribió este alumno.');
        }

        if (session('tipo') == 'Alumno' ) {
            
            if (session('tipo_id') == $inscripcion->alumno_id) {
                return $next($request);
            }
            abort(403, 'Esta no es tu inscripción.');
        }

        if (session('tipo') == 'Padre' ) {
            if (session('alumno_id') == $inscripcion->alumno_id) {
                return $next($request);
            }
            abort(403, 'Esta no es la inscripción de su hijo/a.');
        }

        abort(403, 'No puede estar aquí.');
    }
}
