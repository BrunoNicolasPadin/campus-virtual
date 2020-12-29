<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Correccion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CorreccionController extends Controller
{
    public function create($institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        return Inertia::render('Evaluaciones/Correcciones/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->find($entrega_id),
        ]);
    }

    public function store(Request $request, $institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/Evaluaciones/Correcciones', $archivo->getClientOriginalName());

            Correccion::create([
                'entrega_id' => $entrega_id,
                'archivo' => $archivoStore,
            ]);

            return back()->with(['successMessage' => 'Correccion cargado con exito! Apriete en el boton "Eliminar" para cargar otro archivo.']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $entrega_id, $id)
    {
        Correccion::destroy($id);
        return back()->with(['successMessage' => 'Correccion eliminado con exito!']);
    }
}