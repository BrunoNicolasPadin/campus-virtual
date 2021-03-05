<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreMesa;
use App\Models\Deudores\Anotado;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use App\Models\Materiales\Grupo;
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
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('index', 'show');
        $this->middleware('divisionCorrespondiente')->except('index', 'show');
        $this->middleware('mesaCorrespondiente')->except('index', 'create', 'store');

        $this->formatoService = $formatoService;
        $this->mesasService = $mesasService;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
    }

    public function index($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Deudores/Mesas/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
            'mesas' => Mesa::where('asignatura_id', $asignatura_id)->with('asignatura')->orderBy('fechaHoraRealizacion')->paginate(10)
                ->transform(function ($mesa) {
                    return [
                        'id' => $mesa->id,
                        'asignatura_id' => $mesa->asignatura_id,
                        'asignatura' => $mesa->asignatura,
                        'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                        'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
                        'comentario' => $mesa->comentario,
                    ];
                }),
            'grupos' => Grupo::where('asignatura_id', $asignatura_id)->orderBy('created_at')->get()
                ->map(function ($grupo) {
                    return [
                        'id' => $grupo->id,
                        'asignatura_id' => $grupo->asignatura_id,
                        'nombre' => $grupo->nombre,
                    ];
                }),
        ]);
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
        $mesa = new Mesa();
        $mesa->fechaHoraRealizacion = $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraRealizacion);
        $mesa->fechaHoraFinalizacion = $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraFinalizacion);
        $mesa->comentario = $request->comentario;
        $mesa->institucion()->associate($institucion_id);
        $mesa->asignatura()->associate($asignatura_id);
        $mesa->save();

        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa->id]))
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
            'mesa_id' => $id,
            'mesa' => [
                'id' => $mesa->id,
                'asignatura' => $mesa->asignatura,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
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
            'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
            'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
            'mesa' => [
                'id' => $mesa->id,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaEditar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaEditar($mesa->fechaHoraFinalizacion),
                'comentario'  => $mesa->comentario,
            ],
        ]);
    }

    public function update(StoreMesa $request, $institucion_id, $division_id, $asignatura_id, $id)
    {
        Mesa::where('id', $id)
            ->update([
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraFinalizacion),
                'comentario' => $request->comentario,
            ]);
        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $id]))
            ->with(['successMessage' => 'Mesa actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        $this->mesasService->eliminarMesas($id);

        Mesa::destroy($id);
        return redirect(route('mesas.index', [$institucion_id, $division_id, $asignatura_id]))
            ->with(['successMessage' => 'Mesa eliminada con éxito!']);
    }
}
