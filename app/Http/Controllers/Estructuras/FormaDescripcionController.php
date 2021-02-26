<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\FormaDescripcion;
use App\Services\Division\FormaEvaluacionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormaDescripcionController extends Controller
{
    protected $formaEvaluacionService;

    public function __construct(FormaEvaluacionService $formaEvaluacionService)
    {
        $this->middleware('auth');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('formaEvaluacionCorrespondiente');
        $this->middleware('formaDescripcionCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formaEvaluacionService = $formaEvaluacionService;
    }

    public function create($institucion_id, $forma_evaluacion_id)
    {
        return Inertia::render('FormasEvaluacion/FormasDescripcion/Create', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => $this->formaEvaluacionService->find($forma_evaluacion_id),
        ]);
    }

    public function store(Request $request, $institucion_id, $forma_evaluacion_id)
    {
        $formaDescripcion = new FormaDescripcion();
        $formaDescripcion->opcion = $request->opcion;
        $formaDescripcion->aprobado = $request->aprobado;
        $formaDescripcion->formaEvaluacion()->associate($forma_evaluacion_id);
        $formaDescripcion->save();

        return redirect(route('formas-evaluacion.show', [$institucion_id, $forma_evaluacion_id]))
            ->with(['successMessage' => 'Forma de descripción creada con éxito!']);
    }

    public function edit($institucion_id, $forma_evaluacion_id, $id)
    {
        return Inertia::render('FormasEvaluacion/FormasDescripcion/Edit', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => $this->formaEvaluacionService->find($forma_evaluacion_id),
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
