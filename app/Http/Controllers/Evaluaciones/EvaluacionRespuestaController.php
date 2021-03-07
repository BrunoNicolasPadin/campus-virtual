<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreRespuesta;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Models\Evaluaciones\EvaluacionRespuesta;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\Division\DivisionService;
use App\Services\Evaluaciones\EvaluacionService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EvaluacionRespuestaController extends Controller
{
    protected $formatoFechaHoraService;
    protected $divisionService;
    protected $evaluacionService;
    protected $obtenerFechaHoraService;

    public function __construct(
        CambiarFormatoFechaHora $formatoFechaHoraService,
        DivisionService $divisionService,
        EvaluacionService $evaluacionService,
        ObtenerFechaHoraService $obtenerFechaHoraService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('verRespuestasEvaluacionCorrespondiente');
        $this->middleware('respuestaEvaluacionCorrespondiente')->only('update', 'destroy');

        $this->formatoFechaHoraService = $formatoFechaHoraService;
        $this->divisionService = $divisionService;
        $this->evaluacionService = $evaluacionService;
        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
    }

    public function index($institucion_id, $division_id, $evaluacion_id, $comentario_id)
    {
        $comentario = EvaluacionComentario::with('user')->findOrFail($comentario_id);

        return Inertia::render('Evaluaciones/Respuestas/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'evaluacion' => $this->evaluacionService->find($evaluacion_id),
            'comentario' => [
                'id' => $comentario->id,
                'user' => $comentario->user->only('name'),
                'comentario' => $comentario->comentario,
                'updated_at' => $this->formatoFechaHoraService->cambiarFormatoParaMostrar($comentario->updated_at),
            ],
            'respuestas' => EvaluacionRespuesta::with('user')->where('comentario_id', $comentario_id)->orderBy('updated_at', 'DESC')->paginate(20)
                ->transform(function ($respuesta) {
                    return [
                        'id' => $respuesta->id,
                        'user' => $respuesta->user->only('id', 'name'),
                        'respuesta' => $respuesta->respuesta,
                        'updated_at' => $this->formatoFechaHoraService->cambiarFormatoParaMostrar($respuesta->updated_at),
                    ];
                }),
        ]);
    }

    public function store(StoreRespuesta $request, $institucion_id, $division_id, $evaluacion_id, $comentario_id)
    {
        $respuesta = new EvaluacionRespuesta();
        $respuesta->respuesta = $request->respuesta;
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
        $respuesta->created_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
        $respuesta->updated_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
        $respuesta->comentario()->associate($comentario_id);
        $respuesta->user()->associate(Auth::id());
        $respuesta->save();

        return back()->with(['successMessage' => 'Respuesta guardada con éxito!']);
    }

    public function update(StoreRespuesta $request, $institucion_id, $division_id, $evaluacion_id, $comentario_id, $id)
    {
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();

        EvaluacionRespuesta::where('id', $id)
            ->update([
                'respuesta' => $request->respuesta,
                'updated_at' => $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora),

            ]);
            return back()->with(['successMessage' => 'Respuesta actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $comentario_id, $id)
    {
        EvaluacionRespuesta::destroy($id);
        return back()->with(['successMessage' => 'Respuesta eliminada con éxito!']);
    }
}
