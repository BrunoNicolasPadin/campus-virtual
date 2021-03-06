<?php

namespace App\Http\Middleware\Materiales;

use App\Models\Estructuras\Division;
use App\Models\Materiales\Grupo;
use App\Services\Asignaturas\VerificarAsignatura;
use App\Services\Mesas\DeudorService;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;

class GrupoCorrespondiente
{
    protected $ruta;
    protected $asignaturaService;
    protected $deudorService;

    public function __construct(
        RutaService $ruta,
        VerificarAsignatura $asignaturaService,
        DeudorService $deudorService,
    )

    {
        $this->ruta = $ruta;
        $this->asignaturaService = $asignaturaService;
        $this->deudorService = $deudorService;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $grupo = Grupo::select('asignatura_id', 'division_id')
        ->addSelect(
            ['institucion_id' => Division::select('institucion_id')
                ->whereColumn('id', 'division_id')
                ->limit(1)
            ])
        ->findOrFail($link[8]);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($grupo->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Este grupo no forma parte de tu institución.');
        }

        if (session('tipo') == 'Docente') {
            if ($this->asignaturaService->verificarDocente($grupo->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Este grupo de archivos no es de una asignatura en la que eres docente.');
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            if ($grupo->division_id == session('division_id')) {
                return $next($request);
            }
            if ($this->deudorService->verificarGeneral($grupo->asignatura_id)) {
                return $next($request);
            }
            abort(403, 'Este grupo no forma parte de tu división.');
        }

        abort(403, 'No puedes estar aquí.');
    }
}
