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
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/Evaluaciones/Entregas', $archivo->getClientOriginalName());

            $d = new DateTime('now');
            $d->setTimezone(new DateTimeZone('America/Argentina/Buenos_Aires'));
            $fechaHoraEntrega = $d->format('Y-m-d H:i:s');

            EntregaArchivo::create([
                'entrega_id' => $entrega_id,
                'archivo' => $archivoStore,
                'fechaHoraEntrega' => $fechaHoraEntrega,
            ]);

            return back()->with(['successMessage' => 'Archivo cargado con exito! Apriete en el boton "Eliminar" para cargar otro archivo.']);
        }

        return back()->withErrors('No hay ningun archivo');
    }

    public function destroy($institucion_id, $division_id, $evaluacion_id, $entrega_id, $id)
    {
        EntregaArchivo::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con exito!']);
    }
}
