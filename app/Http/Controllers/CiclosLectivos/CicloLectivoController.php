<?php

namespace App\Http\Controllers\CiclosLectivos;

use App\Http\Controllers\Controller;
use App\Http\Requests\CiclosLectivos\StoreCicloLectivo;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Services\CiclosLectivos\CicloLectivoService;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class CicloLectivoController extends Controller
{
    protected $formatoService;
    protected $cicloLectivoService;

    public function __construct(
        CambiarFormatoFecha $formatoService, 
        CicloLectivoService $cicloLectivoService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('cicloCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->cicloLectivoService = $cicloLectivoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('CiclosLectivos/Index', [
            'institucion_id' => $institucion_id,
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function create($institucion_id)
    {
        return Inertia::render('CiclosLectivos/Create', [
            'institucion_id' => $institucion_id,
        ]);
    }

    public function store(StoreCicloLectivo $request, $institucion_id)
    {
        if ($request->activado == true || $request->activado == 1) {
            CicloLectivo::where('institucion_id', $institucion_id)
            ->update([
                'activado' => '0',
            ]);
        }

        $cicloLectivo = new CicloLectivo();
        $cicloLectivo->comienzo = $this->formatoService->cambiarFormatoParaGuardar($request->comienzo);
        $cicloLectivo->final = $this->formatoService->cambiarFormatoParaGuardar($request->final);
        $cicloLectivo->activado = $request->activado;
        $cicloLectivo->institucion()->associate($institucion_id);
        $cicloLectivo->save();

        return redirect(route('ciclos-lectivos.index', $institucion_id))
            ->with(['successMessage' => 'Ciclo lectivo creado con éxito!']);
    }

    public function edit($institucion_id, $id)
    {
        $cicloLectivo = CicloLectivo::findOrFail($id);

        return Inertia::render('CiclosLectivos/Edit', [
            'institucion_id' => $institucion_id,
            'cicloLectivo' => [
                'id' => $cicloLectivo->id,
                'comienzo' => $this->formatoService->cambiarFormatoParaEditar($cicloLectivo->comienzo),
                'final' => $this->formatoService->cambiarFormatoParaEditar($cicloLectivo->final),
                'activado' => $cicloLectivo->activado,
            ],
        ]);
    }

    public function update(StoreCicloLectivo $request, $institucion_id, $id)
    {
        if ($request->activado == true || $request->activado == 1) {
            CicloLectivo::where('institucion_id', $institucion_id)
            ->where('id', '<>', $id)
            ->update([
                'activado' => '0',
            ]);
        }
        

        CicloLectivo::where('id', $id)
            ->update([
                'comienzo' => $this->formatoService->cambiarFormatoParaGuardar($request->comienzo),
                'final' => $this->formatoService->cambiarFormatoParaGuardar($request->final),
                'activado' => $request->activado,
            ]);

        return redirect(route('ciclos-lectivos.index', $institucion_id))
            ->with(['successMessage' => 'Ciclo lectivo actualizado con éxito!']);
    }

    public function destroy($institucion_id, $id)
    {
        CicloLectivo::destroy($id);
        return redirect(route('ciclos-lectivos.index', $institucion_id))
            ->with(['successMessage' => 'Ciclo lectivo eliminado con éxito!']);
    }
}
