<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaEvaluacion;
use App\Models\Libretas\Libreta;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\CiclosLectivos\CicloLectivoService;
use App\Services\Division\DivisionService;
use App\Services\Division\ObtenerPeriodosEvaluacion;
use Inertia\Inertia;

class AsignaturaEstadisticaController extends Controller
{
    protected $periodoService;
    protected $divisionService;
    protected $asignaturaService;
    protected $cicloLectivoService;

    public function __construct(
        ObtenerPeriodosEvaluacion $periodoService,
        DivisionService $divisionService,
        AsignaturaService $asignaturaService,
        CicloLectivoService $cicloLectivoService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('asignaturaCorrespondiente');

        $this->periodoService = $periodoService;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
        $this->cicloLectivoService = $cicloLectivoService;
    }

    public function mostrarEstadisticas($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Asignaturas/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'asignatura'  => $this->asignaturaService->find($asignatura_id),
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function mostrarPromedios($institucion_id, $division_id, $asignatura_id, $ciclo_lectivo_id)
    {
        $division = Division::select('forma_evaluacion_id', 'periodo_id')->findOrFail($division_id);

        $periodos = $this->periodoService->obtenerPeriodos($division);

        $totalPeriodo = [];
        $cantidadPeriodo = [];
        $promedios = [];

        $calificacionAlumno = [];
        $calificacionesAlumnos = [];

        for ($i=0; $i < count($periodos); $i++) { 
            $totalPeriodo[$i] = 0;
            $cantidadPeriodo[$i] = 0;
            $promedios[$i] = 0;

            $calificacionAlumno[$i] = 0;
        }

        $formaEvaluacion = FormaEvaluacion::select('tipo')->findOrFail($division->forma_evaluacion_id);

        $libretas = $this->obtenerNotasDeLaLibreta($asignatura_id, $ciclo_lectivo_id);
        $arrayTemporal = $this->recorrerLibreta($libretas, $totalPeriodo, $cantidadPeriodo, $calificacionAlumno, $calificacionesAlumnos, $formaEvaluacion);
        $promedios = $this->obtenerPromedios($arrayTemporal[0], $arrayTemporal[1], $promedios);

        return [$promedios, $periodos, $arrayTemporal[2]];
    }

    public function obtenerNotasDeLaLibreta($asignatura_id, $ciclo_lectivo_id)
    {
        return Libreta::where('asignatura_id', $asignatura_id)
            ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with('calificaciones')
            ->get();
    }

    public function recorrerLibreta($libretas, $totalPeriodo, $cantidadPeriodo, $calificacionAlumno, $calificacionesAlumnos, $formaEvaluacion) {
        
        $i = 0;
        $a = 0;

        foreach ($libretas as $libreta) {

            foreach ($libreta->calificaciones as $libreCali) {

                if (!($libreCali->calificacion === null)) {
                    if (!($formaEvaluacion->tipo == 'Escrita')) {
                        $totalPeriodo[$i] = $totalPeriodo[$i] + $libreCali->calificacion;
                        $cantidadPeriodo[$i]++;
                    }

                    $calificacionAlumno[$i] = $libreCali->calificacion;
                }
                $i++;
            }
            $i = 0;

            $calificacionesAlumnos[$a] = [
                'nombre' => $libreta->alumno->user->name,
                'calificaciones' => $calificacionAlumno,
            ];

            for ($i=0; $i < count($calificacionAlumno); $i++) { 
                $calificacionAlumno[$i] = 0;
            }
            $i = 0;

            $a++;
        }

        return [$totalPeriodo, $cantidadPeriodo, $calificacionesAlumnos];
    }

    public function obtenerPromedios($totalPeriodo, $cantidadPeriodo, $promedios)
    {
        for ($i=0; $i < count($cantidadPeriodo); $i++) { 
            if ($cantidadPeriodo[$i] == 0) {
                $cantidadPeriodo[$i] = 1;
            }
            $promedios[$i] = \round($totalPeriodo[$i] / $cantidadPeriodo[$i], 2, PHP_ROUND_HALF_UP);
        }
        return $promedios;
    }
}
