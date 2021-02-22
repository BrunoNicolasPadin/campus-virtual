<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacionArchivo;
use App\Http\Requests\Evaluaciones\UpdateEvaluacionArchivo;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Archivo;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Archivos\ObtenerFechaHoraService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EvaluacionArchivoController extends Controller
{
    protected $obtenerFechaHoraService;

    public function __construct(ObtenerFechaHoraService $obtenerFechaHoraService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloDocentes')->except('destroy');
        $this->middleware('soloInstitucionesDirectivosDocentes')->only('destroy');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('archivoCorrespondiente')->only('edit', 'update', 'destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
    }

    public function create($institucion_id, $division_id, $evaluacion_id)
    {
        return Inertia::render('Evaluaciones/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
        ]);
    }

    public function store(StoreEvaluacionArchivo $request, $institucion_id, $division_id, $evaluacion_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');
            $i = 0;

            foreach ($archivos as $archivo) {
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $nombre = $fechaHora . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Evaluaciones/Archivos', $nombre);

                Archivo::create([
                    'evaluacion_id' => $evaluacion_id,
                    'nombre' => $request['nombre'][$i],
                    'archivo' => $nombre,
                    'visibilidad'  => $request['visibilidad'][$i],
                ]);
                $i++;
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
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'archivo' => Archivo::find($id),
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
