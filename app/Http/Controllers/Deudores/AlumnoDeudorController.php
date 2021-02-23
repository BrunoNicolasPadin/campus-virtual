<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreAlumnoDeudor;
use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Deudores\AlumnoDeudor;
use App\Models\Deudores\Mesa;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use App\Models\User;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class AlumnoDeudorController extends Controller
{
    protected $formatoService;
    protected $formatoFechaHoraService;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        CambiarFormatoFechaHora $formatoFechaHoraService,
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
    }

    public function index($institucion_id, $alumno_id)
    {
        return Inertia::render('Deudores/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'alumno' => Alumno::select('id')
                ->addSelect(
                    ['name' => User::select('name')
                        ->whereColumn('id', 'user_id')
                        ->limit(1)
                    ])
                ->findOrFail($alumno_id),
            'deudas' => AlumnoDeudor::where('alumno_id', $alumno_id)
                ->with(['asignatura', 'ciclo_lectivo'])
                ->orderBy('ciclo_lectivo_id')
                ->paginate(20)
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
            'alumno' => Alumno::select('id')
                ->addSelect(
                    ['name' => User::select('name')
                        ->whereColumn('id', 'user_id')
                        ->limit(1)
                    ])
                ->findOrFail($alumno_id),
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with(['nivel', 'orientacion', 'curso'])
                ->orderBy('nivel_id')
                ->orderBy('orientacion_id')
                ->orderBy('curso_id')
                ->orderBy('division')
                ->get(),
        ]);
    }

    public function createAsignatura($institucion_id, $alumno_id, $division_id)
    {
        return Inertia::render('Deudores/CreateAsignatura', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::select('id')
                ->addSelect(
                    ['name' => User::select('name')
                        ->whereColumn('id', 'user_id')
                        ->limit(1)
                    ])
                ->findOrFail($alumno_id),
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with(['nivel', 'orientacion', 'curso'])
                ->orderBy('nivel_id')
                ->orderBy('orientacion_id')
                ->orderBy('curso_id')
                ->orderBy('division')
                ->get(),
            'asignaturas' => Asignatura::where('division_id', $division_id)
                ->orderBy('nombre')
                ->get(),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
                ->orderBy('comienzo')
                ->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'institucion_id' => $ciclo->institucion_id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                        'activado' => $ciclo->activado,
                    ];
                }),
        ]);
    }

    public function store(StoreAlumnoDeudor $request, $institucion_id, $alumno_id)
    {
        for ($i=0; $i < count($request->asignatura_id); $i++) { 
            AlumnoDeudor::create([
                'alumno_id' => $alumno_id,
                'asignatura_id' => $request->asignatura_id[$i],
                'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
                'aprobado' => '0',
            ]);
        }

        return redirect(route('asignaturas-adeudadas.index', [$institucion_id, $alumno_id]))
            ->with((['successMessage' => 'Asignaturas adeudadas agregadas con éxito!']));
        
    }

    public function show($institucion_id, $alumno_id, $id)
    {
        $deuda = AlumnoDeudor::findOrFail($id);
        $mesas = Mesa::where('asignatura_id', $deuda->asignatura_id)->with('anotados', 'asignatura')
            ->whereHas('anotados', function($q) use($alumno_id)
            {
                $q->where('alumno_id', $alumno_id);
            })
            ->paginate(20)
            ->transform(function ($mesa) {
                return [
                    'id' => $mesa->id,
                    'asignatura_id' => $mesa->asignatura_id,
                    'asignatura' => $mesa->asignatura,
                    'fechaHora' => $this->formatoFechaHoraService->cambiarFormatoParaMostrar($mesa->fechaHora),
                    'comentario' => $mesa->comentario,
                ];
        });

        return Inertia::render('Deudores/Show', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::select('id')
                ->addSelect(
                    ['name' => User::select('name')
                        ->whereColumn('id', 'user_id')
                        ->limit(1)
                    ])
                ->findOrFail($alumno_id),
            'mesas' => $mesas,
            'asignatura' => Asignatura::select('id', 'nombre')->findOrFail($deuda->asignatura_id),
        ]); 
    }

    public function edit($institucion_id, $alumno_id, $id)
    {
        return Inertia::render('Deudores/Edit', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::select('id')
                ->addSelect(
                    ['name' => User::select('name')
                        ->whereColumn('id', 'user_id')
                        ->limit(1)
                    ])
                ->findOrFail($alumno_id),
            'deuda' => AlumnoDeudor::findOrFail($id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
                ->orderBy('comienzo')
                ->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'institucion_id' => $ciclo->institucion_id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                        'activado' => $ciclo->activado,
                    ];
                }),
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
