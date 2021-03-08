<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaEvaluacion;
use App\Models\Libretas\Libreta;
use App\Repositories\Estructuras\DivisionRepository;
use App\Repositories\Libretas\LibretaRepository;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EstructuraEstadisticaController extends Controller
{
    protected $formatoService;
    protected $libretaRepository;
    protected $divisionRepository;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        LibretaRepository $libretaRepository,
        DivisionRepository $divisionRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('divisionCorrespondiente');

        $this->formatoService = $formatoService;
        $this->libretaRepository = $libretaRepository;
        $this->divisionRepository = $divisionRepository;
    }

    public function mostrarCiclosLectivos($institucion_id, $division_id)
    {
        return Inertia::render('Estructuras/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'ciclosLectivos' => CicloLectivo::select('id', 'comienzo', 'final')->where('institucion_id', $institucion_id)
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
        $libreta = Libreta::where('division_id', $division_id)->where('ciclo_lectivo_id', $ciclo_lectivo_id)->first();
        $cantidadAsignaturas = Asignatura::where('division_id', $division_id)->count();

        if ($cantidadAsignaturas == 0) {
            return ['No escrita', null, null, null];
        }

        $periodos = $this->libretaRepository->obtenerPeriodos($libreta);

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

        if ($division->formaEvaluacion->tipo == 'Escrita') {
            $formaEvaluacion = FormaEvaluacion::with('formaDescripcion')->findOrFail($division->forma_evaluacion_id);
            $arrayTemporal = $this->obtenerCantidadDeVecesPorCalificacion($libretas, $formaEvaluacion, $periodos);
            return ['Escrita', $periodos, $arrayTemporal[0], $arrayTemporal[1]];
        }
        
        foreach ($libretas as $libreta) {

            if (!($libreta->calificacion === null)) {
                $totalPeriodo[$i] = $totalPeriodo[$i] + $libreta->calificacion;
                $cantidadPeriodo[$i]++;

                $totalPeriodoAlumno[$i] = $totalPeriodoAlumno[$i] + $libreta->calificacion;
                $cantidadPeriodoAlumno[$i]++;
            }

            $i++;
            $recorrido++;

            if ($i == count($periodos)) {
                $i = 0;
            }

            if ($recorrido == $totalRecorrido) {

                $promediosAlumnos[$a] = $this->obtenerPromediosPorAlumno($promediosMomentaneos, $cantidadPeriodoAlumno, $totalPeriodoAlumno, $libreta);
                $a++;
                $recorrido = 0;
                
                for ($i=0; $i < count($periodos); $i++) { 
        
                    $totalPeriodoAlumno[$i] = 0;
                    $cantidadPeriodoAlumno[$i] = 0;
                }
                $i = 0;
            }
        }

        $promedios = $this->obtenerPromedios($cantidadPeriodo, $totalPeriodo, $promedios);

        return ['No escrita', $promedios, $periodos, $promediosAlumnos];
    }

    public function obtenerNotasDeLaLibreta($division_id, $ciclo_lectivo_id)
    {
        return DB::table('libretas')
        ->select('calificaciones.calificacion', 'calificaciones.periodo', 'users.name')
        ->where('libretas.division_id', $division_id)
        ->where('libretas.ciclo_lectivo_id', $ciclo_lectivo_id)
        ->join('calificaciones', 'calificaciones.libreta_id', 'libretas.id')
        ->join('alumnos', 'alumnos.id', 'libretas.alumno_id')
        ->join('users', 'users.id', 'alumnos.user_id')
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
            'nombre' => $libreta->name,
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

    public function obtenerCantidadDeVecesPorCalificacion($libretas, $formaEvaluacion, $periodos)
    {
        $periodosArray = [];
        $opciones = [];

        foreach ($formaEvaluacion->formaDescripcion as $descripcion) {
            array_push($opciones, $descripcion->opcion);
        }

        for ($i=0; $i < count($periodos); $i++) { 
            $periodosArray[$periodos[$i]] = array();
            foreach ($formaEvaluacion->formaDescripcion as $descripcion) {
                $periodosArray[$periodos[$i]][$descripcion->opcion] = 0;
            }
        }
        $i = 0;
        
        foreach ($libretas as $libreta) {

            if (!($libreta->calificacion === null)) {

                $periodosArray[$libreta->periodo][$libreta->calificacion]++;
                $calificacionAlumno[$i] = $libreta->calificacion;
            }
            $i++;

            if ($i == count($periodos)) {
                $i = 0;
            }
        }
        return [$opciones, $periodosArray];
    }
}
