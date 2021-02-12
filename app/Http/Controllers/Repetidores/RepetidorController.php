<?php

namespace App\Http\Controllers\Repetidores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repetidores\StoreRepetidor;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Repetidores\Repetidor;
use App\Models\Roles\Alumno;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RepetidorController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->except('show');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('show');
        $this->middleware('alumnoCorrespondiente')->only('createRepetidor');
        $this->middleware('repetidorCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Repetidores/Index', [
            'institucion_id' => $institucion_id,
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with('nivel', 'curso', 'orientacion')
                ->get(),
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

    public function filtrarRepetidores($institucion_id, Request $filtros)
    {
        return Inertia::render('Repetidores/Index', [
            'institucion_id' => $institucion_id,
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with('nivel', 'curso', 'orientacion')
                ->get(),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                    ];
                }),
            'repetidores' => Repetidor::where('institucion_id', $institucion_id)
                ->when($filtros->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
                    return $query->where('ciclo_lectivo_id', $ciclo_lectivo_id);
                })
                ->when($filtros->division_id, function ($query, $division_id) {
                    return $query->where('division_id', $division_id);
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

    public function createRepetidor($institucion_id, $alumno_id)
    {
        return Inertia::render('Repetidores/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'cicloLectivo' => CicloLectivo::where('institucion_id', $institucion_id)->where('activado', '1')->first(),
        ]);
    }

    public function store(StoreRepetidor $request, $institucion_id)
    {
        Repetidor::create([
            'institucion_id' => $institucion_id,
            'alumno_id' => $request->alumno_id,
            'division_id' => $request->division_id,
            'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
            'comentario' => $request->comentario,
        ]);

        return redirect(route('repetidores.index', $institucion_id))->with(['successMessage' => 'Repetidor cargado con exito!']);
    }

    public function show($institucion_id, $alumno_id)
    {
        return Inertia::render('Repetidores/Show', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'tipo' => session('tipo'),
            'repeticiones' => Repetidor::where('alumno_id', $alumno_id)
                ->with('ciclo_lectivo', 'division', 'division.nivel', 'division.curso', 'division.orientacion')
                ->orderBy('ciclo_lectivo_id')
                ->get()
                ->map(function ($repetidor) {
                    return [
                        'id' => $repetidor->id,
                        'division_id' => $repetidor->division_id,
                        'division' => $repetidor->division,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($repetidor->ciclo_lectivo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($repetidor->ciclo_lectivo->final),
                        'comentario'  => $repetidor->comentario,
                    ];
                }),
        ]);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Repetidores/Edit', [
            'institucion_id' => $institucion_id,
            'repetidor' => Repetidor::with('alumno', 'alumno.user')->find($id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'institucion_id' => $ciclo->institucion_id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                        'activado' => $ciclo->activado,
                    ];
                }),
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with('nivel', 'curso', 'orientacion')
                ->get(),
        ]);
    }

    public function update(Request $request, $institucion_id, $id)
    {
        Repetidor::where('id', $id)
            ->update([
                'division_id' => $request->division_id,
                'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
                'comentario' => $request->comentario,
            ]);

        return redirect(route('repetidores.index', $institucion_id))->with(['successMessage' => 'Repetidor actualziado con exito!']);
    }

    public function destroy($institucion_id, $id)
    {
        Repetidor::destroy($id);
        return redirect(route('repetidores.index', $institucion_id))->with(['successMessage' => 'Repetidor eliminado con exito!']);
    }
}
