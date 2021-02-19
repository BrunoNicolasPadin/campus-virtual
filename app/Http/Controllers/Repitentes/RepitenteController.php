<?php

namespace App\Http\Controllers\Repitentes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repitentes\StoreRepitente;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Repitentes\Repitente;
use App\Models\Roles\Alumno;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RepitenteController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->except('show');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('show');
        $this->middleware('alumnoCorrespondiente')->only('createRepitente');
        $this->middleware('repitenteCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Repitentes/Index', [
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
        ]);
    }

    public function filtrarRepitentes($institucion_id, Request $filtros)
    {
        return Repitente::where('institucion_id', $institucion_id)
            ->when($filtros->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
                return $query->where('ciclo_lectivo_id', $ciclo_lectivo_id);
            })
            ->when($filtros->division_id, function ($query, $division_id) {
                return $query->where('division_id', $division_id);
            })
            ->with('alumno', 'alumno.user', 'ciclo_lectivo', 'division', 'division.nivel', 'division.curso', 'division.orientacion')
            ->paginate(20)
            ->transform(function ($repitente) {
                return [
                    'id' => $repitente->id,
                    'alumno_id' => $repitente->alumno_id,
                    'division_id' => $repitente->division_id,
                    'division' => $repitente->division,
                    'alumno' => $repitente->alumno,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($repitente->ciclo_lectivo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($repitente->ciclo_lectivo->final),
                    'comentario'  => $repitente->comentario,
                ];
            });
    }

    public function createRepitente($institucion_id, $alumno_id)
    {
        return Inertia::render('Repitentes/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'cicloLectivo' => CicloLectivo::where('institucion_id', $institucion_id)->where('activado', '1')->first(),
        ]);
    }

    public function store(StoreRepitente $request, $institucion_id)
    {
        Repitente::create([
            'institucion_id' => $institucion_id,
            'alumno_id' => $request->alumno_id,
            'division_id' => $request->division_id,
            'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
            'comentario' => $request->comentario,
        ]);

        return redirect(route('repitentes.index', $institucion_id))
            ->with(['successMessage' => 'Repitente registrado con éxito!']);
    }

    public function show($institucion_id, $alumno_id)
    {
        return Inertia::render('Repitentes/Show', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'tipo' => session('tipo'),
            'repeticiones' => Repitente::where('alumno_id', $alumno_id)
                ->with('ciclo_lectivo', 'division', 'division.nivel', 'division.curso', 'division.orientacion')
                ->orderBy('ciclo_lectivo_id')
                ->get()
                ->map(function ($repitente) {
                    return [
                        'id' => $repitente->id,
                        'division_id' => $repitente->division_id,
                        'division' => $repitente->division,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($repitente->ciclo_lectivo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($repitente->ciclo_lectivo->final),
                        'comentario'  => $repitente->comentario,
                    ];
                }),
        ]);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Repitentes/Edit', [
            'institucion_id' => $institucion_id,
            'repitente' => Repitente::with('alumno', 'alumno.user')->find($id),
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
        $repitente = Repitente::find($id);
        $repitente->division_id = $request->division_id;
        $repitente->ciclo_lectivo_id = $request->ciclo_lectivo_id;
        $repitente->comentario = $request->comentario;
        $repitente->save();

        return redirect(route('repitentes.index', $institucion_id))
            ->with(['successMessage' => 'Repitente actualizado con éxito!']);
    }

    public function destroy($institucion_id, $id)
    {
        Repitente::destroy($id);
        return redirect(route('repitentes.index', $institucion_id))
            ->with(['successMessage' => 'Repitente eliminado con éxito!']);
    }
}
