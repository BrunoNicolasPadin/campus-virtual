<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materiales\StoreGrupo;
use App\Jobs\Materiales\GrupoDestroyJob;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use App\Models\Roles\Docente;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\Estructuras\DivisionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GrupoController extends Controller
{
    protected $divisionRepository;
    protected $asignaturaRepository;

    public function __construct(
        DivisionRepository $divisionRepository, 
        AsignaturaRepository $asignaturaRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->except('show');
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('index', 'show');
        $this->middleware('grupoCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
    }

    public function index($institucion_id, $division_id, Request $filtros)
    {
        $grupos = Grupo::select('id', 'asignatura_id', 'nombre')
            ->where('division_id', $division_id)
            ->when($filtros->asignatura_id, function ($query, $asignatura_id) {
                return $query->where('asignatura_id', $asignatura_id);
            })
            ->with(array(
                'asignatura' => function($query){
                    $query->select('id', 'nombre');
                },
            ))
            ->paginate(10);

        return Inertia::render('Materiales/Grupos/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'asignaturas' => $this->asignaturaRepository->get($division_id),
            'grupos' => $grupos,
            'asignatura_id_index' => $filtros->asignatura_id,
        ]);
    }

    public function create($institucion_id, $division_id)
    {
        $asignaturas = '';
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            $asignaturas = Asignatura::select('nombre', 'id')
                ->where('division_id', $division_id)->get();
        }
        if (session('tipo') == 'Docente') {
            $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();
            $asignaturas = AsignaturaDocente::select('asignaturas.nombre', 'asignaturas.id')
                ->where('docente_id', $docente['id'])
                ->join('asignaturas', 'asignaturas.id', 'asignaturas_docentes.asignatura_id')
                ->where('asignaturas.division_id', $division_id)
                ->get();
        }

        return Inertia::render('Materiales/Grupos/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignaturasDocentes' => $asignaturas,
        ]);
    }

    public function store(StoreGrupo $request, $institucion_id, $division_id)
    {
        $grupo = new Grupo();
        $grupo->nombre = $request->nombre;
        $grupo->division()->associate($division_id);
        $grupo->asignatura()->associate($request->asignatura_id);
        $grupo->save();

        return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo->id]))
            ->with(['successMessage' => 'Grupo creado con éxito']);
    }

    public function show($institucion_id, $division_id, $id)
    {
        return Inertia::render('Materiales/Grupos/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'grupo' => Grupo::with('asignatura')->findOrFail($id),
            'archivos' => Material::where('grupo_id', $id)->get(),
            'cantidad' => Material::where('grupo_id', $id)->count(),
        ]);
    }

    public function edit($institucion_id, $division_id, $id)
    {
        $asignaturas = '';

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            $asignaturas = Asignatura::select('nombre', 'id')
                ->where('division_id', $division_id)->get();
        }
        if (session('tipo') == 'Docente') {
            $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();
            $asignaturas = AsignaturaDocente::select('asignaturas.nombre', 'asignaturas.id')
                ->where('docente_id', $docente['id'])
                ->join('asignaturas', 'asignaturas.id', 'asignaturas_docentes.asignatura_id')
                ->where('asignaturas.division_id', $division_id)
                ->get();
        }

        return Inertia::render('Materiales/Grupos/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignaturasDocentes' => $asignaturas,
            'grupo' => Grupo::findOrFail($id),
        ]);
    }

    public function update(StoreGrupo $request, $institucion_id, $division_id, $id)
    {
        Grupo::where('id', $id)
            ->update([
                'asignatura_id' => $request->asignatura_id,
                'nombre' => $request->nombre,
            ]);
        return redirect(route('materiales.show', [$institucion_id, $division_id, $id]))
            ->with(['successMessage' => 'Grupo actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        GrupoDestroyJob::dispatch($id);

        return redirect(route('materiales.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Grupo eliminado con éxito!']);
    }
}
