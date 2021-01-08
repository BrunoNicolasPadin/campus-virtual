<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreComentario;
use App\Models\Evaluaciones\EntregaComentario;
use Illuminate\Support\Facades\Auth;

class EntregaComentarioController extends Controller
{
    public function store(StoreComentario $request, $institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        EntregaComentario::create([
            'entrega_id' => $entrega_id,
            'user_id' => Auth::id(),
            'comentario' => $request->comentario,
        ]);
        return back();
    }

    public function update(StoreComentario $request, $institucion_id, $division_id, $evaluacion_id, $entrega_id, $id)
    {
        EntregaComentario::where('id', $id)
            ->update([
                'comentario' => $request->comentario,
            ]);
        return back();
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $entrega_id, $id)
    {
        EntregaComentario::destroy($id);
        return back();
    }
}
