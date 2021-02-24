<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Models\Deudores\AlumnoDeudor;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\CiclosLectivos\CicloLectivoService;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AsignaturaDeudorController extends Controller
{
    protected $formatoFechaService;
    protected $divisionService;
    protected $asignaturaService;
    protected $cicloLectivoService;

    public function __construct(
        CambiarFormatoFecha $formatoFechaService,
        DivisionService $divisionService,
        AsignaturaService $asignaturaService,
        CicloLectivoService $cicloLectivoService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('asignaturaCorrespondiente');

        $this->formatoFechaService = $formatoFechaService;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
        $this->cicloLectivoService = $cicloLectivoService;
    }

    public function mostrarDeudores($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Asignaturas/Deudores', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignatura'  => $this->asignaturaService->find($asignatura_id),
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function filtrarDeudores($institucion_id, $division_id, $asignatura_id, Request $filtros)
    {
        return AlumnoDeudor::where('asignatura_id', $asignatura_id)
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
            ->paginate(20)
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
    }
}
