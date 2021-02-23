<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\UpdateEntrega;
use App\Models\Asignaturas\Asignatura;
use App\Models\Deudores\Anotado;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use App\Models\Deudores\RendirComentario;
use App\Models\Deudores\RendirCorreccion;
use App\Models\Deudores\RendirEntrega;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use App\Services\Archivos\EliminarMesas;
use App\Services\Division\ObtenerFormaEvaluacion;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use App\Services\Mesas\EvaluarAprobacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnotadoController extends Controller
{
    protected $formatoService;
    protected $mesasService;
    protected $evaluarAprobacionService;
    protected $formaEvaluacionService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        EliminarMesas $mesasService,
        EvaluarAprobacion $evaluarAprobacionService,
        ObtenerFormaEvaluacion $formaEvaluacionService,
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

        $this->formatoService = $formatoService;
        $this->mesasService = $mesasService;
        $this->evaluarAprobacionService = $evaluarAprobacionService;
        $this->formaEvaluacionService = $formaEvaluacionService;
    }

    public function store(Request $request, $institucion_id, $division_id, $asignatura_id, $mesa_id)
    {
        $alumno = Alumno::where('user_id', Auth::id())->where('institucion_id', $institucion_id)->first();
        Anotado::create([
            'mesa_id' => $mesa_id,
            'alumno_id' => $alumno['id'],
        ]);
        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
            ->with(['successMessage' => 'Te inscribbiste con éxito!']);
    }

    public function show($institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $mesa = Mesa::select('id', 'fechaHora')->findOrFail($mesa_id);

        return Inertia::render('Deudores/Anotados/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'user_id' => Auth::id(),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHora),
            ],
            'anotado' => Anotado::with('alumno', 'alumno.user')->findOrFail($id),
            'archivos' => MesaArchivo::where('mesa_id', $mesa_id)->get(),
            'entregas' => RendirEntrega::where('anotado_id', $id)->get(),
            'correcciones' => RendirCorreccion::where('anotado_id', $id)->get(),
            'comentarios' => RendirComentario::where('anotado_id', $id)
                ->with('user')
                ->orderBy('updated_at', 'DESC')
                ->paginate(20)
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
        $mesa = Mesa::select('id', 'fechaHora')->findOrFail($mesa_id);
        $arrayTemporal = $this->formaEvaluacionService->obtenerFormaEvaluacion($division_id);

        return Inertia::render('Deudores/Anotados/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHora),
            ],
            'anotado' => Anotado::with('alumno', 'alumno.user')->findOrFail($id),
            'formasDescripcion' => $arrayTemporal[0],
            'tipoEvaluacion' => $arrayTemporal[1],
        ]);
    }

    public function update(UpdateEntrega $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $anotado = Anotado::findOrFail($id);

        $anotado->calificacion = $request->calificacion;
        $anotado->comentario = $request->comentario;
        $anotado->save();

        $this->evaluarAprobacionService->actualizacionDeInscripcion($division_id, $request, $anotado, $asignatura_id);

        return redirect(route('anotados.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id, $id]))
            ->with(['successMessage' => 'Alumno calificado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $this->mesasService->eliminarInscripciones($id);
        
        Anotado::destroy($id);
        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
            ->with(['successMessage' => 'Inscripción eliminada con éxito!']);

    }
}
