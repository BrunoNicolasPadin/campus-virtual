<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Estructuras\Division;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroArchivo;
use Inertia\Inertia;

class MuroArchivoController extends Controller
{
    public function index($institucion_id, $division_id, $muro_id)
    {
        return Inertia::render('Muro/Archivos/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'publicacion' => Muro::with('user')->find($muro_id),
            'archivos' => MuroArchivo::where('muro_id', $muro_id)->orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function create($institucion_id, $division_id, $muro_id)
    {
        return Inertia::render('Muro/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'publicacion' => Muro::find($muro_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $muro_id)
    {
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $archivoStore = $archivo->getClientOriginalName();
            $archivo->storeAs('public/Muro', $archivo->getClientOriginalName());

            MuroArchivo::create([
                'muro_id' => $muro_id,
                'archivo' => $archivoStore,
            ]);

            return back()->with(['successMessage' => 'Archivo cargado con exito! Apriete en el boton "Eliminar" para cargar otro archivo.']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $muro_id, $id)
    {
        MuroArchivo::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con exito!']);
    }
}
