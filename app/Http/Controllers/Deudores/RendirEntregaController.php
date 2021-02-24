<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Deudores\RendirEntrega;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use App\Services\Mesas\InscriptoService;
use App\Services\Mesas\MesaService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RendirEntregaController extends Controller
{
    protected $obtenerFechaHoraService;
    protected $divisionService;
    protected $asignaturaService;
    protected $mesaService;
    protected $inscripcionService;

    public function __construct(
        ObtenerFechaHoraService $obtenerFechaHoraService,
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService,
        MesaService $mesaService,
        InscriptoService $inscripcionService
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
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
        $this->mesaService = $mesaService;
        $this->inscripcionService = $inscripcionService;
    }

    public function create($institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id)
    {
        return Inertia::render('Deudores/Entregas/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
            'mesa' => $this->mesaService->find($mesa_id),
            'anotado' => $this->inscripcionService->find($anotado_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            foreach ($archivos as $archivo) {
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $nombre = $fechaHora . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Deudores/Entregas', $nombre);

                RendirEntrega::create([
                    'anotado_id' => $anotado_id,
                    'archivo' => $nombre,
                ]);
            }

            return redirect(route('anotados.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id]))
                ->with(['successMessage' => 'Tu entrega ha sido cargada con éxito!']);
        }

        return back()->withErrors('No hay ningún archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id, $id)
    {
        $entrega = RendirEntrega::findOrFail($id);
        Storage::delete('public/Deudores/Entregas/' . $entrega->archivo);

        RendirEntrega::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
