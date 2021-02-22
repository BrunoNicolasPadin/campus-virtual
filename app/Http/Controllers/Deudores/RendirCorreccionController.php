<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Asignaturas\Asignatura;
use App\Models\Deudores\Anotado;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\RendirCorreccion;
use App\Models\Estructuras\Division;
use App\Services\Archivos\ObtenerFechaHoraService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RendirCorreccionController extends Controller
{
    protected $obtenerFechaHoraService;

    public function __construct(ObtenerFechaHoraService $obtenerFechaHoraService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('mesaCorrespondiente');
        $this->middleware('inscripcionCorrespondiente');
        $this->middleware('soloDocentes')->except('destroy');
        $this->middleware('soloInstitucionesDirectivosDocentes')->only('destroy');
        $this->middleware('rendirCorreccionCorrespondiente')->only('destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
    }

    public function create($institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id)
    {
        return Inertia::render('Deudores/Correcciones/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'mesa' => Mesa::findOrFail($mesa_id),
            'anotado' => Anotado::with(['alumno', 'alumno.user'])->findOrFail($anotado_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            foreach ($archivos as $archivo) {
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $nombre = $fechaHora . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Deudores/Correcciones', $nombre);

                RendirCorreccion::create([
                    'anotado_id' => $anotado_id,
                    'archivo' => $nombre,
                ]);
            }

            return redirect(route('anotados.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id]))
                ->with(['successMessage' => 'Tus correcciones han sido subidas con éxito!']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $mesa_id, $anotado_id, $id)
    {
        $correccion = RendirCorreccion::findOrFail($id);
        Storage::delete('public/Deudores/Correcciones/' . $correccion->archivo);

        RendirCorreccion::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
