<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\UpdateEntrega;
use App\Jobs\Evaluaciones\EntregaDestroyJob;
use App\Models\Evaluaciones\Correccion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\EntregaArchivo;
use App\Models\Evaluaciones\EntregaComentario;
use App\Repositories\Estructuras\DivisionRepository;
use App\Repositories\Evaluaciones\EvaluacionRepository;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EntregaController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $evaluacionRepository;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        DivisionRepository $divisionRepository,
        EvaluacionRepository $evaluacionRepository
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes')->only('edit', 'update', 'destroy');
        $this->middleware('entregaCorrespondiente')->only('show', 'edit', 'update');

        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
        $this->evaluacionRepository = $evaluacionRepository;
    }

    public function index($institucion_id, $division_id, $evaluacion_id)
    {
        return Inertia::render('Evaluaciones/Entregas/Index', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'evaluacion' => $this->evaluacionRepository->find($evaluacion_id),
            'entregas' => Entrega::where('evaluacion_id', $evaluacion_id)->with(['alumno', 'alumno.user'])->paginate(20),
            'tipo' => session('tipo'),
        ]);
    }

    public function show($institucion_id, $division_id, $evaluacion_id, $id)
    {
        return Inertia::render('Evaluaciones/Entregas/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'user_id' => Auth::id(),
            'division' => $this->divisionRepository->find($division_id),
            'evaluacion' => $this->evaluacionRepository->find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->findOrFail($id),
            'archivos' => EntregaArchivo::where('entrega_id', $id)->orderBy('created_at', 'DESC')->get()
                ->map(function ($archivo) {
                    return [
                        'id' => $archivo->id,
                        'archivo' => $archivo->archivo,
                    ];
                }),
            'correcciones' => Correccion::where('entrega_id', $id)->orderBy('created_at', 'DESC')->get()
                ->map(function ($correccion) {
                    return [
                        'id' => $correccion->id,
                        'archivo' => $correccion->archivo,
                    ];
                }),
            'comentarios' => EntregaComentario::where('entrega_id', $id)
                ->with('user')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20)
                ->transform(function ($comentario) {
                    return [
                        'id' => $comentario->id,
                        'user_id' => $comentario->user_id,
                        'division_id' => $comentario->entrega_id,
                        'comentario' => $comentario->comentario,
                        'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($comentario->updated_at),
                        'user' => $comentario->user->only('name'),
                    ];
                }),
        ]);
    }

    public function edit($institucion_id, $division_id, $evaluacion_id, $id)
    {
        $arrayTemporal = $this->divisionRepository->obtenerFormaEvaluacion($division_id);

        return Inertia::render('Evaluaciones/Entregas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'evaluacion' => $this->evaluacionRepository->find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->findOrFail($id),
            'formasDescripcion' => $arrayTemporal[0],
            'tipoEvaluacion' => $arrayTemporal[1],
        ]);
    }

    public function update(UpdateEntrega $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->calificacion = $request->calificacion;
        $entrega->comentario = $request->comentario;
        $entrega->save();

        return redirect(route('entregas.show', [$institucion_id, $division_id, $evaluacion_id, $id]))
            ->with(['successMessage' => 'Entrega calificada y/o comentada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $id)
    {
        EntregaDestroyJob::dispatch($id);
        return redirect(route('entregas.index', [$institucion_id, $division_id, $evaluacion_id]))
            ->with(['successMessage' => 'Entrega eliminada con éxito!']);
    }
}
