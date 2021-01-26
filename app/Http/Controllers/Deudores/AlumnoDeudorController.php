<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreAlumnoDeudor;
use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Deudores\AlumnoDeudor;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class AlumnoDeudorController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('alumnoCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->only('edit', 'update', 'destroy');
        $this->middleware('asignaturaAdeudadaCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $alumno_id)
    {
        return Inertia::render('Deudores/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'alumno' => Alumno::with('user')->findOrFail($alumno_id),
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
                    ];
                }),
        ]);
    }

    public function create($institucion_id, $alumno_id)
    {
        return Inertia::render('Deudores/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->findOrFail($alumno_id),
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
            'alumno' => Alumno::with('user')->findOrFail($alumno_id),
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
            ]);
        }

        return redirect(route('asignaturas-adeudadas.index', [$institucion_id, $alumno_id]))
            ->with((['successMessage' => 'Asignaturas adeudadas agregadas con exito!']));
        
    }

    public function show($institucion_id, $alumno_id, $id)
    {
        //
    }

    public function edit($institucion_id, $alumno_id, $id)
    {
        return Inertia::render('Deudores/Edit', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->findOrFail($alumno_id),
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
            ]);
        return redirect(route('asignaturas-adeudadas.index', [$institucion_id, $alumno_id]))
            ->with((['successMessage' => 'Asignatura editada con exito!']));
    }

    public function destroy($institucion_id, $alumno_id, $id)
    {
        AlumnoDeudor::destroy($id);
        return redirect(route('asignaturas-adeudadas.index', [$institucion_id, $alumno_id]))
            ->with((['successMessage' => 'Asignatura adeudada eliminada con exito!']));
    }
}
