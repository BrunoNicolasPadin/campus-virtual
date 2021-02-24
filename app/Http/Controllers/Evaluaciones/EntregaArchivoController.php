<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Evaluaciones\EntregaArchivo;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\Division\DivisionService;
use App\Services\Evaluaciones\EntregaService;
use App\Services\Evaluaciones\EvaluacionService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EntregaArchivoController extends Controller
{
    protected $obtenerFechaHoraService;
    protected $divisionService;
    protected $evaluacionService;
    protected $entregaService;

    public function __construct(
        ObtenerFechaHoraService $obtenerFechaHoraService,
        DivisionService $divisionService,
        EvaluacionService $evaluacionService,
        EntregaService $entregaService
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
        $this->divisionService = $divisionService;
        $this->evaluacionService = $evaluacionService;
        $this->entregaService = $entregaService;
    }

    public function create($institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        return Inertia::render('Evaluaciones/EntregasArchivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'evaluacion' => $this->evaluacionService->find($evaluacion_id),
            'entrega' => $this->entregaService->find($entrega_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            foreach ($archivos as $archivo) {
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $nombre = $fechaHora . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Evaluaciones/Entregas', $nombre);

                EntregaArchivo::create([
                    'entrega_id' => $entrega_id,
                    'archivo' => $nombre,
                ]);
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
