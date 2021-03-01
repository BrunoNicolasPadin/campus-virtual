<?php

namespace App\Http\Controllers\Calendario;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\Mesa;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Calendario\CalendarioService;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class CalendarioDocenteController extends Controller
{   //276
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
        $this->middleware('soloDocentes');

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
        $asignaturasDocentes = AsignaturaDocente::where('docente_id', session('tipo_id'))->get();
        $evas = collect();
        $mesas = collect();

        foreach ($asignaturasDocentes as $asignaturaDocente) {

            $evas = $evas->push($this->obtenerEvasEloquent($asignaturaDocente->asignatura_id, $year, $mes));
            $mesas = $mesas->push($this->obtenerMesasEloquent($asignaturaDocente->asignatura_id, $year, $mes));
        }

        $evasMesas = [];

        foreach ($evas as $eva) {
            foreach ($eva as $e) {
                $fecha = explode("/", $e['fechaHoraRealizacion']);
                $evasMesas[$fecha[1] - 1][] = $this->calendarioService->obtenerEvaluaciones($e);
            }
        }

        foreach ($mesas as $mesa) {
            foreach ($mesa as $m) {
                $fecha = explode("/", $m['fechaHora']);
                $evasMesas[$fecha[1] - 1][] = $this->calendarioService->obtenerMesas($m);
            }
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

    public function obtenerEvasEloquent($asignatura_id, $year, $mes)
    {
        return Evaluacion::where('asignatura_id', $asignatura_id)
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
                    'asignatura' => $evaluacion->asignatura,
                    'division' => $evaluacion->division,
                ];
            });
    }

    public function obtenerMesasEloquent($asignatura_id, $year, $mes)
    {
        return Mesa::where('asignatura_id', $asignatura_id)
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
