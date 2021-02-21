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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EntregaController extends Controller
{
    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes')->only('edit', 'update', 'destroy');
        $this->middleware('entregaCorrespondiente')->only('show', 'edit', 'update');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $division_id, $evaluacion_id)
    {
        return Inertia::render('Evaluaciones/Entregas/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entregas' => Entrega::where('evaluacion_id', $evaluacion_id)->with(['alumno', 'alumno.user'])->paginate(20),
            'tipo' => session('tipo'),
        ]);
    }

    public function show($institucion_id, $division_id, $evaluacion_id, $id)
    {
        return Inertia::render('Evaluaciones/Entregas/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'user_id' => Auth::id(),
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
                ->paginate(20)
                ->transform(function ($comentario) {
                    return [
                        'id' => $comentario->id,
                        'user_id' => $comentario->user_id,
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
        $entrega = Entrega::findOrFail($id);
        $entrega->calificacion = $request->calificacion;
        $entrega->comentario = $request->comentario;
        $entrega->save();

        return redirect(route('entregas.show', [$institucion_id, $division_id, $evaluacion_id, $id]))
            ->with(['successMessage' => 'Entrega calificada y/o comentada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $id)
    {
        $entregasArchivos = EntregaArchivo::where('entrega_id', $id)->get();
        $correcciones = Correccion::where('entrega_id', $id)->get();

        foreach ($entregasArchivos as $entrega) {
            Storage::delete('public/Evaluaciones/Entregas/' . $entrega->archivo);
        }

        foreach ($correcciones as $correccion) {
            Storage::delete('public/Evaluaciones/Correcciones/' . $correccion->archivo);
        }

        Entrega::destroy($id);
        return redirect(route('entregas.index', [$institucion_id, $division_id, $evaluacion_id]))
            ->with(['successMessage' => 'Entrega eliminada con éxito!']);
    }
}
