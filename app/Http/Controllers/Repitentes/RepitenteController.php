<?php

namespace App\Http\Controllers\Repitentes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repitentes\StoreRepitente;
use App\Models\Repitentes\Repitente;
use App\Services\Alumnos\AlumnoService;
use App\Services\CiclosLectivos\CicloLectivoService;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RepitenteController extends Controller
{
    protected $formatoService;
    protected $divisionService;
    protected $cicloLectivoService;
    protected $alumnoService;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        DivisionService $divisionService,
        CicloLectivoService $cicloLectivoService,
        AlumnoService $alumnoService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->except('show');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('show');
        $this->middleware('alumnoCorrespondiente')->only('createRepitente');
        $this->middleware('repitenteCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
        $this->cicloLectivoService = $cicloLectivoService;
        $this->alumnoService = $alumnoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Repitentes/Index', [
            'institucion_id' => $institucion_id,
            'divisiones' => $this->divisionService->get($institucion_id),
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
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
            'alumno' => $this->alumnoService->find($alumno_id),
            'cicloLectivo' => $this->cicloLectivoService->obtenerCicloLectivoActivad($institucion_id),
        ]);
    }

    public function store(StoreRepitente $request, $institucion_id)
    {
        $repitente = new Repitente();
        $repitente->comentario = $request->comentario;
        $repitente->institucion()->associate($institucion_id);
        $repitente->alumno()->associate($request->alumno_id);
        $repitente->division()->associate($request->division_id);
        $repitente->ciclo_lectivo()->associate($request->ciclo_lectivo_id);
        $repitente->save();

        return redirect(route('repitentes.index', $institucion_id))
            ->with(['successMessage' => 'Repitente registrado con éxito!']);
    }

    public function show($institucion_id, $alumno_id)
    {
        return Inertia::render('Repitentes/Show', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoService->find($alumno_id),
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
        $repitente = Repitente::select('id', 'alumno_id', 'ciclo_lectivo_id', 'comentario', 'division_id')
            ->where('id', $id)
            ->with(array(
                'alumno' => function($query){
                    $query->select('id', 'user_id');
                },
                'alumno.user' => function($query){
                    $query->select('id', 'name');
                },
            ))
            ->first();

        return Inertia::render('Repitentes/Edit', [
            'institucion_id' => $institucion_id,
            'repitente' => $repitente,
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
            'divisiones' => $this->divisionService->get($institucion_id),
        ]);
    }

    public function update(Request $request, $institucion_id, $id)
    {
        $repitente = Repitente::findOrFail($id);
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
