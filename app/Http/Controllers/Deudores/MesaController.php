<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreMesa;
use App\Jobs\Deudores\MesaDestroyJob;
use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use App\Models\Materiales\Grupo;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class MesaController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $asignaturaRepository;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        DivisionRepository $divisionRepository, 
        AsignaturaRepository $asignaturaRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('index', 'show');
        $this->middleware('divisionCorrespondiente')->except('index', 'show');
        $this->middleware('mesaCorrespondiente')->except('index', 'create', 'store');

        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
    }

    public function index($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Deudores/Mesas/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'asignatura' => $this->asignaturaRepository->find($asignatura_id),
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
            'division' => $this->divisionRepository->find($division_id),
            'asignatura' => $this->asignaturaRepository->find($asignatura_id),
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
        $puedeAnotarse = false;
        $inscripcion_id = null;

        if (session('tipo') == 'Alumno') {
            if (!(Inscripcion::where('alumno_id', session('tipo_id'))->where('mesa_id', $id)->exists())) {
                $puedeAnotarse = true;
            }
            else {
                $inscripcion = Inscripcion::select('id')->where('alumno_id', session('tipo_id'))->where('mesa_id', $id)->first();
                $inscripcion_id = $inscripcion->id;
            }
        }

        return Inertia::render('Deudores/Mesas/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'asignatura' => $this->asignaturaRepository->find($asignatura_id),
            'mesa_id' => $id,
            'mesa' => [
                'id' => $mesa->id,
                'asignatura' => $mesa->asignatura,
                'fechaHoraRealizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                'fechaHoraFinalizacion' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
                'comentario'  => $mesa->comentario,
            ],
            'inscripciones' => Inscripcion::where('mesa_id', $id)->with('alumno', 'alumno.user')->paginate(10),
            'archivos' => MesaArchivo::where('mesa_id', $id)->get(),
            'puedeAnotarse' => $puedeAnotarse,
            'inscripcion_id' => $inscripcion_id,
        ]);
    }

    public function edit($institucion_id, $division_id, $asignatura_id, $id)
    {
        $mesa = Mesa::findOrFail($id);

        return Inertia::render('Deudores/Mesas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignatura' => $this->asignaturaRepository->find($asignatura_id),
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
        $mesa = Mesa::findOrFail($id);
        $mesa->fechaHoraRealizacion = $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraRealizacion);
        $mesa->fechaHoraFinalizacion = $this->formatoService->cambiarFormatoParaGuardar($request->fechaHoraFinalizacion);
        $mesa->comentario = $request->comentario;
        $mesa->save();

        return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $id]))
            ->with(['successMessage' => 'Mesa actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        MesaDestroyJob::dispatch($id);

        return redirect(route('mesas.index', [$institucion_id, $division_id, $asignatura_id]))
            ->with(['successMessage' => 'Mesa eliminada con éxito!']);
    }
}
