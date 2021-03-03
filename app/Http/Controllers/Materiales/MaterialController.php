<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Evaluaciones\StoreEvaluacionArchivo;
use App\Http\Requests\Evaluaciones\UpdateEvaluacionArchivo;
use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\Division\DivisionService;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MaterialController extends Controller
{
    protected $obtenerFechaHoraService;
    protected $divisionService;

    public function __construct(
        ObtenerFechaHoraService $obtenerFechaHoraService,
        DivisionService $divisionService 
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->except('index');
        $this->middleware('soloDocentes')->except('index');
        $this->middleware('grupoCorrespondiente')->except('index');
        $this->middleware('grupoAdeudadoCorrespondiente')->only('index');
        $this->middleware('materialCorrespondiente')->only('edit', 'update', 'destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->divisionService = $divisionService;
    }

    public function index($institucion_id, $division_id, $grupo_id)
    {
        return Inertia::render('Materiales/Grupos/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'grupo' => Grupo::select('id', 'nombree')->findOrFail($grupo_id),
            'archivos' => Material::where('grupo_id', $grupo_id)->get(),
        ]);
    }

    public function create($institucion_id, $division_id, $grupo_id)
    {
        return Inertia::render('Materiales/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'grupo' => Grupo::select('id', 'nombre')->findOrFail($grupo_id),
        ]);
    }

    public function store(StoreEvaluacionArchivo $request, $institucion_id, $division_id, $grupo_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            for ($i=0; $i < count($archivos); $i++) { 
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $unique = substr(base64_encode(mt_rand()), 0, 15);
                $nombre = $fechaHora . '-' . $unique . '-' . $archivos[$i]->getClientOriginalName();
                $archivos[$i]->storeAs('public/Materiales', $nombre);

                $material = new Material();
                $material->nombre = $request['nombre'][$i];
                $material->archivo = $nombre;
                $material->visibilidad = $request['visibilidad'][$i];
                $material->grupo()->associate($grupo_id);
                $material->save();
            }

            return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
                ->with(['successMessage' => 'Archivos subidos con éxito!']);
        }

        return back()->withErrors('No hay ningún archivo seleccionado');
    }

    public function edit($institucion_id, $division_id, $grupo_id, $id)
    {
        return Inertia::render('Materiales/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'grupo' => Grupo::select('id', 'nombre')->findOrFail($grupo_id),
            'archivo' => Material::findOrFail($id),
        ]);
    }

    public function update(UpdateEvaluacionArchivo $request, $institucion_id, $division_id, $grupo_id, $id)
    {
        Material::where('id', $id)
            ->update([
            'nombre' => $request->nombre,
            'visibilidad'  => $request->visibilidad,
        ]);

        return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
            ->with(['successMessage' => 'Archivo actualizado con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $grupo_id, $id)
    {
        $material = Material::findOrFail($id);
        Storage::delete('public/Materiales/' . $material->archivo);

        Material::destroy($id);
        return redirect(route('materiales.show', [$institucion_id, $division_id, $grupo_id]))
                ->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
