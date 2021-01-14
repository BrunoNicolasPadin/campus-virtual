<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\UpdateEntrega;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Correccion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\EntregaArchivo;
use App\Models\Evaluaciones\EntregaComentario;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class EntregaController extends Controller
{
    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('soloDocentes')->only('edit', 'update');
        $this->middleware('entregaCorrespondiente')->only('show', 'edit', 'update');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $division_id, $evaluacion_id)
    {
        return Inertia::render('Evaluaciones/Entregas/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entregas' => Entrega::where('evaluacion_id', $evaluacion_id)->with(['alumno', 'alumno.user'])->get(),
        ]);
    }

    public function show($institucion_id, $division_id, $evaluacion_id, $id)
    {
        return Inertia::render('Evaluaciones/Entregas/Show', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->find($id),
            'archivos' => EntregaArchivo::where('entrega_id', $id)->orderBy('created_at', 'DESC')->get()
                ->map(function ($archivo) {
                    return [
                        'id' => $archivo->id,
                        'archivo' => $archivo->archivo,
                        'created_at' => $this->formatoService->cambiarFormatoParaMostrar($archivo->created_at),
                    ];
                }),
            'correcciones' => Correccion::where('entrega_id', $id)->orderBy('created_at', 'DESC')->get()
                ->map(function ($correccion) {
                    return [
                        'id' => $correccion->id,
                        'archivo' => $correccion->archivo,
                        'created_at' => $this->formatoService->cambiarFormatoParaMostrar($correccion->created_at),
                    ];
                }),
            'comentarios' => EntregaComentario::where('entrega_id', $id)
                ->with('user')
                ->orderBy('updated_at', 'DESC')
                ->paginate(10)
                ->transform(function ($comentario) {
                    return [
                        'id' => $comentario->id,
                        'division_id' => $comentario->entrega_id,
                        'comentario' => $comentario->comentario,
                        'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($comentario->updated_at),
                        'user' => $comentario->user->only('name'),
                    ];
                }),
        ]);
    }

    public function edit($institucion_id, $division_id, $evaluacion_id, $id)
    {
        return Inertia::render('Evaluaciones/Entregas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->find($id),
        ]);
    }

    public function update(UpdateEntrega $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        Entrega::where('id', $id)
            ->update([
                'calificacion' => $request->calificacion,
                'comentario' => $request->comentario,
            ]);
        return redirect(route('entregas.show', [$institucion_id, $division_id, $evaluacion_id, $id]))
            ->with(['successMessage' => 'Entrega calificada y/o comentada con exito!']);
    }
}
