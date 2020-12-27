<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacion;
use App\Http\Requests\Evaluaciones\UpdateEvaluacion;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Archivo;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Roles\Docente;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EvaluacionController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Evaluaciones/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluaciones' => Evaluacion::where('division_id', $division_id)
                ->with('asignatura')
                ->orderBy('fechaHoraRealizacion')
                ->get(),
        ]);
    }

    public function create($institucion_id, $division_id)
    {
        $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();
    
        return Inertia::render('Evaluaciones/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignaturasDocentes' => AsignaturaDocente::where('docente_id', $docente['id'])->with('asignatura')->get(),
        ]);
    }

    public function store(StoreEvaluacion $request, $institucion_id, $division_id)
    {
        $eva = Evaluacion::create([
            'division_id' => $division_id,
            'asignatura_id' => $request->asignatura_id,
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraRealizacion),
            'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraFinalizacion),
            'comentario' => $request->comentario,
        ]);

        return redirect(route('evaluaciones.show', [$institucion_id, $division_id, $eva->id]));
    }

    public function show($institucion_id, $division_id, $id)
    {
        return Inertia::render('Evaluaciones/Show', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($id),
            'archivos' => Archivo::where('evaluacion_id', $id)->orderBy('titulo')->get(),
        ]);
    }

    public function edit($institucion_id, $division_id, $id)
    {
        $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();
    
        return Inertia::render('Evaluaciones/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignaturasDocentes' => AsignaturaDocente::where('docente_id', $docente['id'])->with('asignatura')->get(),
            'evaluacion' => Evaluacion::find($id),
        ]);
    }

    public function update(UpdateEvaluacion $request, $institucion_id, $division_id, $id)
    {
        Evaluacion::where('id', $id)
            ->update([
                'asignatura_id' => $request->asignatura_id,
                'titulo' => $request->titulo,
                'tipo' => $request->tipo,
                'fechaHoraRealizacion' => $request->fechaHoraRealizacion,
                'fechaHoraFinalizacion' => $request->fechaHoraFinalizacion,
                'comentario' => $request->comentario,
            ]);

        return redirect(route('evaluaciones.show', [$institucion_id, $division_id, $id]));
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        Evaluacion::destroy($id);
        return redirect(route('evaluaciones.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Evaluacion eliminada con exito!']);
    }
}
