<?php

namespace App\Http\Controllers\Calendario;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\Anotado;
use App\Models\Deudores\Mesa;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use DateTime;
use Inertia\Inertia;

class CalendarioController extends Controller
{
    protected $formatoService;
    protected $formatoFechaService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        CambiarFormatoFecha $formatoFechaService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');

        $this->formatoService = $formatoService;
        $this->formatoFechaService = $formatoFechaService;
    }
    public function mostrarCalendario($institucion_id, $year)
    {
        $anios = ['2021', '2022', '2023', '2024', '2025', '2026', '2027', '2028', '2029', '2030'];
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            return $this->mostrarParaInstitucionesDirectivos($institucion_id, $year, $anios);
        }
        if (session('tipo') == 'Docente') {
            return $this->mostrarParaDocentes($institucion_id, $year, $anios);
        }
        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            return $this->mostrarParaAlumnosPadres($institucion_id, $year, $anios);
        }
    }

    public function obtenerMeses()
    {
        return ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    }

    public function obtenerEvaluaciones($evaluacion)
    {
        return [
            'id' => $evaluacion['id'],
            'institucion_id' => $evaluacion['institucion_id'],
            'division_id' => $evaluacion['division_id'],
            'titulo' => $evaluacion['titulo'],
            'tipo' => $evaluacion['tipo'],
            'fechaHora' => $evaluacion['fechaHoraRealizacion'],
            'fechaHoraFinalizacion' => $evaluacion['fechaHoraFinalizacion'],
            'asignatura' => $evaluacion['asignatura'],
            'division' => $evaluacion['division'],
        ];
    }

    public function obtenerMesas($mesa)
    {
        return [
            'id' => $mesa['id'],
            'institucion_id' => $mesa['institucion_id'],
            'division_id' => $mesa['asignatura']['division_id'],
            'titulo' => '-',
            'tipo' => 'Mesa de examen',
            'fechaHora' => $mesa['fechaHora'],
            'fechaHoraFinalizacion' => '',
            'asignatura' => $mesa['asignatura'],
            'division' => $mesa['division'],
        ];
    }

    public function ordenarEvasMesas($evasMesas)
    {
        $keys = array_keys($evasMesas);
        
        for ($i=0; $i < count($keys); $i++) { 
            usort($evasMesas[$keys[$i]], function($a, $b) {
                return $a['fechaHora'] <=> $b['fechaHora'];
            });
        }
        return $evasMesas;
    }

    public function mostrarParaInstitucionesDirectivos($institucion_id, $year, $anios)
    {
        $evaluaciones = Evaluacion::where('institucion_id', $institucion_id)
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
        
        $mesas = Mesa::where('institucion_id', $institucion_id)
            ->whereYear('fechaHora', $year)
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

        $evasMesas = [];

        foreach ($evaluaciones as $evaluacion) {
            $fecha = explode("/", $evaluacion['fechaHoraRealizacion']);
            $evasMesas[$fecha[1] - 1][] = $this->obtenerEvaluaciones($evaluacion);
        }

        foreach ($mesas as $mesa) {
            $fecha = explode("/", $mesa['fechaHora']);
            $evasMesas[$fecha[1] - 1][] = $this->obtenerMesas($mesa);
        }

        $evasMesas = $this->ordenarEvasMesas($evasMesas);

        return Inertia::render('Calendario/Mostrar', [
            'institucion_id' => $institucion_id,
            'meses' => $this->obtenerMeses(),
            'evasMesas' => $evasMesas,
            'anios' => $anios,
        ]);
    }

    public function mostrarParaDocentes($institucion_id, $year, $anios)
    {
        $asignaturasDocentes = AsignaturaDocente::where('docente_id', session('tipo_id'))->get();
        $evas = collect();
        $mesas = collect();

        foreach ($asignaturasDocentes as $asignaturaDocente) {

            $evas = $evas->push(
                Evaluacion::where('asignatura_id', $asignaturaDocente->asignatura_id)
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
                            'asignatura' => $evaluacion->asignatura,
                            'division' => $evaluacion->division,
                        ];
                    })
                );
            $mesas = $mesas->push(
                Mesa::where('asignatura_id', $asignaturaDocente->asignatura_id)
                    ->whereYear('fechaHora', $year)
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
                    })
                );
        }

        $evasMesas = [];

        foreach ($evas as $eva) {
            foreach ($eva as $e) {
                $fecha = explode("/", $e['fechaHoraRealizacion']);
                $evasMesas[$fecha[1] - 1][] = $this->obtenerEvaluaciones($e);
            }
        }

        foreach ($mesas as $mesa) {
            foreach ($mesa as $m) {
                $fecha = explode("/", $m['fechaHora']);
                $evasMesas[$fecha[1] - 1][] = $this->obtenerMesas($m);
            }
        }

        $evasMesas = $this->ordenarEvasMesas($evasMesas);

        return Inertia::render('Calendario/Mostrar', [
            'institucion_id' => $institucion_id,
            'meses' => $this->obtenerMeses(),
            'evasMesas' => $evasMesas,
            'anios' => $anios,
        ]);
    }

    public function mostrarParaAlumnosPadres($institucion_id, $year, $anios)
    {
        $evaluaciones = Evaluacion::where('division_id', session('division_id'))
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
        
        $mesas = Anotado::where('alumno_id', session('tipo_id'))
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

        $evasMesas = [];

        foreach ($evaluaciones as $evaluacion) {
            $fecha = explode("/", $evaluacion['fechaHoraRealizacion']);
            $evasMesas[$fecha[1] - 1][] = $this->obtenerEvaluaciones($evaluacion);
        }

        foreach ($mesas as $mesa) {
            $fecha = explode("/", $mesa['fechaHora']);
            $evasMesas[$fecha[1] - 1][] = $this->obtenerMesas($mesa);
        }

        $evasMesas = $this->ordenarEvasMesas($evasMesas);

        return Inertia::render('Calendario/Mostrar', [
            'institucion_id' => $institucion_id,
            'meses' => $this->obtenerMeses(),
            'evasMesas' => $evasMesas,
            'anios' => $anios,
        ]);
    }
}
