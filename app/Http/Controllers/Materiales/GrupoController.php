<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materiales\StoreGrupo;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Estructuras\Division;
use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use App\Models\Roles\Docente;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GrupoController extends Controller
{
    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Materiales/Grupos/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'grupos' => Grupo::where('division_id', $division_id)->with('asignatura')->get(),
        ]);
    }

    public function create($institucion_id, $division_id)
    {
        $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();

        return Inertia::render('Materiales/Grupos/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignaturasDocentes' => AsignaturaDocente::where('docente_id', $docente['id'])
                ->with('asignatura')
                ->get(),
        ]);
    }

    public function store(StoreGrupo $request, $institucion_id, $division_id)
    {
        $grupo = Grupo::create([
            'division_id' => $division_id,
            'asignatura_id' => $request->asignatura_id,
            'nombre' => $request->nombre,
        ]);
        return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo->id]));
    }

    public function show($institucion_id, $division_id, $id)
    {
        return Inertia::render('Materiales/Grupos/Show', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'grupo' => Grupo::find($id),
            'archivos' => Material::where('grupo_id', $id)->get(),
        ]);
    }

    public function edit($institucion_id, $division_id, $id)
    {
        $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();

        return Inertia::render('Materiales/Grupos/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignaturasDocentes' => AsignaturaDocente::where('docente_id', $docente['id'])
                ->with('asignatura')
                ->get(),
            'grupo' => Grupo::find($id),
        ]);
    }

    public function update(StoreGrupo $request, $institucion_id, $division_id, $id)
    {
        Grupo::where('id', $id)
            ->update([
                'division_id' => $division_id,
                'asignatura_id' => $request->asignatura_id,
                'nombre' => $request->nombre,
            ]);
        return redirect(route('materiales.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Editado con exito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        Grupo::destroy($id);
        return redirect(route('materiales.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Eliminado con exito!']);
    }
}
