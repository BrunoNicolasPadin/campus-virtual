<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreRespuesta;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Models\Evaluaciones\EvaluacionRespuesta;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EvaluacionRespuestaController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('verRespuestasEvaluacionCorrespondiente');
        $this->middleware('respuestaEvaluacionCorrespondiente')->only('update', 'destroy');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $division_id, $evaluacion_id, $comentario_id)
    {
        $comentario = EvaluacionComentario::with('user')->findOrFail($comentario_id);

        return Inertia::render('Evaluaciones/Respuestas/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'evaluacion' => Evaluacion::findOrFail($evaluacion_id),
            'comentario' => [
                'id' => $comentario->id,
                'user' => $comentario->user->only('name'),
                'comentario' => $comentario->comentario,
                'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($comentario->updated_at),
            ],
            'respuestas' => EvaluacionRespuesta::with('user')->where('comentario_id', $comentario_id)->orderBy('created_at', 'DESC')->paginate(20)
                ->transform(function ($respuesta) {
                    return [
                        'id' => $respuesta->id,
                        'user' => $respuesta->user->only('id', 'name'),
                        'respuesta' => $respuesta->respuesta,
                        'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($respuesta->updated_at),
                    ];
                }),
        ]);
    }

    public function store(StoreRespuesta $request, $institucion_id, $division_id, $evaluacion_id, $comentario_id)
    {
        EvaluacionRespuesta::create([
            'comentario_id' => $comentario_id,
            'user_id' => Auth::id(),
            'respuesta' => $request->respuesta,
        ]);
        return back()->with(['successMessage' => 'Respuesta guardada con éxito!']);
    }

    public function update(StoreRespuesta $request, $institucion_id, $division_id, $evaluacion_id, $comentario_id, $id)
    {
        EvaluacionRespuesta::where('id', $id)
            ->update([
                'respuesta' => $request->respuesta,
            ]);
            return back()->with(['successMessage' => 'Respuesta actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $comentario_id, $id)
    {
        EvaluacionRespuesta::destroy($id);
        return back()->with(['successMessage' => 'Respuesta eliminada con éxito!']);
    }
}
