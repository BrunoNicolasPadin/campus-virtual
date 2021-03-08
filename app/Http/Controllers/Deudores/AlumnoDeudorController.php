<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreAlumnoDeudor;
use App\Models\Deudores\AlumnoDeudor;
use App\Models\Deudores\Mesa;
use App\Repositories\Alumnos\AlumnoRepository;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\CiclosLectivos\CicloLectivoRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class AlumnoDeudorController extends Controller
{
    protected $formatoService;
    protected $formatoFechaHoraService;
    protected $divisionRepository;
    protected $asignaturaRepository;
    protected $cicloLectivoRepository;
    protected $alumnoRepository;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        CambiarFormatoFechaHora $formatoFechaHoraService,
        DivisionRepository $divisionRepository, 
        AsignaturaRepository $asignaturaRepository,
        CicloLectivoRepository $cicloLectivoRepository,
        AlumnoRepository $alumnoRepository
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('alumnoCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->except('index', 'show');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('show');
        $this->middleware('deudaCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->formatoFechaHoraService = $formatoFechaHoraService;
        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
        $this->cicloLectivoRepository = $cicloLectivoRepository;
        $this->alumnoRepository = $alumnoRepository;
    }

    public function index($institucion_id, $alumno_id)
    {
        return Inertia::render('Deudores/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'deudas' => AlumnoDeudor::where('alumno_id', $alumno_id)
                ->with(['asignatura', 'ciclo_lectivo'])
                ->orderBy('ciclo_lectivo_id')
                ->paginate(10)
                ->transform(function ($deuda) {
                    return [
                        'id' => $deuda->id,
                        'alumno_id' => $deuda->alumno_id,
                        'asignatura_id' => $deuda->asignatura_id,
                        'asignatura' => $deuda->asignatura,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($deuda->ciclo_lectivo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($deuda->ciclo_lectivo->final),
                        'aprobado' => $deuda->aprobado,
                    ];
                }),
        ]);
    }

    public function create($institucion_id, $alumno_id)
    {
        return Inertia::render('Deudores/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'divisiones' => $this->divisionRepository->get($institucion_id),
        ]);
    }

    public function createAsignatura($institucion_id, $alumno_id, $division_id)
    {
        $asignaturas = $this->asignaturaRepository->get($division_id);
        $asignaturasYaAdeudadas = AlumnoDeudor::select('asignatura_id')->where('alumno_id', $alumno_id)->get();
        
        foreach ($asignaturasYaAdeudadas as $asignaturaYaAdeudada) {
            $key = $asignaturas->search(function($item) use ($asignaturaYaAdeudada) {
                return $item->id == $asignaturaYaAdeudada->asignatura_id;
            });
            $asignaturas->pull($key);
        }

        return Inertia::render('Deudores/CreateAsignatura', [
            'institucion_id' => $institucion_id,
            'division_id_seleccionada' => $division_id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'divisiones' => $this->divisionRepository->get($institucion_id),
            'asignaturas'  => $asignaturas,
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function store(StoreAlumnoDeudor $request, $institucion_id, $alumno_id)
    {
        for ($i=0; $i < count($request->asignatura_id); $i++) { 

            $deudor = new AlumnoDeudor();
            $deudor->aprobado = '0';
            $deudor->alumno()->associate($alumno_id);
            $deudor->asignatura()->associate($request->asignatura_id[$i]);
            $deudor->ciclo_lectivo()->associate($request->ciclo_lectivo_id);
            $deudor->save();
        }

        return redirect(route('asignaturas-adeudadas.index', [$institucion_id, $alumno_id]))
            ->with((['successMessage' => 'Asignaturas adeudadas agregadas con éxito!']));
        
    }

    public function show($institucion_id, $alumno_id, $id)
    {
        $deuda = AlumnoDeudor::select('asignatura_id')->findOrFail($id);
        $mesas = Mesa::where('asignatura_id', $deuda->asignatura_id)->with('inscripciones', 'asignatura')
            ->whereHas('inscripciones', function($q) use($alumno_id)
            {
                $q->where('alumno_id', $alumno_id);
            })
            ->paginate(10)
            ->transform(function ($mesa) use($alumno_id) {
                return [
                    'id' => $mesa->id,
                    'asignatura_id' => $mesa->asignatura_id,
                    'asignatura' => $mesa->asignatura->only('nombre', 'division_id'),
                    'fechaHoraRealizacion' => $this->formatoFechaHoraService->cambiarFormatoParaMostrar($mesa->fechaHoraRealizacion),
                    'fechaHoraFinalizacion' => $this->formatoFechaHoraService->cambiarFormatoParaMostrar($mesa->fechaHoraFinalizacion),
                    'inscripcion' => $mesa->inscripciones->where('alumno_id', $alumno_id),
                ];
        });

        return Inertia::render('Deudores/Show', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'mesas' => $mesas,
            'asignatura'  => $this->asignaturaRepository->find($deuda->asignatura_id),
        ]); 
    }

    public function edit($institucion_id, $alumno_id, $id)
    {
        return Inertia::render('Deudores/Edit', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'deuda' => AlumnoDeudor::findOrFail($id),
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function update(StoreAlumnoDeudor $request, $institucion_id, $alumno_id, $id)
    {
        AlumnoDeudor::where('id', $id)
            ->update([
                'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
                'aprobado' => $request->aprobado,
            ]);
        return redirect(route('asignaturas-adeudadas.index', [$institucion_id, $alumno_id]))
            ->with((['successMessage' => 'Asignatura adeudada editada con éxito!']));
    }

    public function destroy($institucion_id, $alumno_id, $id)
    {
        AlumnoDeudor::destroy($id);
        return redirect(route('asignaturas-adeudadas.index', [$institucion_id, $alumno_id]))
            ->with((['successMessage' => 'Asignatura adeudada eliminada con éxito!']));
    }
}
