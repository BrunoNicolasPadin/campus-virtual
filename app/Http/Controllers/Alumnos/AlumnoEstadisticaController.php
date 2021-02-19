<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Libretas\Libreta;
use App\Models\Roles\Alumno;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class AlumnoEstadisticaController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('alumnoCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosAlumnos');

        $this->formatoService = $formatoService;
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
            ->with(['division', 'division.nivel', 'division.orientacion', 'division.curso'])
            ->first();

        if ($libreta->division->orientacion) {
            $division = $libreta->division->nivel->nombre . ' - ' . $libreta->division->orientacion->nombre . ' - ' . $libreta->division->curso->nombre
             . ' - ' . $libreta->division->division;
        }
        else {
            $division = $libreta->division->nivel->nombre . ' - ' . $libreta->division->curso->nombre . ' - ' . $libreta->division->division;
        }

        

        if ($libreta['periodo_id'] == 1) {
            $periodos = ['1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }
        elseif ($libreta['periodo_id'] == 2) {
            $periodos = ['1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }
        elseif ($libreta['periodo_id'] == 3) {
            $periodos = ['1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }

        $totalPeriodo = [];
        $cantidadPeriodo = [];
        $promedios = [];

        for ($i=0; $i < count($periodos); $i++) { 
            $totalPeriodo[$i] = 0;
            $cantidadPeriodo[$i] = 0;
            $promedios[$i] = 0;
        }
        $i = 0;

        $libretas = Libreta::where('alumno_id', $alumno_id)
            ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with('calificaciones')
            ->get();

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

        for ($i=0; $i < count($cantidadPeriodo); $i++) { 
            if ($cantidadPeriodo[$i] == 0) {
                $cantidadPeriodo[$i] = 1;
            }
            $promedios[$i] = $totalPeriodo[$i] / $cantidadPeriodo[$i];
        }

        return [$promedios, $periodos, $division];
    }
}
