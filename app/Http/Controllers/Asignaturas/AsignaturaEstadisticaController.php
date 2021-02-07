<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Libretas\Libreta;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class AsignaturaEstadisticaController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->formatoService = $formatoService;
    }

    public function mostrarEstadisticas($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Asignaturas/Estadisticas/SeleccionarCiclo', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->get()
            ->map(function ($ciclo) {
                return [
                    'id' => $ciclo->id,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                ];
            }),
        ]);
    }

    public function mostrarPromedios($institucion_id, $division_id, $asignatura_id, $ciclo_lectivo_id)
    {
        $division = Division::findOrFail($division_id);

        if ($division->periodo_id == 1) {
            $periodos = ['1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }
        elseif ($division->periodo_id == 2) {
            $periodos = ['1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }
        elseif ($division->periodo_id == 3) {
            $periodos = ['1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }

        $totalPeriodo = [];
        $cantidadPeriodo = [];
        $promedio = [];
        $a = 0;

        $calificacionAlumno = [];
        $calificacionesAlumnos = [];

        for ($i=0; $i < count($periodos); $i++) { 
            $totalPeriodo[$i] = 0;
            $cantidadPeriodo[$i] = 0;
            $promedio[$i] = 0;

            $calificacionAlumno[$i] = 0;
        }
        $i = 0;

        $libretas = Libreta::where('asignatura_id', $asignatura_id)
            ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with('calificaciones')
            ->get();

        foreach ($libretas as $libreta) {

            foreach ($libreta->calificaciones as $libreCali) {

                if (!($libreCali->calificacion === null)) {
                    $totalPeriodo[$i] = $totalPeriodo[$i] + $libreCali->calificacion;
                    $cantidadPeriodo[$i]++;

                    $calificacionAlumno[$i] = $libreCali->calificacion;
                }
                $i++;
            }
            $i = 0;

            $calificacionesAlumnos[$a] = [
                'nombre' => $libreta->alumno->user->name,
                'calificaciones' => $calificacionAlumno,
            ];

            $a++;
        }

        for ($i=0; $i < count($cantidadPeriodo); $i++) { 
            if ($cantidadPeriodo[$i] == 0) {
                $cantidadPeriodo[$i] = 1;
            }
            $promedio[$i] = $totalPeriodo[$i] / $cantidadPeriodo[$i];
        }

        return Inertia::render('Asignaturas/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->get()
            ->map(function ($ciclo) {
                return [
                    'id' => $ciclo->id,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                ];
            }),
            'ciclo_lectivo_id' => $ciclo_lectivo_id,
            'promedios' => $promedio,
            'periodos' => $periodos,
            'calificacionesAlumnos' => $calificacionesAlumnos,
        ]);
    }
}
