<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Models\Evaluaciones\EvaluacionRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EvaluacionRespuestaController extends Controller
{
    public function index($institucion_id, $division_id, $evaluacion_id, $comentario_id)
    {
        return Inertia::render('Evaluaciones/Respuestas/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'comentario' => EvaluacionComentario::with('user')->find($comentario_id),
            'respuestas' => EvaluacionRespuesta::with('user')->where('comentario_id', $comentario_id)->orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function store(Request $request, $institucion_id, $division_id, $evaluacion_id, $comentario_id)
    {
        EvaluacionRespuesta::create([
            'comentario_id' => $comentario_id,
            'user_id' => Auth::id(),
            'respuesta' => $request->respuesta,
        ]);
        return back()->with(['successMessage' => 'Respuesta cargada con exito!']);
    }

    public function update(Request $request, $institucion_id, $division_id, $evaluacion_id, $comentario_id, $id)
    {
        EvaluacionRespuesta::where('id', $id)
            ->update([
                'respuesta' => $request->respuesta,
            ]);
            return back()->with(['successMessage' => 'Respuesta editada con exito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $comentario_id, $id)
    {
        EvaluacionRespuesta::destroy($id);
        return back()->with(['successMessage' => 'Respuesta eliminada con exito!']);
    }
}
