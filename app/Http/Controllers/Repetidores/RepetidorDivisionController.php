<?php

namespace App\Http\Controllers\Repetidores;

use App\Http\Controllers\Controller;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Repetidores\Repetidor;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RepetidorDivisionController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');

        $this->formatoService = $formatoService;
    }

    public function mostrar($institucion_id, $division_id)
    {
        return Inertia::render('Repetidores/Division', [
            'institucion_id' => $institucion_id,
            'division' => Division::where('institucion_id', $institucion_id)
                ->with('nivel', 'curso', 'orientacion')
                ->find($division_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                    ];
                }),
            'repetidores' => Repetidor::where('institucion_id', $institucion_id)
                ->with('alumno', 'alumno.user', 'ciclo_lectivo', 'division', 'division.nivel', 'division.curso', 'division.orientacion')
                ->paginate(20)
                ->transform(function ($repetidor) {
                    return [
                        'id' => $repetidor->id,
                        'alumno_id' => $repetidor->alumno_id,
                        'division_id' => $repetidor->division_id,
                        'division' => $repetidor->division,
                        'alumno' => $repetidor->alumno,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($repetidor->ciclo_lectivo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($repetidor->ciclo_lectivo->final),
                        'comentario'  => $repetidor->comentario,
                    ];
                }),
        ]);
    }

    public function filtrarRepetidores($institucion_id, $division_id, Request $filtro)
    {
        return Inertia::render('Repetidores/Division', [
            'institucion_id' => $institucion_id,
            'division' => Division::where('institucion_id', $institucion_id)
                ->with('nivel', 'curso', 'orientacion')
                ->find($division_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                    ];
                }),
            'repetidores' => Repetidor::where('institucion_id', $institucion_id)
                ->when($filtro->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
                    return $query->where('ciclo_lectivo_id', $ciclo_lectivo_id);
                })
                ->with('alumno', 'alumno.user', 'ciclo_lectivo', 'division', 'division.nivel', 'division.curso', 'division.orientacion')
                ->paginate(20)
                ->transform(function ($repetidor) {
                    return [
                        'id' => $repetidor->id,
                        'alumno_id' => $repetidor->alumno_id,
                        'division_id' => $repetidor->division_id,
                        'division' => $repetidor->division,
                        'alumno' => $repetidor->alumno,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($repetidor->ciclo_lectivo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($repetidor->ciclo_lectivo->final),
                        'comentario'  => $repetidor->comentario,
                    ];
                }),
        ]);
    }
}
