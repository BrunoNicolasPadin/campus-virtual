<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Libretas\Libreta;
use App\Models\Roles\Alumno;
use App\Services\Division\ObtenerPeriodosEvaluacion;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class AlumnoEstadisticaController extends Controller
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
        $this->middleware('alumnoCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosAlumnos');

        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
    }

    public function mostrarCiclosLectivos($institucion_id, $alumno_id)
    {
        return Inertia::render('Alumnos/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->findOrFail($alumno_id),
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
