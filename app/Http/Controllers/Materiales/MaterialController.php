<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacionArchivo;
use App\Http\Requests\Evaluaciones\UpdateEvaluacionArchivo;
use App\Models\Estructuras\Division;
use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use Inertia\Inertia;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloDocentes');
        $this->middleware('grupoCorrespondiente');
        $this->middleware('materialCorrespondiente')->only('edit', 'update', 'destroy');
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
                $archivoStore = $archivo->getClientOriginalName();
                $archivo->storeAs('public/Materiales', $archivo->getClientOriginalName());

                Material::create([
                    'grupo_id' => $grupo_id,
                    'nombre' => $request['nombre'][$i],
                    'archivo' => $archivoStore,
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

            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/Materiales', $archivo->getClientOriginalName());

            Material::where('id', $id)
                ->update([
                    'nombre' => $request->nombre,
                    'archivo' => $archivoStore,
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
        Material::destroy($id);
        return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
                ->with(['successMessage' => 'Archivo eliminado con exito!']);
    }
}
