<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estructuras\StoreFormaEvaluacion;
use App\Models\Estructuras\FormaDescripcion;
use App\Models\Estructuras\FormaEvaluacion;
use App\Services\Division\FormaEvaluacionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormaEvaluacionController extends Controller
{
    protected $formaEvaluacionService;

    public function __construct(FormaEvaluacionService $formaEvaluacionService)
    {
        $this->middleware('auth');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('formaEvaluacionCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->formaEvaluacionService = $formaEvaluacionService;
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

    public function store(StoreFormaEvaluacion $request, $institucion_id)
    {
        if ($request->desdeCuando == false) {
            $request->desdeCuando = null;
        }

        $formaEvaluacion = new FormaEvaluacion();
        $formaEvaluacion->nombre = $request->nombre;
        $formaEvaluacion->tipo = $request->tipo;
        $formaEvaluacion->desdeCuando = $request->desdeCuando;
        $formaEvaluacion->institucion()->associate($institucion_id);
        $formaEvaluacion->save();

        return redirect(route('formas-evaluacion.index', $institucion_id))
            ->with(['successMessage' => 'Forma de evaluación creada con éxito!']);
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('FormasEvaluacion/Show', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => $this->formaEvaluacionService->find($id),
            'formasDescripcion' => FormaDescripcion::where('forma_evaluacion_id', $id)->get(),
        ]);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('FormasEvaluacion/Edit', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => $this->formaEvaluacionService->find($id),
        ]);
    }

    public function update(StoreFormaEvaluacion $request, $institucion_id, $id)
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
