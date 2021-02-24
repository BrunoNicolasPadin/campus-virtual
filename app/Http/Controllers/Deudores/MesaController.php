<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreMesa;
use App\Models\Deudores\Anotado;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use App\Services\Archivos\EliminarMesas;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class MesaController extends Controller
{
    protected $formatoService;
    protected $mesasService;
    protected $divisionService;
    protected $asignaturaService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        EliminarMesas $mesasService,
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('show');
        $this->middleware('divisionCorrespondiente')->except('show');
        $this->middleware('mesaCorrespondiente')->except('create', 'store');

        $this->formatoService = $formatoService;
        $this->mesasService = $mesasService;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
    }

    public function create($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Deudores/Mesas/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
        ]);
    }

    public function store(StoreMesa $request, $institucion_id, $division_id, $asignatura_id)
    {
        Mesa::create([
            'institucion_id' => $institucion_id,
            'asignatura_id' => $asignatura_id,
            'fechaHora' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHora),
            'comentario' => $request->comentario,
        ]);

        return redirect(route('asignaturas.show', [$institucion_id, $division_id, $asignatura_id]))
            ->with(['successMessage' => 'Mesa agregada con éxito!']);
    }

    public function show($institucion_id, $division_id, $asignatura_id, $id)
    {
        $mesa = Mesa::with('asignatura')->findOrFail($id);

        return Inertia::render('Deudores/Mesas/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
            'mesa' => [
                'id' => $mesa->id,
                'asignatura' => $mesa->asignatura,
                'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHora),
                'comentario'  => $mesa->comentario,
            ],
            'anotados' => Anotado::where('mesa_id', $id)->with('alumno', 'alumno.user')->paginate(20),
            'archivos' => MesaArchivo::where('mesa_id', $id)->get(),
        ]);
    }

    public function edit($institucion_id, $division_id, $asignatura_id, $id)
    {
        $mesa = Mesa::findOrFail($id);

        return Inertia::render('Deudores/Mesas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
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
        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $id]))
            ->with(['successMessage' => 'Mesa actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        $this->mesasService->eliminarMesas($id);

        Mesa::destroy($id);
        return redirect(route('asignaturas.show', [$institucion_id, $division_id, $asignatura_id]))
            ->with(['successMessage' => 'Mesa eliminada con éxito!']);
    }
}
