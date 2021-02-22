<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormaEvaluacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('formaEvaluacionCorrespondiente')->only('show', 'edit', 'update', 'destroy');
    }

    public function index($institucion_id)
    {
        return Inertia::render('FormasEvaluacion/Index', [
            'institucion_id' => $institucion_id,
            'formasEvaluacion' => FormaEvaluacion::where('institucion_id', $institucion_id)->get(),
        ]);
    }

    public function create($institucion_id)
    {
        return Inertia::render('FormasEvaluacion/Create', [
            'institucion_id' => $institucion_id,
        ]);
    }

    public function store(Request $request, $institucion_id)
    {
        if ($request->desdeCuando == false) {
            $request->desdeCuando = null;
        }
        FormaEvaluacion::create([
            'institucion_id' => $institucion_id,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'desdeCuando' => $request->desdeCuando,
        ]);

        return redirect(route('formas-evaluacion.index', $institucion_id))
            ->with(['successMessage' => 'Forma de evaluación creada con éxito!']);
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('FormasEvaluacion/Show', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => FormaEvaluacion::findOrFail($id),
            'formasDescripcion' => FormaDescripcion::where('forma_evaluacion_id', $id)->get(),
        ]);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('FormasEvaluacion/Edit', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => FormaEvaluacion::findOrFail($id),
        ]);
    }

    public function update(Request $request, $institucion_id, $id)
    {
        FormaEvaluacion::findOrFail($id)
        ->update([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'desdeCuando' => $request->desdeCuando,
        ]);

        return redirect(route('formas-evaluacion.index', $institucion_id))->with(['successMessage' => 'Forma de evaluación actualizada con éxito!']);
    }

    public function destroy($institucion_id, $id)
    {
        FormaEvaluacion::destroy($id);
        return redirect(route('formas-evaluacion.index', $institucion_id))->with(['successMessage' => 'Forma de evaluación eliminada con éxito!']);
    }
}
