<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materiales\StoreGrupo;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use App\Models\Roles\Docente;
use App\Services\Archivos\EliminarGruposMateriales;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GrupoController extends Controller
{
    protected $archivosServices;
    protected $divisionService;
    protected $asignaturaService;

    public function __construct(
        EliminarGruposMateriales $archivosServices,
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->except('show');
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('index', 'show');
        $this->middleware('grupoCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->archivosServices = $archivosServices;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
    }

    public function index($institucion_id, $division_id)
    {
        $gruposTodos = Grupo::select('id', 'asignatura_id', 'nombre')
            ->where('division_id', $division_id)
            ->with(array(
                'asignatura' => function($query){
                    $query->select('id', 'nombre');
                },
            ))
            ->orderBy('updated_at', 'ASC')
            ->paginate(10);

        return Inertia::render('Materiales/Grupos/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignaturas' => $this->asignaturaService->get($division_id),
            'gruposTodos' => $gruposTodos,
        ]);
    }

    public function create($institucion_id, $division_id)
    {
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
            'division' => $this->divisionService->find($division_id),
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
            'division' => $this->divisionService->find($division_id),
            'grupo' => Grupo::with('asignatura')->findOrFail($id),
            'archivos' => Material::where('grupo_id', $id)->get(),
            'cantidad' => Material::where('grupo_id', $id)->count(),
        ]);
    }

    public function edit($institucion_id, $division_id, $id)
    {
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
            'division' => $this->divisionService->find($division_id),
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
        $this->archivosServices->eliminarGruposMateriales($id);

        Grupo::destroy($id);
        return redirect(route('materiales.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Grupo eliminado con éxito!']);
    }
}
