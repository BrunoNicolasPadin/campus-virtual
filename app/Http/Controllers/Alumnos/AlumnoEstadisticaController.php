<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
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
        $libreta = Libreta::where('alumno_id', $alumno_id)->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with(['division', 'division.nivel', 'division.orientacion', 'division.curso', 'division.formaEvaluacion'])
            ->first();


        $division = $this->obtenerDivision($libreta);

        if ($libreta->division->formaEvaluacion->tipo == 'Escrita') {
            return [null, null, $division];
        }

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

        $arrayTemporal = $this->recorrerLasNotas($libretas, $totalPeriodo, $cantidadPeriodo);

        $promedios = $this->obtenerPromedio($promedios, $arrayTemporal[1], $arrayTemporal[0]);

        return [$promedios, $periodos, $division];
    }

    public function obtenerDivision($libreta)
    {
        if ($libreta->division->orientacion) {
            
            return $libreta->division->nivel->nombre . ' - ' . 
                $libreta->division->orientacion->nombre . ' - ' . 
                $libreta->division->curso->nombre . ' - ' . 
                $libreta->division->division;
        }
        else {
            return $libreta->division->nivel->nombre . ' - ' . 
                $libreta->division->curso->nombre . ' - ' . 
                $libreta->division->division;
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
}
