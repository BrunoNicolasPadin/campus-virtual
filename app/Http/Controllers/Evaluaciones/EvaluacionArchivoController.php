<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Archivo;
use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluacionArchivoController extends Controller
{
    public function create($institucion_id, $division_id, $evaluacion_id)
    {
        return Inertia::render('Evaluaciones/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
        ]);
    }

    public function store(Request $request, $institucion_id, $division_id, $evaluacion_id)
    {
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/Evaluaciones/Archivos', $archivo->getClientOriginalName());

            Archivo::create([
                'evaluacion_id' => $evaluacion_id,
                'titulo' => $request->titulo,
                'archivo' => $archivoStore,
                'visibilidad'  => $request->visibilidad,
            ]);

            return redirect(route('evaluaciones-archivos.create', [$institucion_id, $division_id, $evaluacion_id]))
                ->with(['successMessage' => 'Archivo cargado con exito!']);
        }

        return redirect(route('evaluaciones-archivos.create', [$institucion_id, $division_id, $evaluacion_id]))->withErrors('No hay ningun archivo');
    }

    public function edit($institucion_id, $division_id, $evaluacion_id, $id)
    {
        //
    }

    public function update(Request $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        //
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $id)
    {
        //
    }
}
