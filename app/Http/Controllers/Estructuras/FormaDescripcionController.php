<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormaDescripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('formaEvaluacionCorrespondiente');
        $this->middleware('formaDescripcionCorrespondiente')->only('edit', 'update', 'destroy');
    }

    public function create($institucion_id, $forma_evaluacion_id)
    {
        return Inertia::render('FormasEvaluacion/FormasDescripcion/Create', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => FormaEvaluacion::findOrFail($forma_evaluacion_id),
        ]);
    }

    public function store(Request $request, $institucion_id, $forma_evaluacion_id)
    {
        FormaDescripcion::create([
            'forma_evaluacion_id' => $forma_evaluacion_id,
            'opcion' => $request->opcion,
            'aprobado' => $request->aprobado,
        ]);

        return redirect(route('formas-evaluacion.show', [$institucion_id, $forma_evaluacion_id]))
            ->with(['successMessage' => 'Forma de descripción creada con éxito!']);
    }

    public function edit($institucion_id, $forma_evaluacion_id, $id)
    {
        return Inertia::render('FormasEvaluacion/FormasDescripcion/Edit', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => FormaEvaluacion::findOrFail($forma_evaluacion_id),
            'formaDescripcion' => FormaDescripcion::findOrFail($id),
        ]); 
    }

    public function update(Request $request, $institucion_id, $forma_evaluacion_id, $id)
    {
        FormaDescripcion::where('id', $id)
        ->update([
            'opcion' => $request->opcion,
            'aprobado' => $request->aprobado,
        ]);
        
        return redirect(route('formas-evaluacion.show', [$institucion_id, $forma_evaluacion_id]))
            ->with(['successMessage' => 'Forma de descripción actualizada con éxito!']);
    }

    public function destroy($institucion_id, $forma_evaluacion_id, $id)
    {
        FormaDescripcion::destroy($id);
        return redirect(route('formas-evaluacion.show', [$institucion_id, $forma_evaluacion_id]))
            ->with(['successMessage' => 'Forma de descripción eliminada con éxito!']);
    }
}
