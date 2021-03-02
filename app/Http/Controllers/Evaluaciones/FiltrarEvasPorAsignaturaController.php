<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Archivos\EliminarEntregasCorrecciones;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class FiltrarEvasPorAsignaturaController extends Controller
{
    protected $formatoService;
    protected $archivosServices;
    protected $divisionService;
    protected $asignaturaService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        EliminarEntregasCorrecciones $archivosServices,
        DivisionService $divisionService,
        AsignaturaService $asignaturaService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');

        $this->formatoService = $formatoService;
        $this->archivosServices = $archivosServices;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
    }

    public function filtrarPorAsignaturas($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Evaluaciones/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignatura_id_seleccionada' => $asignatura_id,
            'asignaturas' => $this->asignaturaService->get($division_id),
            /* 'asignatura' => $this->asignaturaService->find($asignatura_id), */
            'evaluaciones' => Evaluacion::where('division_id', $division_id)
                ->where('asignatura_id', $asignatura_id)
                ->with('asignatura')
                ->orderBy('fechaHoraRealizacion')
                ->paginate(1)
                ->transform(function ($evaluacion) {
                    return [
                        'id' => $evaluacion->id,
                        'titulo' => $evaluacion->titulo,
                        'tipo' => $evaluacion->tipo,
                        'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraRealizacion),
                        'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraFinalizacion),
                        'asignatura'  => $evaluacion->asignatura->only('nombre'),
                    ];
                }),
        ]);
    }
}
