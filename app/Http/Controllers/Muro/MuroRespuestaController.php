<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreRespuesta;
use App\Models\Estructuras\Division;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroRespuesta;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MuroRespuestaController extends Controller
{
    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('verRespuestasMuroCorrespondiente');
        $this->middleware('respuestaMuroCorrespondiente')->only('update', 'destroy');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $division_id, $muro_id)
    {
        $muro = Muro::with('user')->findOrFail($muro_id);

        return Inertia::render('Muro/Respuestas/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'publicacion' => [
                'id' => $muro->id,
                'publicacion' => $muro->publicacion,
                'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($muro->updated_at),
                'user' => $muro->user,
            ],
            'respuestas' => MuroRespuesta::where('muro_id', $muro->id)
                ->with('user')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20)
                ->transform(function ($respuesta) {
                    return [
                        'id' => $respuesta->id,
                        'respuesta' => $respuesta->respuesta,
                        'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($respuesta->updated_at),
                        'user' => $respuesta->user->only('id', 'name'),
                    ];
                }),
        ]);
    }

    public function store(StoreRespuesta $request, $institucion_id, $division_id, $muro_id)
    {
        MuroRespuesta::create([
            'muro_id' => $muro_id,
            'user_id' => Auth::id(),
            'respuesta' => $request->respuesta,
        ]);
        return back()->with(['successMessage' => 'Respuesta realizada con exito!']);
    }

    public function update(StoreRespuesta $request, $institucion_id, $division_id, $muro_id, $id)
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
