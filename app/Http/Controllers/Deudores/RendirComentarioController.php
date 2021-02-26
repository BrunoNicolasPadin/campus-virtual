<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreComentario;
use App\Models\Deudores\RendirComentario;
use Illuminate\Support\Facades\Auth;

class RendirComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('mesaCorrespondiente');
        $this->middleware('inscripcionCorrespondiente');
        $this->middleware('rendirComentarioCorrespondiente')->only('update', 'destroy');
    }

    public function store(StoreComentario $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id)
    {
        $rendirComentario = new RendirComentario();
        $rendirComentario->comentario = $request->comentario;
        $rendirComentario->anotado()->associate($anotado_id);
        $rendirComentario->user()->associate(Auth::id());
        $rendirComentario->save();

        return back()->with(['successMessage' => 'Comentario subido con éxito!']);
    }

    public function update(StoreComentario $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id, $id)
    {
        RendirComentario::where('id', $id)
            ->update([
                'comentario' => $request->comentario,
            ]);
        return back()->with(['successMessage' => 'Comentario actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id, $id)
    {
        RendirComentario::destroy($id);
        return back()->with(['successMessage' => 'Comentario eliminado con éxito!']);
    }
}
