<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Models\Deudores\AlumnoDeudor;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\CiclosLectivos\CicloLectivoRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AsignaturaDeudorController extends Controller
{
    protected $formatoFechaService;
    protected $divisionRepository;
    protected $asignaturaRepository;
    protected $cicloLectivoRepository;

    public function __construct(
        CambiarFormatoFecha $formatoFechaService,
        DivisionRepository $divisionRepository,
        AsignaturaRepository $asignaturaRepository,
        CicloLectivoRepository $cicloLectivoRepository
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('asignaturaCorrespondiente');

        $this->formatoFechaService = $formatoFechaService;
        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
        $this->cicloLectivoRepository = $cicloLectivoRepository;
    }

    public function mostrarDeudores($institucion_id, $division_id, $asignatura_id, Request $filtros)
    {
        $deudores = AlumnoDeudor::where('asignatura_id', $asignatura_id)
            ->when($filtros->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
                return $query->where('ciclo_lectivo_id', $ciclo_lectivo_id);
            })
            ->when($filtros->aprobado, function ($query, $aprobado) {
                return $query->where('aprobado', $aprobado);
            })
            ->when($filtros->aprobado == '0', function ($query, $aprobado) {
                return $query->where('aprobado', '0');
            })
            ->with('alumno', 'alumno.user')
            ->orderBy('ciclo_lectivo_id')
            ->paginate(10)
            ->transform(function ($deuda) {
                return [
                    'id' => $deuda->id,
                    'alumno_id' => $deuda->alumno_id,
                    'alumno' => $deuda->alumno,
                    'comienzo' => $this->formatoFechaService->cambiarFormatoParaMostrar($deuda->ciclo_lectivo->comienzo),
                    'final' => $this->formatoFechaService->cambiarFormatoParaMostrar($deuda->ciclo_lectivo->final),
                    'aprobado' => $deuda->aprobado,
                ];
            });

        return Inertia::render('Asignaturas/Deudores', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'asignatura'  => $this->asignaturaRepository->find($asignatura_id),
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
            'deudores' => $deudores,
            'ciclo_lectivo_id_index' => $filtros->ciclo_lectivo_id,
            'aprobado_index' => $filtros->aprobado,
        ]);
    }
}
