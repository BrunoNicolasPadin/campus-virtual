<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreRespuesta;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroRespuesta;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MuroRespuestaController extends Controller
{
    protected $divisionService;
    protected $formatoService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        DivisionService $divisionService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('verArchivosMuroCorrespondiente');
        $this->middleware('respuestaMuroCorrespondiente')->only('update', 'destroy');

        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
    }

    public function index($institucion_id, $division_id, $muro_id)
    {
        $muro = Muro::with('user')->findOrFail($muro_id);

        return Inertia::render('Muro/Respuestas/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'publicacion' => [
                'id' => $muro->id,
                'publicacion' => $muro->publicacion,
                'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($muro->updated_at),
                'user' => $muro->user->only('id', 'name'),
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
        $respuesta = new MuroRespuesta();
        $respuesta->respuesta = $request->respuesta;
        $respuesta->muro()->associate($muro_id);
        $respuesta->user()->associate(Auth::id());
        $respuesta->save();

        return back()->with(['successMessage' => 'Respuesta agregada con éxito!']);
    }

    public function update(StoreRespuesta $request, $institucion_id, $division_id, $muro_id, $id)
    {
        MuroRespuesta::where('id', $id)
            ->update([
                'respuesta' => $request->respuesta,
            ]);
        return back()->with(['successMessage' => 'Respuesta actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $muro_id, $id)
    {
        MuroRespuesta::destroy($id);
        return back()->with(['successMessage' => 'Respuesta eliminada con éxito!']);
    }
}
