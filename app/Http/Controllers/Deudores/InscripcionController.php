<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\UpdateEntrega;
use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use App\Models\Deudores\RendirComentario;
use App\Models\Deudores\RendirCorreccion;
use App\Models\Deudores\RendirEntrega;
use App\Models\Roles\Alumno;
use App\Services\Archivos\EliminarMesas;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use App\Services\Division\ObtenerFormaEvaluacion;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use App\Services\Mesas\EvaluarAprobacion;
use App\Services\Mesas\InscriptoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InscripcionController extends Controller
{
    protected $formatoService;
    protected $mesasService;
    protected $evaluarAprobacionService;
    protected $formaEvaluacionService;
    protected $divisionService;
    protected $asignaturaService;
    protected $inscripcionService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        EliminarMesas $mesasService,
        EvaluarAprobacion $evaluarAprobacionService,
        ObtenerFormaEvaluacion $formaEvaluacionService,
        DivisionService $divisionService,
        AsignaturaService $asignaturaService,
        InscriptoService $inscripcionService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->except('store', 'show');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('mesaCorrespondiente');
        $this->middleware('soloAlumnos')->only('store');
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('store', 'show');
        $this->middleware('inscripcionCorrespondiente')->except('store');
        $this->middleware('verificarInscripcion')->only('store');
        $this->middleware('verificarDesinscripcion')->only('destroy');

        $this->formatoService = $formatoService;
        $this->mesasService = $mesasService;
        $this->evaluarAprobacionService = $evaluarAprobacionService;
        $this->formaEvaluacionService = $formaEvaluacionService;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
        $this->inscripcionService = $inscripcionService;
    }

    public function store(Request $request, $institucion_id, $division_id, $asignatura_id, $mesa_id)
    {
        $alumno = Alumno::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();

        $inscripcion = new Inscripcion();
        $inscripcion->mesa()->associate($mesa_id);
        $inscripcion->alumno()->associate($alumno->id);
        $inscripcion->save();

        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
            ->with(['successMessage' => 'Te inscribiste con éxito!']);
    }

    public function show($institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $mesa = Mesa::select('id', 'fechaHoraRealizacion', 'fechaHoraFinalizacion')->findOrFail($mesa_id);

        return Inertia::render('Deudores/Inscripciones/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'user_id' => Auth::id(),
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
            ],
            'inscripcion' => Inscripcion::with(['alumno', 'alumno.user'])->findOrFail($id),
            'archivos' => MesaArchivo::where('mesa_id', $mesa_id)->get(),
            'entregas' => RendirEntrega::where('inscripcion_id', $id)->get(),
            'correcciones' => RendirCorreccion::where('inscripcion_id', $id)->get(),
            'comentarios' => RendirComentario::where('inscripcion_id', $id)
                ->with('user')
                ->orderBy('updated_at', 'DESC')
                ->paginate(10)
                ->transform(function ($comentario) {
                    return [
                        'id' => $comentario->id,
                        'user_id' => $comentario->user_id,
                        'comentario' => $comentario->comentario,
                        'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($comentario->updated_at),
                        'user' => $comentario->user->only('name'),
                    ];
                }),
        ]);
    }

    public function edit($institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $mesa = Mesa::select('id', 'fechaHoraRealizacion', 'fechaHoraFinalizacion')->findOrFail($mesa_id);
        $arrayTemporal = $this->formaEvaluacionService->obtenerFormaEvaluacion($division_id);

        return Inertia::render('Deudores/Inscripciones/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
            ],
            'inscripcion' => Inscripcion::with(['alumno', 'alumno.user'])->findOrFail($id),
            'formasDescripcion' => $arrayTemporal[0],
            'tipoEvaluacion' => $arrayTemporal[1],
        ]);
    }

    public function update(UpdateEntrega $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $inscripcion = Inscripcion::findOrFail($id);

        $inscripcion->calificacion = $request->calificacion;
        $inscripcion->comentario = $request->comentario;
        $inscripcion->save();

        $this->evaluarAprobacionService->actualizacionDeInscripcion($division_id, $request, $inscripcion, $asignatura_id);

        return redirect(route('inscripciones.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id, $id]))
            ->with(['successMessage' => 'Alumno calificado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $this->mesasService->eliminarInscripciones($id);
        
        Inscripcion::destroy($id);
        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
            ->with(['successMessage' => 'Inscripción eliminada con éxito!']);

    }
}
