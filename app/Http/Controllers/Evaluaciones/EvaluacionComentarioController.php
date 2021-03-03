<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreComentario;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;

class EvaluacionComentarioController extends Controller
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
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('comentarioEvaluacionCorrespondiente')->only('update', 'destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->formatoFechaHoraService = $formatoFechaHoraService;
    }

    public function store(StoreComentario $request, $institucion_id, $division_id, $evaluacion_id)
    {
        $comentario = new EvaluacionComentario();
        $comentario->comentario = $request->comentario;
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
        $comentario->created_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
        $comentario->updated_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
        $comentario->evaluacion()->associate($evaluacion_id);
        $comentario->user()->associate(Auth::id());
        $comentario->save();
    
        return back()->with(['successMessage' => 'Comentario cargado con éxito!']);
    }

    public function update(StoreComentario $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();

        EvaluacionComentario::where('id', $id)
            ->update([
                'comentario' => $request->comentario,
                'updated_at' => $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora),
            ]);
        return back()->with(['successMessage' => 'Comentario actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $id)
    {
        EvaluacionComentario::destroy($id);
        return back()->with(['successMessage' => 'Comentario eliminado con éxito!']);
    }
}
