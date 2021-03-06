<?php

namespace App\Http\Controllers\Calendario;

use App\Http\Controllers\Controller;
use App\Models\Deudores\Inscripcion;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Calendario\CalendarioService;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class CalendarioAlumnoController extends Controller
{
    protected $formatoService;
    protected $formatoFechaService;
    protected $calendarioService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        CambiarFormatoFecha $formatoFechaService,
        CalendarioService $calendarioService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloAlumnos');

        $this->formatoService = $formatoService;
        $this->formatoFechaService = $formatoFechaService;
        $this->calendarioService = $calendarioService;
    }

    public function mostrarCalendario($institucion_id, $year, $mes)
    {
        $anios = ['2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030'];
        $meses = $this->calendarioService->obtenerMesesValidar();

        if (in_array($year, $anios) && in_array($mes, $meses)) {
            return $this->filtrarCalendario($institucion_id, $year, $mes);
        }
        return redirect(route('inicio'));
    }

    public function filtrarCalendario($institucion_id, $year, $mes)
    {
        $anios = ['2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030'];

        $evaluaciones = $this->obtenerEvaEloquent($year, $mes);
        
        $mesas = $this->obtenerMesasEloquent($year, $mes);

        $evasMesas = [];

        foreach ($evaluaciones as $evaluacion) {
            $fecha = explode("/", $evaluacion['fechaHoraRealizacion']);
            $evasMesas[$fecha[1] - 1][] = $this->calendarioService->obtenerEvaluaciones($evaluacion);
        }

        foreach ($mesas as $mesa) {
            $fecha = explode("/", $mesa['fechaHoraRealizacion']);
            $evasMesas[$fecha[1] - 1][] = $this->calendarioService->obtenerMesas($mesa);
        }

        $evasMesas = $this->calendarioService->ordenarEvasMesas($evasMesas);

        return Inertia::render('Calendario/Mostrar', [
            'institucion_id' => $institucion_id,
            'meses' => $this->calendarioService->obtenerMeses(),
            'evasMesas' => $evasMesas,
            'anios' => $anios,
            'mesesParaBuscar' => $this->calendarioService->obtenerMesesParaBuscar(),
            'tipo' => session('tipo'),
            'anioSeleccionado' => $year,
            'mesSeleccionado' => $this->calendarioService->obtenerMesSeleccionado($mes),
        ]);
    }

    public function obtenerEvaEloquent($year, $mes)
    {
        return Evaluacion::where('division_id', session('division_id'))
            ->whereYear('fechaHoraRealizacion', $year)
            ->whereMonth('fechaHoraRealizacion', $mes)
            ->with(['division', 'division.nivel', 'division.orientacion', 'division.curso', 'asignatura'])
            ->get()
            ->map(function ($evaluacion) {
                return [
                    'id' => $evaluacion->id,
                    'institucion_id' => $evaluacion->institucion_id,
                    'division_id' => $evaluacion->division_id,
                    'titulo' => $evaluacion->titulo,
                    'tipo' => $evaluacion->tipo,
                    'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraRealizacion),
                    'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraFinalizacion),
                    'asignatura' => $evaluacion->asignatura->only('id', 'nombre'),
                    'division' => $evaluacion->division,
                ];
            });
    }

    public function obtenerMesasEloquent($year, $mes)
    {
        return Inscripcion::where('alumno_id', session('tipo_id'))
            ->where('calificacion', null)
            ->with(['mesa', 'mesa.asignatura.division', 'mesa.asignatura.division.nivel', 
                'mesa.asignatura.division.orientacion', 'mesa.asignatura.division.curso', 'mesa.asignatura'])
            ->whereHas('mesa', function($q) use ($year, $mes)
            {
                $q->whereYear('fechaHora', $year);
                $q->whereMonth('fechaHora', $mes);

            })
            ->get()
            ->map(function ($inscripcion) {
                return [
                    'id' => $inscripcion->mesa->id,
                    'institucion_id' => $inscripcion->mesa->institucion_id,
                    'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($inscripcion->mesa->fechaHora),
                    'asignatura' => $inscripcion->mesa->asignatura->only('id', 'division_id', 'nombre'),
                    'division' => $inscripcion->mesa->asignatura->division,
                ];
            });
    }
}
