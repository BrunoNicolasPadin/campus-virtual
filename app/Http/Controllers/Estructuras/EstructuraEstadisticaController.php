<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Libretas\Libreta;
use App\Services\Division\ObtenerPeriodosEvaluacion;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class EstructuraEstadisticaController extends Controller
{
    protected $formatoService;
    protected $divisionService;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        ObtenerPeriodosEvaluacion $divisionService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('divisionCorrespondiente');

        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
    }

    public function mostrarCiclosLectivos($institucion_id, $division_id)
    {
        return Inertia::render('Estructuras/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
            ->orderBy('comienzo')
            ->get()
            ->map(function ($ciclo) {
                return [
                    'id' => $ciclo->id,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                ];
            }),
        ]);
    }

    public function mostrarEstadisticas($institucion_id, $division_id, $ciclo_lectivo_id)
    {
        $division = Division::with('formaEvaluacion')->findOrFail($division_id);

        if ($division->formaEvaluacion->tipo == 'Escrita') {
            return [null, null, null];
        }

        $libreta = Libreta::where('division_id', $division_id)->where('ciclo_lectivo_id', $ciclo_lectivo_id)->first();
        $cantidadAsignaturas = Asignatura::where('division_id', $division_id)->count();

        if ($cantidadAsignaturas == 0) {
            return [null, null, null];
        }

        $periodos = $this->divisionService->obtenerPeriodos($libreta);

        $totalRecorrido = $cantidadAsignaturas * count($periodos);
        $recorrido = 0;
        $a = 0;

        $totalPeriodo = [];
        $cantidadPeriodo = [];
        $promedios = [];

        $totalPeriodoAlumno = [];
        $cantidadPeriodoAlumno = [];
        $promediosAlumnos = [];
        $promediosMomentaneos = [];

        for ($i=0; $i < count($periodos); $i++) { 
            $totalPeriodo[$i] = 0;
            $cantidadPeriodo[$i] = 0;
            $promedios[$i] = 0;

            $totalPeriodoAlumno[$i] = 0;
            $cantidadPeriodoAlumno[$i] = 0;
            $promediosMomentaneos[$i] = 0;
        }
        $i = 0;

        $libretas = $this->obtenerNotasDeLaLibreta($division_id, $ciclo_lectivo_id);
        
        foreach ($libretas as $libreta) {

            foreach ($libreta->calificaciones as $libreCali) {

                if (!($libreCali->calificacion === null)) {
                    $totalPeriodo[$i] = $totalPeriodo[$i] + $libreCali->calificacion;
                    $cantidadPeriodo[$i]++;

                    $totalPeriodoAlumno[$i] = $totalPeriodoAlumno[$i] + $libreCali->calificacion;
                    $cantidadPeriodoAlumno[$i]++;
                }
                $i++;
                $recorrido++;
            }

            $i = 0;

            if ($recorrido == $totalRecorrido) {

                $promediosAlumnos[$a] = $this->obtenerPromediosPorAlumno($promediosMomentaneos, $cantidadPeriodoAlumno, $totalPeriodoAlumno, $libreta);
                $a++;
                $recorrido = 0;
            }
        }

        $promedios = $this->obtenerPromedios($cantidadPeriodo, $totalPeriodo, $promedios);

        return [$promedios, $periodos, $promediosAlumnos];
    }

    public function obtenerNotasDeLaLibreta($division_id, $ciclo_lectivo_id)
    {
        return Libreta::where('division_id', $division_id)
        ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
        ->with('calificaciones', 'alumno', 'alumno.user')
        ->get();
    }

    public function obtenerPromediosPorAlumno($promediosMomentaneos, $cantidadPeriodoAlumno, $totalPeriodoAlumno, $libreta)
    {
        for ($i=0; $i < count($cantidadPeriodoAlumno); $i++) { 
            if ($cantidadPeriodoAlumno[$i] == 0) {
                $cantidadPeriodoAlumno[$i] = 1;
            }
            $promediosMomentaneos[$i] = \round($totalPeriodoAlumno[$i] / $cantidadPeriodoAlumno[$i], 2, PHP_ROUND_HALF_UP);
            
            $totalPeriodoAlumno[$i] = 0;
            $cantidadPeriodoAlumno[$i] = 0;
        }

        return [
            'nombre' => $libreta->alumno->user->name,
            'promedios' => $promediosMomentaneos,
        ];

    }

    public function obtenerPromedios($cantidadPeriodo, $totalPeriodo, $promedios)
    {
        for ($i=0; $i < count($cantidadPeriodo); $i++) { 
            if ($cantidadPeriodo[$i] == 0) {
                $cantidadPeriodo[$i] = 1;
            }
            $promedios[$i] = $totalPeriodo[$i] / $cantidadPeriodo[$i];
            $promedios[$i] = \round($promedios[$i], 2, PHP_ROUND_HALF_UP);
        }
        return $promedios;
    }
}
