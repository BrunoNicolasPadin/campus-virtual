<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreMesa;
use App\Models\Asignaturas\Asignatura;
use App\Models\Deudores\Anotado;
use App\Models\Deudores\Mesa;
use App\Models\Estructuras\Division;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class MesaController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');

        $this->formatoService = $formatoService;
    }

    public function create($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Deudores/Mesas/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
        ]);
    }

    public function store(StoreMesa $request, $institucion_id, $division_id, $asignatura_id)
    {
        Mesa::create([
            'asignatura_id' => $asignatura_id,
            'fechaHora' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHora),
            'comentario' => $request->comentario,
        ]);

        return redirect(route('asignaturas.show', [$institucion_id, $division_id, $asignatura_id]))
            ->with(['successMessage' => 'Mesa agregada con exito!']);
    }

    public function show($institucion_id, $division_id, $asignatura_id, $id)
    {
        $mesa = Mesa::with('asignatura')->findOrFail($id);

        return Inertia::render('Deudores/Mesas/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'asignatura' => $mesa->asignatura,
                'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHora),
                'comentario'  => $mesa->comentario,
            ],
            'anotados' => Anotado::where('mesa_id', $id)->with('alumno', 'alumno.user')->paginate(20),
        ]);
    }

    public function edit($institucion_id, $division_id, $asignatura_id, $id)
    {
        $mesa = Mesa::findOrFail($id);

        return Inertia::render('Deudores/Mesas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'asignatura' => Asignatura::findOrFail($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'fechaHora' => $this->formatoService->cambiarFormatoParaEditar($mesa->fechaHora),
                'comentario'  => $mesa->comentario,
            ],
        ]);
    }

    public function update(StoreMesa $request, $institucion_id, $division_id, $asignatura_id, $id)
    {
        Mesa::where('id', $id)
            ->update([
                'fechaHora' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHora),
                'comentario' => $request->comentario,
            ]);
        return redirect(route('asignaturas.show', [$institucion_id, $division_id, $asignatura_id]))
            ->with(['successMessage' => 'Mesa editada con exito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        Mesa::destroy($id);
        return redirect(route('asignaturas.show', [$institucion_id, $division_id, $asignatura_id]))
            ->with(['successMessage' => 'Mesa eliminada con exito!']);
    }
}
