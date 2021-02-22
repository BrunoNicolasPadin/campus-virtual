<?php

namespace App\Http\Controllers\Calendario;

use App\Http\Controllers\Controller;
use App\Models\Deudores\Anotado;
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

    public function mostrarCalendario($institucion_id, $year)
    {
        $anios = ['2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030'];

        return $this->filtrarCalendario($institucion_id, $year, $anios);
    }

    public function filtrarCalendario($institucion_id, $year, $anios)
    {
        $evaluaciones = $this->obtenerEvaEloquent($year);
        
        $mesas = $this->obtenerMesasEloquent();

        $evasMesas = [];

        foreach ($evaluaciones as $evaluacion) {
            $fecha = explode("/", $evaluacion['fechaHoraRealizacion']);
            $evasMesas[$fecha[1] - 1][] = $this->calendarioService->obtenerEvaluaciones($evaluacion);
        }

        foreach ($mesas as $mesa) {
            $fecha = explode("/", $mesa['fechaHora']);
            $evasMesas[$fecha[1] - 1][] = $this->calendarioService->obtenerMesas($mesa);
        }

        $evasMesas = $this->calendarioService->ordenarEvasMesas($evasMesas);

        return Inertia::render('Calendario/Mostrar', [
            'institucion_id' => $institucion_id,
            'meses' => $this->calendarioService->obtenerMeses(),
            'evasMesas' => $evasMesas,
            'anios' => $anios,
        ]);
    }

    public function obtenerEvaEloquent($year)
    {
        return Evaluacion::where('division_id', session('division_id'))
            ->whereYear('fechaHoraRealizacion', $year)
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

    public function obtenerMesasEloquent()
    {
        return Anotado::where('alumno_id', session('tipo_id'))
            ->where('calificacion', null)
            ->with(['mesa', 'mesa.asignatura.division', 'mesa.asignatura.division.nivel', 
                'mesa.asignatura.division.orientacion', 'mesa.asignatura.division.curso', 'mesa.asignatura'])
            ->get()
            ->map(function ($anotado) {
                return [
                    'id' => $anotado->mesa->id,
                    'institucion_id' => $anotado->mesa->institucion_id,
                    'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($anotado->mesa->fechaHora),
                    'asignatura' => $anotado->mesa->asignatura->only('id', 'division_id', 'nombre'),
                    'division' => $anotado->mesa->asignatura->division,
                ];
            });
    }
}
