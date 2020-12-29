<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Evaluaciones\EvaluacionComentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluacionComentarioController extends Controller
{
    public function store(Request $request, $institucion_id, $division_id, $evaluacion_id)
    {
        EvaluacionComentario::create([
            'evaluacion_id' => $evaluacion_id,
            'user_id' => Auth::id(),
            'comentario' => $request->comentario,
        ]);
        return back();
    }

    public function update(Request $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        EvaluacionComentario::where('id', $id)
            ->update([
                'comentario' => $request->comentario,
            ]);
        return back();
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $id)
    {
        EvaluacionComentario::destroy($id);
        return back();
    }
}
