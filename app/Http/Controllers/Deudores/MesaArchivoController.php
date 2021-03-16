<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreMesaArchivo;
use App\Http\Requests\Deudores\UpdateArchivo;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MesaArchivoController extends Controller
{
    protected $formatoService;
    protected $obtenerFechaHoraService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        ObtenerFechaHoraService $obtenerFechaHoraService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('mesaCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes');
        $this->middleware('mesaArchivoCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
    }

    public function create($institucion_id, $division_id, $asignatura_id, $mesa_id)
    {
        $mesa = Mesa::select('id', 'fechaHoraRealizacion', 'fechaHoraFinalizacion')->with('asignatura')->findOrFail($mesa_id);

        return Inertia::render('Deudores/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division_id' => $division_id,
            'asignatura_id' => $asignatura_id,
            'mesa' => [
                'id' => $mesa->id,
                'asignatura' => $mesa->asignatura,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
                'comentario'  => $mesa->comentario,
            ],
        ]);
    }

    public function store(StoreMesaArchivo $request, $institucion_id, $division_id, $asignatura_id, $mesa_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            for ($i=0; $i < count($archivos); $i++) { 
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $unique = substr(base64_encode(mt_rand()), 0, 15);
                $nombre = $fechaHora . '-' . $unique . '-' . $archivos[$i]->getClientOriginalName();
                $archivos[$i]->storeAs('Mesas/Archivos', $nombre, 's3');

                $mesaArchivo = new MesaArchivo();
                $mesaArchivo->archivo = $nombre;
                $mesaArchivo->visibilidad = $request['visibilidad'][$i];
                $mesaArchivo->mesa()->associate($mesa_id);
                $mesaArchivo->save();
            }

            return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
                ->with(['successMessage' => 'Archivos subidos con éxito!']);
        }
        return back()->withErrors('No hay ningún archivo seleccionado');
    }

    public function edit($institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $mesa = Mesa::select('id', 'fechaHoraRealizacion', 'fechaHoraFinalizacion')->with('asignatura')->findOrFail($mesa_id);

        return Inertia::render('Deudores/Archivos/Edit', [
            'institucion_id' => $institucion_id,
            'division_id' => $division_id,
            'asignatura_id' => $asignatura_id,
            'mesa' => [
                'id' => $mesa->id,
                'asignatura' => $mesa->asignatura,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
                'comentario'  => $mesa->comentario,
            ],
            'archivo' => MesaArchivo::findOrFail($id),
        ]);
    }

    public function update(UpdateArchivo $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        MesaArchivo::where('id', $id)
            ->update([
            'visibilidad'  => $request->visibilidad,
        ]);

        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
            ->with(['successMessage' => 'Archivo actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $id)
    {
        $mesaArchivo = MesaArchivo::findOrFail($id);
        Storage::disk('s3')->delete('Mesas/Archivos/' . $mesaArchivo->archivo);

        MesaArchivo::destroy($id);
        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
            ->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
