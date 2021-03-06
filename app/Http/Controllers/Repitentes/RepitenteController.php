<?php

namespace App\Http\Controllers\Repitentes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repitentes\StoreRepitente;
use App\Models\Repitentes\Repitente;
use App\Repositories\Alumnos\AlumnoRepository;
use App\Repositories\CiclosLectivos\CicloLectivoRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class RepitenteController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $cicloLectivoRepository;
    protected $alumnoRepository;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        DivisionRepository $divisionRepository,
        CicloLectivoRepository $cicloLectivoRepository,
        AlumnoRepository $alumnoRepository
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->except('show');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('show');
        $this->middleware('alumnoCorrespondiente')->only('createRepitente');
        $this->middleware('repitenteCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
        $this->cicloLectivoRepository = $cicloLectivoRepository;
        $this->alumnoRepository = $alumnoRepository;
    }

    public function index($institucion_id, Request $filtros)
    {
        $repitentes = DB::table('repitentes')

        ->select('repitentes.id', 'repitentes.alumno_id', 'repitentes.division_id', 'repitentes.comentario', 
        'divisiones.id AS division_id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
        'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre', 'users.name', 'users.profile_photo_path',
        'ciclos_lectivos.comienzo', 'ciclos_lectivos.final')
        ->where('repitentes.institucion_id', $institucion_id)
        ->leftjoin('divisiones', 'repitentes.division_id', 'divisiones.id')
        ->leftjoin('niveles', 'niveles.id', 'divisiones.nivel_id')
        ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
        ->leftjoin('cursos', 'cursos.id', 'divisiones.curso_id')
        ->join('alumnos', 'alumnos.id', 'repitentes.alumno_id')
        ->join('users', 'users.id', 'alumnos.user_id')
        ->join('ciclos_lectivos', 'ciclos_lectivos.id', 'repitentes.ciclo_lectivo_id')
        ->when($filtros->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
            return $query->where('repitentes.ciclo_lectivo_id', $ciclo_lectivo_id);
        })
        ->when($filtros->division_id, function ($query, $division_id) {
            return $query->where('repitentes.division_id', $division_id);
        })
        ->orderBy('users.name')
        ->paginate(10)
        ->through(function ($repitente) {
            return [
                'id' => $repitente->id,
                'alumno_id' => $repitente->alumno_id,
                'division_id' => $repitente->division_id,
                'name' => $repitente->name,
                'fotoDePerfil' => $repitente->profile_photo_path,
                'division' => $repitente->nivel_nombre . ' - ' . $repitente->orientacion_nombre . ' - ' . $repitente->curso_nombre . ' - ' . $repitente->division,
                'ciclo_lectivo' => $this->formatoService->cambiarFormatoParaMostrar($repitente->comienzo) . ' - ' . $this->formatoService->cambiarFormatoParaMostrar($repitente->final),
                'comentario' => $repitente->comentario,
            ];
        });

        return Inertia::render('Repitentes/Index', [
            'institucion_id' => $institucion_id,
            'divisiones' => $this->divisionRepository->get($institucion_id),
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
            'repitentes' => $repitentes,
            'ciclo_lectivo_id_index' => $filtros->ciclo_lectivo_id,
            'division_id_index' => $filtros->division_id,
        ]);
    }

    public function createRepitente($institucion_id, $alumno_id)
    {
        return Inertia::render('Repitentes/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
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
            'alumno' => $this->alumnoRepository->find($alumno_id),
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
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
            'divisiones' => $this->divisionRepository->get($institucion_id),
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
