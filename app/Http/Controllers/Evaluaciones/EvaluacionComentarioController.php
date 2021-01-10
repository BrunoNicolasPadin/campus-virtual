<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreComentario;
use App\Models\Evaluaciones\EvaluacionComentario;
use Illuminate\Support\Facades\Auth;

class EvaluacionComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('comentarioEvaluacionCorrespondiente')->only('update', 'destroy');
    }

    public function store(StoreComentario $request, $institucion_id, $division_id, $evaluacion_id)
    {
        EvaluacionComentario::create([
            'evaluacion_id' => $evaluacion_id,
            'user_id' => Auth::id(),
            'comentario' => $request->comentario,
        ]);
        return back();
    }

    public function update(StoreComentario $request, $institucion_id, $division_id, $evaluacion_id, $id)
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
