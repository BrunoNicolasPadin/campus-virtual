<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacionArchivo;
use App\Http\Requests\Evaluaciones\UpdateEvaluacionArchivo;
use App\Models\Evaluaciones\Archivo;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\Division\DivisionService;
use App\Services\Evaluaciones\EvaluacionService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EvaluacionArchivoController extends Controller
{
    protected $obtenerFechaHoraService;
    protected $divisionService;
    protected $evaluacionService;

    public function __construct(
        ObtenerFechaHoraService $obtenerFechaHoraService,
        DivisionService $divisionService,
        EvaluacionService $evaluacionService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('archivoCorrespondiente')->only('edit', 'update', 'destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->divisionService = $divisionService;
        $this->evaluacionService = $evaluacionService;
    }

    public function create($institucion_id, $division_id, $evaluacion_id)
    {
        return Inertia::render('Evaluaciones/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'evaluacion' => $this->evaluacionService->find($evaluacion_id),
        ]);
    }

    public function store(StoreEvaluacionArchivo $request, $institucion_id, $division_id, $evaluacion_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            for ($i=0; $i < count($archivos); $i++) { 
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $unique = substr(base64_encode(mt_rand()), 0, 15);
                $nombre = $fechaHora . '-' . $unique . '-' . $archivos[$i]->getClientOriginalName();
                $archivos[$i]->storeAs('public/Evaluaciones/Archivos', $nombre);

                $evaluacionArchivo = new Archivo();
                $evaluacionArchivo->nombre = $request['nombre'][$i];
                $evaluacionArchivo->archivo = $nombre;
                $evaluacionArchivo->visibilidad = $request['visibilidad'][$i];
                $evaluacionArchivo->evaluacion()->associate($evaluacion_id);
                $evaluacionArchivo->save();
            }

            return redirect(route('evaluaciones.show', [$institucion_id, $division_id, $evaluacion_id]))
                ->with(['successMessage' => 'Archivos cargados con éxito!']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function edit($institucion_id, $division_id, $evaluacion_id, $id)
    {
        return Inertia::render('Evaluaciones/Archivos/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'evaluacion' => $this->evaluacionService->find($evaluacion_id),
            'archivo' => Archivo::findOrFail($id),
        ]);
    }

    public function update(UpdateEvaluacionArchivo $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        Archivo::where('id', $id)
            ->update([
            'nombre' => $request->nombre,
            'visibilidad'  => $request->visibilidad,
        ]);

        return redirect(route('evaluaciones.show', [$institucion_id, $division_id, $evaluacion_id]))
            ->with(['successMessage' => 'Archivo actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $id)
    {
        $evaluacionArchivo = Archivo::findOrFail($id);
        Storage::delete('public/Evaluaciones/Archivos/' . $evaluacionArchivo->archivo);

        Archivo::destroy($id);
        return redirect(route('evaluaciones.show', [$institucion_id, $division_id, $evaluacion_id]))
            ->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
