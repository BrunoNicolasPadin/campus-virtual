<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacionArchivo;
use App\Http\Requests\Evaluaciones\UpdateEvaluacionArchivo;
use App\Models\Estructuras\Division;
use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->except('index');
        $this->middleware('soloDocentes')->except('index');
        $this->middleware('grupoCorrespondiente')->except('index');
        $this->middleware('grupoAdeudadoCorrespondiente')->only('index');
        $this->middleware('materialCorrespondiente')->only('edit', 'update', 'destroy');
    }

    public function index($institucion_id, $division_id, $grupo_id)
    {
        return Inertia::render('Materiales/Grupos/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'grupo' => Grupo::find($grupo_id),
            'archivos' => Material::where('grupo_id', $grupo_id)->get(),
        ]);
    }

    public function create($institucion_id, $division_id, $grupo_id)
    {
        return Inertia::render('Materiales/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'grupo' => Grupo::find($grupo_id),
        ]);
    }

    public function store(StoreEvaluacionArchivo $request, $institucion_id, $division_id, $grupo_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');
            $i = 0;

            foreach ($archivos as $archivo) {
                $fecha = date_create();
                $nombre = date_timestamp_get($fecha) . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Materiales', $nombre);

                Material::create([
                    'grupo_id' => $grupo_id,
                    'nombre' => $request['nombre'][$i],
                    'archivo' => $nombre,
                    'visibilidad'  => $request['visibilidad'][$i],
                ]);
                $i++;
            }

            return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
                ->with(['successMessage' => 'Archivos cargados con exito!']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function edit($institucion_id, $division_id, $grupo_id, $id)
    {
        return Inertia::render('Materiales/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'grupo' => Grupo::find($grupo_id),
            'archivo' => Material::find($id),
        ]);
    }

    public function update(UpdateEvaluacionArchivo $request, $institucion_id, $division_id, $grupo_id, $id)
    {
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');

            $fecha = date_create();
            $nombre = date_timestamp_get($fecha) . '-' . $archivo->getClientOriginalName();
            $archivo->storeAs('public/Materiales', $nombre);

            $material = Material::findOrFail($id);
            Storage::delete('public/Materiales/' . $material->archivo);

            Material::where('id', $id)
                ->update([
                    'nombre' => $request->nombre,
                    'archivo' => $nombre,
                    'visibilidad'  => $request->visibilidad,
                ]);

            return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
                ->with(['successMessage' => 'Archivos actualizados con exito!']);
        }

        Material::where('id', $id)
            ->update([
            'nombre' => $request->nombre,
            'visibilidad'  => $request->visibilidad,
        ]);

        return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
            ->with(['successMessage' => 'Nombre y/o visibilidad del archivo actualizadas con exito!']);
    }

    public function destroy($institucion_id, $division_id, $grupo_id, $id)
    {
        $material = Material::findOrFail($id);
        Storage::delete('public/Materiales/' . $material->archivo);

        Material::destroy($id);
        return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
                ->with(['successMessage' => 'Archivo eliminado con exito!']);
    }
}
