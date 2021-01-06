<?php

namespace App\Http\Controllers\CiclosLectivos;

use App\Http\Controllers\Controller;
use App\Http\Requests\CiclosLectivos\StoreCicloLectivo;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CicloLectivoController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->formatoService = $formatoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('CiclosLectivos/Index', [
            'institucion_id' => $institucion_id,
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
            ->orderBy('comienzo')
            ->get(),
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
        CicloLectivo::create([
            'institucion_id' => $institucion_id,
            'comienzo' => $this->formatoService->cambiarFormatoParaGuardar($request->comienzo),
            'final' => $this->formatoService->cambiarFormatoParaGuardar($request->final),
            'activado' => 0,
        ]);

        return redirect(route('ciclos-lectivos.index', $institucion_id))->with(['successMessage' => 'Ciclo lectivo cargado con éxito!']);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('CiclosLectivos/Edit', [
            'institucion_id' => $institucion_id,
            'cicloLectivo' => CicloLectivo::find($id),
        ]);
    }

    public function update(Request $request, $institucion_id, $id)
    {
        CicloLectivo::where('id', $id)
            ->update([
                'comienzo' => $this->formatoService->cambiarFormatoParaGuardar($request->comienzo),
                'final' => $this->formatoService->cambiarFormatoParaGuardar($request->final),
                'activado' => $request->activado,
            ]);

        return redirect(route('ciclos-lectivos.index', $institucion_id))->with(['successMessage' => 'Ciclo lectivo actualizado con éxito!']);
    }

    public function destroy($institucion_id, $id)
    {
        CicloLectivo::destroy($id);
        return redirect(route('ciclos-lectivos.index', $institucion_id))->with(['successMessage' => 'Ciclo lectivo eliminado con éxito!']);
    }
}
