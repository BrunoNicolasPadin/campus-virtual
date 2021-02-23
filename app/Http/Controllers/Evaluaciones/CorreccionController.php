<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Correccion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Services\Archivos\ObtenerFechaHoraService;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CorreccionController extends Controller
{
    protected $obtenerFechaHoraService;

    public function __construct(ObtenerFechaHoraService $obtenerFechaHoraService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('entregaCorrespondiente');
        $this->middleware('soloDocentes')->except('destroy');
        $this->middleware('soloInstitucionesDirectivosDocentes')->only('destroy');
        $this->middleware('correccionCorrespondiente')->only('destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
    }

    public function create($institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        return Inertia::render('Evaluaciones/Correcciones/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'evaluacion' => Evaluacion::findOrFail($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->findOrFail($entrega_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            foreach ($archivos as $archivo) {
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $nombre = $fechaHora . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Evaluaciones/Correcciones', $nombre);

                Correccion::create([
                    'entrega_id' => $entrega_id,
                    'archivo' => $nombre,
                ]);
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
