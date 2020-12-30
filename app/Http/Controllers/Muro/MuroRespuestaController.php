<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroRespuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MuroRespuestaController extends Controller
{
    public function index($institucion_id, $division_id, $muro_id)
    {
        return Inertia::render('Muro/Respuesta/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'publicacion' => Muro::with('user')->find($muro_id),
            'respuestas' => MuroRespuesta::where('muro_id', $muro_id)->with('user')->orderBy('created_at', 'DESC')->paginate(10),
        ]);
    }

    public function store(Request $request, $institucion_id, $division_id, $muro_id)
    {
        MuroRespuesta::create([
            'muro_id' => $muro_id,
            'user_id' => Auth::id(),
            'respuesta' => $request->respuesta,
        ]);
        return back()->with(['successMessage' => 'Respuesta realizada con exito!']);
    }

    public function update(Request $request, $institucion_id, $division_id, $muro_id, $id)
    {
        MuroRespuesta::where('id', $id)
            ->update([
                'respuesta' => $request->respuesta,
            ]);
        return back()->with(['successMessage' => 'Respuesta actualizada con exito!']);
    }

    public function destroy($institucion_id, $division_id, $muro_id, $id)
    {
        MuroRespuesta::destroy($id);
        return back()->with(['successMessage' => 'Respuesta eliminada con exito!']);
    }
}
