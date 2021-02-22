<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaEvaluacion;
use App\Models\Libretas\Libreta;
use App\Services\Division\ObtenerPeriodosEvaluacion;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class AsignaturaEstadisticaController extends Controller
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
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('asignaturaCorrespondiente');

        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
    }

    public function mostrarEstadisticas($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Asignaturas/Estadisticas/Mostrar', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->orderBy('comienzo')->get()
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
        $division = Division::with('formaEvaluacion')->findOrFail($division_id);

        $periodos = $this->divisionService->obtenerPeriodos($division);

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

        $formaEvaluacion = FormaEvaluacion::findOrFail($division->forma_evaluacion_id);

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
