<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\FormaEvaluacion;
use App\Models\Libretas\Libreta;
use App\Services\Alumnos\AlumnoService;
use App\Services\CiclosLectivos\CicloLectivoService;
use App\Services\Division\ObtenerPeriodosEvaluacion;
use Inertia\Inertia;

class AlumnoEstadisticaController extends Controller
{
    protected $alumnoService;
    protected $divisionService;
    protected $cicloLectivoService;

    public function __construct(
        ObtenerPeriodosEvaluacion $divisionService,
        CicloLectivoService $cicloLectivoService,
        AlumnoService $alumnoService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('alumnoCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosAlumnos');

        $this->alumnoService = $alumnoService;
        $this->divisionService = $divisionService;
        $this->cicloLectivoService = $cicloLectivoService;
    }

    public function mostrarCiclosLectivos($institucion_id, $alumno_id)
    {
        return Inertia::render('Alumnos/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoService->find($alumno_id),
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function mostrarEstadisticas($institucion_id, $alumno_id, $ciclo_lectivo_id)
    {
        $libreta = Libreta::select('libretas.periodo_id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
            'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre', 'formas_evaluacion.tipo', 'formas_evaluacion.id')
            ->where('libretas.alumno_id', $alumno_id)
            ->where('libretas.ciclo_lectivo_id', $ciclo_lectivo_id)
            ->join('divisiones', 'libretas.division_id', 'divisiones.id')
            ->join('niveles', 'niveles.id', 'divisiones.nivel_id')
            ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
            ->join('cursos', 'cursos.id', 'divisiones.curso_id')
            ->join('formas_evaluacion', 'formas_evaluacion.id', 'divisiones.forma_evaluacion_id')
            ->first();


        $division = $this->obtenerDivision($libreta);
        $periodos = $this->divisionService->obtenerPeriodos($libreta);

        $totalPeriodo = [];
        $cantidadPeriodo = [];
        $promedios = [];

        for ($i=0; $i < count($periodos); $i++) { 
            $totalPeriodo[$i] = 0;
            $cantidadPeriodo[$i] = 0;
            $promedios[$i] = 0;
        }
        $i = 0;

        $libretas = $this->obtenerNotasDeLaLibreta($alumno_id, $ciclo_lectivo_id);

        if ($libreta->tipo == 'Escrita') {
            $formaEvaluacion = FormaEvaluacion::findOrFail($libreta->id);
            $arrayTemporal = $this->obtenerCantidadDeVecesPorCalificacion($libretas, $formaEvaluacion, $periodos);
            return ['Escrita', $periodos, $arrayTemporal[0], $arrayTemporal[1]];
        }

        $arrayTemporal = $this->recorrerLasNotas($libretas, $totalPeriodo, $cantidadPeriodo);

        $promedios = $this->obtenerPromedio($promedios, $arrayTemporal[1], $arrayTemporal[0]);

        return ['No escrita', $promedios, $periodos, $division];
    }

    public function obtenerDivision($libreta)
    {
        if ($libreta->orientacion_nombre) {
            
            return $libreta->nivel_nombre . ' - ' . 
                $libreta->orientacion_nombre . ' - ' . 
                $libreta->curso_nombre . ' - ' . 
                $libreta->division;
        }
        else {
            return $libreta->nivel_nombre . ' - ' . 
                $libreta->curso_nombre . ' - ' . 
                $libreta->division;
        }
    }

    public function obtenerNotasDeLaLibreta($alumno_id, $ciclo_lectivo_id)
    {
        return Libreta::where('alumno_id', $alumno_id)
            ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with('calificaciones')
            ->get();
    }

    public function recorrerLasNotas($libretas, $totalPeriodo, $cantidadPeriodo)
    {
        $i = 0;
        foreach ($libretas as $libreta) {

            foreach ($libreta->calificaciones as $libreCali) {

                if (!($libreCali->calificacion === null)) {
                    $totalPeriodo[$i] = $totalPeriodo[$i] + $libreCali->calificacion;
                    $cantidadPeriodo[$i]++;
                }
                $i++;
            }
            $i = 0;
        }

        return [$totalPeriodo, $cantidadPeriodo];
    }

    public function obtenerPromedio($promedios, $cantidadPeriodo, $totalPeriodo)
    {
        for ($i=0; $i < count($cantidadPeriodo); $i++) { 
            if ($cantidadPeriodo[$i] == 0) {
                $cantidadPeriodo[$i] = 1;
            }
            $promedios[$i] = \round($totalPeriodo[$i] / $cantidadPeriodo[$i], 2, PHP_ROUND_HALF_UP);
        }
        return $promedios;
    }

    public function obtenerCantidadDeVecesPorCalificacion($libretas, $formaEvaluacion, $periodos)
    {
        $periodosArray = [];
        $opciones = [];
        $a = 0;

        foreach ($formaEvaluacion->formaDescripcion as $descripcion) {
            array_push($opciones, $descripcion->opcion);
        }

        for ($i=0; $i < count($periodos); $i++) { 
            $periodosArray[$periodos[$i]] = array();
            foreach ($formaEvaluacion->formaDescripcion as $descripcion) {
                $periodosArray[$periodos[$i]][$descripcion->opcion] = 0;
            }
        }
        
        foreach ($libretas as $libreta) {

            foreach ($libreta->calificaciones as $libreCali) {

                if (!($libreCali->calificacion === null)) {
                    $periodosArray[$libreCali->periodo][$libreCali->calificacion]++;
                }
            }
        }
        return [$opciones, $periodosArray];
    }
}
