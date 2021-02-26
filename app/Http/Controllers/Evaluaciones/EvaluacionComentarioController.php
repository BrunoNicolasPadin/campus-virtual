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
        $comentario = new EvaluacionComentario();
        $comentario->comentario = $request->comentario;
        $comentario->evaluacion()->associate($evaluacion_id);
        $comentario->user()->associate(Auth::id());
        $comentario->save();
    
        return back()->with(['successMessage' => 'Comentario cargado con éxito!']);
    }

    public function update(StoreComentario $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        EvaluacionComentario::where('id', $id)
            ->update([
                'comentario' => $request->comentario,
            ]);
        return back()->with(['successMessage' => 'Comentario actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $id)
    {
        EvaluacionComentario::destroy($id);
        return back()->with(['successMessage' => 'Comentario eliminado con éxito!']);
    }
}
