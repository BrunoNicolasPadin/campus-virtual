<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Deudores\RendirEntrega;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\Deudores\InscripcionRepository;
use App\Repositories\Deudores\MesaRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RendirEntregaController extends Controller
{
    protected $obtenerFechaHoraService;
    protected $divisionRepository;
    protected $asignaturaRepository;
    protected $mesaRepository;
    protected $inscripcionRepository;
    protected $formatoFechaHoraService;

    public function __construct(
        ObtenerFechaHoraService $obtenerFechaHoraService,
        DivisionRepository $divisionRepository, 
        AsignaturaRepository $asignaturaRepository,
        MesaRepository $mesaRepository,
        InscripcionRepository $inscripcionRepository,
        CambiarFormatoFechaHora $formatoFechaHoraService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('mesaCorrespondiente');
        $this->middleware('inscripcionCorrespondiente');
        $this->middleware('soloAlumnos')->except('destroy');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('destroy');
        $this->middleware('rendirEntregaCorrespondiente')->only('destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
        $this->mesaRepository = $mesaRepository;
        $this->inscripcionRepository = $inscripcionRepository;
        $this->formatoFechaHoraService = $formatoFechaHoraService;
    }

    public function create($institucion_id, $division_id, $asignatura_id, $mesa_id, $inscripcion_id)
    {
        return Inertia::render('Deudores/Entregas/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignatura' => $this->asignaturaRepository->find($asignatura_id),
            'mesa' => $this->mesaRepository->find($mesa_id),
            'inscripcion' => $this->inscripcionRepository->find($inscripcion_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $inscripcion_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            for ($i=0; $i < count($archivos); $i++) { 
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $unique = substr(base64_encode(mt_rand()), 0, 15);
                $nombre = $fechaHora . '-' . $unique . '-' . $archivos[$i]->getClientOriginalName();
                $archivos[$i]->storeAs('Deudores/Entregas', $nombre, 's3');

                $rendirEntrega = new RendirEntrega();
                $rendirEntrega->archivo = $nombre;
                $rendirEntrega->created_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
                $rendirEntrega->updated_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
                $rendirEntrega->inscripcion()->associate($inscripcion_id);
                $rendirEntrega->save();
            }

            return redirect(route('inscripciones.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id, $inscripcion_id]))
                ->with(['successMessage' => 'Tu entrega ha sido cargada con éxito!']);
        }

        return back()->withErrors('No hay ningún archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $inscripcion_id, $id)
    {
        $entrega = RendirEntrega::findOrFail($id);
        Storage::disk('s3')->delete('Deudores/Entregas/' . $entrega->archivo);

        RendirEntrega::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
