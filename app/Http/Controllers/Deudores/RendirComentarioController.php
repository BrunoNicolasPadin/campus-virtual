<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreComentario;
use App\Models\Deudores\RendirComentario;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;

class RendirComentarioController extends Controller
{
    protected $obtenerFechaHoraService;
    protected $formatoFechaHoraService;

    public function __construct(
        ObtenerFechaHoraService $obtenerFechaHoraService,
        CambiarFormatoFechaHora $formatoFechaHoraService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('mesaCorrespondiente');
        $this->middleware('inscripcionCorrespondiente');
        $this->middleware('rendirComentarioCorrespondiente')->only('update', 'destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->formatoFechaHoraService = $formatoFechaHoraService;
    }

    public function store(StoreComentario $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id)
    {
        $rendirComentario = new RendirComentario();
        $rendirComentario->comentario = $request->comentario;
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
        $rendirComentario->created_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
        $rendirComentario->updated_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
        $rendirComentario->anotado()->associate($anotado_id);
        $rendirComentario->user()->associate(Auth::id());
        $rendirComentario->save();

        return back()->with(['successMessage' => 'Comentario subido con éxito!']);
    }

    public function update(StoreComentario $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id, $id)
    {
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
    
        RendirComentario::where('id', $id)
            ->update([
                'comentario' => $request->comentario,
                'updated_at' => $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora),
            ]);
        return back()->with(['successMessage' => 'Comentario actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id, $id)
    {
        RendirComentario::destroy($id);
        return back()->with(['successMessage' => 'Comentario eliminado con éxito!']);
    }
}
