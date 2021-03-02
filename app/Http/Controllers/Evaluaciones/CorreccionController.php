<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Evaluaciones\Correccion;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\Division\DivisionService;
use App\Services\Evaluaciones\EntregaService;
use App\Services\Evaluaciones\EvaluacionService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CorreccionController extends Controller
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
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('correccionCorrespondiente')->only('destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->divisionService = $divisionService;
        $this->evaluacionService = $evaluacionService;
        $this->entregaService = $entregaService;
    }

    public function create($institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        return Inertia::render('Evaluaciones/Correcciones/Create', [
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

            for ($i=0; $i < count($archivos); $i++) { 
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $unique = substr(base64_encode(mt_rand()), 0, 15);
                $nombre = $fechaHora . '-' . $unique . '-' . $archivos[$i]->getClientOriginalName();
                $archivos[$i]->storeAs('public/Evaluaciones/Correcciones', $nombre);

                $correccion = new Correccion();
                $correccion->archivo = $nombre;
                $correccion->entrega()->associate($entrega_id);
                $correccion->save();
            }

            return redirect(route('entregas.show', [$institucion_id, $division_id, $evaluacion_id, $entrega_id]))
                ->with(['successMessage' => 'Correcciones subidas con éxito!']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $entrega_id, $id)
    {
        $correccion = Correccion::findOrFail($id);
        Storage::delete('public/Evaluaciones/Correcciones/' . $correccion->archivo);

        Correccion::destroy($id);
        return back()->with(['successMessage' => 'Correccion eliminada con éxito!']);
    }
}
