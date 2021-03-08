<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Evaluaciones\EntregaArchivo;
use App\Repositories\Estructuras\DivisionRepository;
use App\Repositories\Evaluaciones\EntregaRepository;
use App\Repositories\Evaluaciones\EvaluacionRepository;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EntregaArchivoController extends Controller
{
    protected $obtenerFechaHoraService;
    protected $divisionRepository;
    protected $evaluacionRepository;
    protected $entregaRepository;
    protected $formatoFechaHoraService;

    public function __construct(
        ObtenerFechaHoraService $obtenerFechaHoraService,
        DivisionRepository $divisionRepository,
        EvaluacionRepository $evaluacionRepository,
        EntregaRepository $entregaRepository,
        CambiarFormatoFechaHora $formatoFechaHoraService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('entregaCorrespondiente');
        $this->middleware('soloAlumnos')->except('destroy');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('destroy');
        $this->middleware('entregaArchivoCorrespondiente')->only('destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->divisionRepository = $divisionRepository;
        $this->evaluacionRepository = $evaluacionRepository;
        $this->entregaRepository = $entregaRepository;
        $this->formatoFechaHoraService = $formatoFechaHoraService;
    }

    public function create($institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        return Inertia::render('Evaluaciones/EntregasArchivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'evaluacion' => $this->evaluacionRepository->find($evaluacion_id),
            'entrega' => $this->entregaRepository->find($entrega_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            for ($i=0; $i < count($archivos); $i++) { 
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $unique = substr(base64_encode(mt_rand()), 0, 15);
                $nombre = $fechaHora . '-' . $unique . '-' . $archivos[$i]->getClientOriginalName();
                $archivos[$i]->storeAs('public/Evaluaciones/Entregas', $nombre);

                $entregaArchivo = new EntregaArchivo();
                $entregaArchivo->archivo = $nombre;
                $entregaArchivo->created_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
                $entregaArchivo->updated_at = $this->formatoFechaHoraService->cambiarFormatoParaGuardar($fechaHora);
                $entregaArchivo->entrega()->associate($entrega_id);
                $entregaArchivo->save();
            }

            return redirect(route('entregas.show', [$institucion_id, $division_id, $evaluacion_id, $entrega_id]))
                ->with(['successMessage' => 'Archivos subidos con éxito!']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $entrega_id, $id)
    {
        $entrega = EntregaArchivo::findOrFail($id);
        Storage::delete('public/Evaluaciones/Entregas/' . $entrega->archivo);

        EntregaArchivo::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
