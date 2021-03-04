<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estructuras\StoreFormaEvaluacion;
use App\Models\Estructuras\Division;
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
        $formaEvaluacion = $this->formaEvaluacionService->find($id);
        $formaDescripcion = [];
        if ($formaEvaluacion->tipo == 'Escrita') {
            $formaDescripcion = FormaDescripcion::where('forma_evaluacion_id', $id)->get();
        }

        $divisiones = Division::select('divisiones.id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
            'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre')
            ->where('divisiones.institucion_id', $institucion_id)
            ->where('divisiones.forma_evaluacion_id', $id)
            ->join('niveles', 'niveles.id', 'divisiones.nivel_id')
            ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
            ->join('cursos', 'cursos.id', 'divisiones.curso_id')
            ->orderBy('divisiones.nivel_id')
            ->orderBy('divisiones.curso_id')
            ->orderBy('divisiones.division')
            ->orderBy('divisiones.orientacion_id')
            ->paginate(10);

        return Inertia::render('FormasEvaluacion/Show', [
            'institucion_id' => $institucion_id,
            'formaEvaluacion' => $formaEvaluacion,
            'formasDescripcion' => $formaDescripcion,
            'divisiones' => $divisiones,
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
