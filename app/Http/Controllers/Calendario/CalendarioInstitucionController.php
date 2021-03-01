<?php

namespace App\Http\Controllers\Calendario;

use App\Http\Controllers\Controller;
use App\Models\Deudores\Mesa;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Calendario\CalendarioService;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class CalendarioInstitucionController extends Controller
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
        $this->middleware('soloInstitucionesDirectivos');

        $this->formatoService = $formatoService;
        $this->formatoFechaService = $formatoFechaService;
        $this->calendarioService = $calendarioService;
    }

    public function mostrarCalendario($institucion_id, $year, $mes)
    {

        return $this->filtrarCalendario($institucion_id, $year, $mes);
    }

    public function filtrarCalendario($institucion_id, $year, $mes)
    {
        $anios = ['2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030'];
        $evaluaciones = $this->obtenerEvaEloquent($institucion_id, $year, $mes);
        
        $mesas = $this->obtenerMesasEloquent($institucion_id, $year, $mes);

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
            'mesesParaBuscar' => $this->calendarioService->obtenerMesesParaBuscar(),
            'tipo' => session('tipo'),
            'anioSeleccionado' => $year,
            'mesSeleccionado' => $this->calendarioService->obtenerMesSeleccionado($mes),
        ]);
    }

    public function obtenerEvaEloquent($institucion_id, $year, $mes)
    {
        return Evaluacion::where('institucion_id', $institucion_id)
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

    public function obtenerMesasEloquent($institucion_id, $year, $mes)
    {
        return Mesa::where('institucion_id', $institucion_id)
        ->whereYear('fechaHora', $year)
        ->whereMonth('fechaHora', $mes)
        ->with(['asignatura.division', 'asignatura.division.nivel', 'asignatura.division.orientacion', 'asignatura.division.curso', 'asignatura'])
        ->get()
        ->map(function ($mesa) {
            return [
                'id' => $mesa->id,
                'institucion_id' => $mesa->institucion_id,
                'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHora),
                'asignatura' => $mesa->asignatura->only('id', 'division_id', 'nombre'),
                'division' => $mesa->asignatura->division,
            ];
        });
    }
}
