<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacion;
use App\Jobs\Evaluaciones\EvaluacionDestroyJob;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\Archivo;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Models\Roles\Docente;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EvaluacionController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $asignaturaRepository;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        DivisionRepository $divisionRepository,
        AsignaturaRepository $asignaturaRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('index', 'show');
        $this->middleware('evaluacionCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
    }

    public function index($institucion_id, $division_id, Request $filtros)
    {
        return Inertia::render('Evaluaciones/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'asignatura_id_index' => $filtros->asignatura_id,
            'asignaturas' => $this->asignaturaRepository->get($division_id),
            'evaluaciones' => Evaluacion::where('division_id', $division_id)
                ->when($filtros->asignatura_id, function ($query, $asignatura_id) {
                    return $query->where('asignatura_id', $asignatura_id);
                })
                ->with('asignatura')
                ->orderBy('fechaHoraRealizacion')
                ->paginate(10)
                ->transform(function ($evaluacion) {
                    return [
                        'id' => $evaluacion->id,
                        'titulo' => $evaluacion->titulo,
                        'tipo' => $evaluacion->tipo,
                        'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraRealizacion),
                        'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraFinalizacion),
                        'asignatura'  => $evaluacion->asignatura->only('nombre'),
                    ];
                }),
        ]);
    }

    public function create($institucion_id, $division_id)
    {
        $asignaturas = '';
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            $asignaturas = Asignatura::select('nombre', 'id')
                ->where('division_id', $division_id)->get();
        }
        if (session('tipo') == 'Docente') {
            $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();
            $asignaturas = AsignaturaDocente::select('asignaturas.nombre', 'asignaturas.id')
                ->where('docente_id', $docente['id'])
                ->join('asignaturas', 'asignaturas.id', 'asignaturas_docentes.asignatura_id')
                ->where('asignaturas.division_id', $division_id)
                ->get();
        }
    
        return Inertia::render('Evaluaciones/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignaturasDocentes' => $asignaturas
        ]);
    }

    public function store(StoreEvaluacion $request, $institucion_id, $division_id)
    {
        $evaluacion = new Evaluacion();
        $evaluacion->titulo = $request->titulo;
        $evaluacion->tipo = $request->tipo;
        $evaluacion->fechaHoraRealizacion = $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraRealizacion);
        $evaluacion->fechaHoraFinalizacion = $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraFinalizacion);
        $evaluacion->comentario = $request->comentario;
        $evaluacion->institucion()->associate($institucion_id);
        $evaluacion->division()->associate($division_id);
        $evaluacion->asignatura()->associate($request->asignatura_id);
        $evaluacion->save();

        return redirect(route('evaluaciones.show', [$institucion_id, $division_id, $evaluacion->id]))
            ->with(['successMessage' => 'Evaluación registrada con éxito']);
    }

    public function show($institucion_id, $division_id, $id)
    {
        $evaluacion = Evaluacion::with('asignatura')->findOrFail($id);

        return Inertia::render('Evaluaciones/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'user_id' => Auth::id(),
            'division' => $this->divisionRepository->find($division_id),
            'evaluacion' => [
                'id' => $evaluacion->id,
                'asignatura' => $evaluacion->asignatura->only('nombre'),
                'titulo' => $evaluacion->titulo,
                'tipo' => $evaluacion->tipo,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($evaluacion->fechaHoraFinalizacion),
                'comentario' => $evaluacion->comentario,
            ],
            'archivos' => Archivo::where('evaluacion_id', $id)->orderBy('nombre')->get(),
            'comentarios' => EvaluacionComentario::where('evaluacion_id', $id)->with('user')->orderBy('updated_at', 'DESC')->paginate(10)
                ->transform(function ($comentario) {
                    return [
                        'id' => $comentario->id,
                        'user' => $comentario->user->only('id', 'name'),
                        'comentario' => $comentario->comentario,
                        'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($comentario->updated_at),
                    ];
                }),
        ]);
    }

    public function edit($institucion_id, $division_id, $id)
    {
        $asignaturas = '';
        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            $asignaturas = Asignatura::select('nombre', 'id')
                ->where('division_id', $division_id)->get();
        }
        if (session('tipo') == 'Docente') {
            $docente = Docente::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();
            $asignaturas = AsignaturaDocente::select('asignaturas.nombre', 'asignaturas.id')
                ->where('docente_id', $docente['id'])
                ->join('asignaturas', 'asignaturas.id', 'asignaturas_docentes.asignatura_id')
                ->where('asignaturas.division_id', $division_id)
                ->get();
        }
    
        $evaluacion = Evaluacion::findOrFail($id);
    
        return Inertia::render('Evaluaciones/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignaturasDocentes' => $asignaturas,
            'evaluacion' => [
                    'id' => $evaluacion->id,
                    'asignatura_id' => $evaluacion->asignatura_id,
                    'titulo' => $evaluacion->titulo,
                    'tipo' => $evaluacion->tipo,
                    'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaEditar($evaluacion->fechaHoraRealizacion),
                    'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaEditar($evaluacion->fechaHoraFinalizacion),
                    'comentario'  => $evaluacion->comentario,
                ],
        ]);
    }

    public function update(StoreEvaluacion $request, $institucion_id, $division_id, $id)
    {
        Evaluacion::where('id', $id)
            ->update([
                'asignatura_id' => $request->asignatura_id,
                'titulo' => $request->titulo,
                'tipo' => $request->tipo,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraFinalizacion),
                'comentario' => $request->comentario,
            ]);

        return redirect(route('evaluaciones.show', [$institucion_id, $division_id, $id]))
            ->with(['successMessage' => 'Evaluación actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        EvaluacionDestroyJob::dispatch($id);
        return redirect(route('evaluaciones.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Evaluación eliminada con éxito!']);
    }
}
