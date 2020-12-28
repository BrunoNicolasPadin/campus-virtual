<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MaterialController extends Controller
{
    public function create($institucion_id, $division_id, $grupo_id)
    {
        return Inertia::render('Materiales/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'grupo' => Grupo::find($grupo_id),
        ]);
    }

    public function store(Request $request, $institucion_id, $division_id, $grupo_id)
    {
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/Materiales', $archivo->getClientOriginalName());

            Material::create([
                'grupo_id' => $grupo_id,
                'nombre' => $request->nombre,
                'visibilidad' => $request->visibilidad,
                'archivo' => $archivoStore,
            ]);

            return back()->with(['successMessage' => 'Archivo cargado con exito! Apriete en el boton "Eliminar" para cargar otro archivo.']);
        }
        return back()->withErrors('No hay ningun archivo');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
