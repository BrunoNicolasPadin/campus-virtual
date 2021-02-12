<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\EntregaArchivo;
use App\Models\Evaluaciones\Evaluacion;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EntregaArchivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('evaluacionCorrespondiente');
        $this->middleware('entregaCorrespondiente');
        $this->middleware('soloAlumnos');
        $this->middleware('entregaArchivoCorrespondiente')->only('destroy');
    }

    public function create($institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        return Inertia::render('Evaluaciones/EntregasArchivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->find($entrega_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $evaluacion_id, $entrega_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            foreach ($archivos as $archivo) {
                $fechaHora = new DateTime(null, new DateTimeZone('America/Argentina/Buenos_Aires'));
                $fechaHora->setTimestamp($fechaHora->getTimestamp());
                $fechaHora = $fechaHora->format('d-m-Y H:i:s');

                $nombre = $fechaHora . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Evaluaciones/Entregas', $nombre);

                EntregaArchivo::create([
                    'entrega_id' => $entrega_id,
                    'archivo' => $nombre,
                ]);
            }

            return redirect(route('entregas.show', [$institucion_id, $division_id, $evaluacion_id, $entrega_id]))
                ->with(['successMessage' => 'Archivos cargados con exito!']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $entrega_id, $id)
    {
        $entrega = EntregaArchivo::findOrFail($id);
        Storage::delete('public/Evaluaciones/Entregas/' . $entrega->archivo);

        EntregaArchivo::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con exito!']);
    }
}
