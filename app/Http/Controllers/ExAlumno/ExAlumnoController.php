<?php

namespace App\Http\Controllers\ExAlumno;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExAlumnos\StoreExAlumno;
use App\Http\Requests\ExAlumnos\UpdateExAlumno;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Roles\ExAlumno;
use App\Models\Roles\Alumno;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class ExAlumnoController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('verificarExAlumnoNuevo')->only('store');
        $this->middleware('exAlumnoCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
    }
    public function index($institucion_id)
    {
        return Inertia::render('ExAlumnos/Index', [
            'institucion_id' => $institucion_id,
            'exalumnos' => ExAlumno::where('institucion_id', $institucion_id)
                ->with('alumno', 'alumno.user')
                ->paginate(20)
        ]);
    }

    public function createExAlumno($institucion_id, $alumno_id)
    {
        return Inertia::render('ExAlumnos/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->findOrFail($alumno_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
            ->orderBy('comienzo')
            ->get()
            ->map(function ($ciclo) {
                return [
                    'id' => $ciclo->id,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                ];
            }),
        ]);
    }

    public function store(StoreExAlumno $request, $institucion_id)
    {
        Alumno::where('id', $request->alumno_id)
            ->update([
                'division_id' => null,
                'exAlumno' => '1',
            ]);

        ExAlumno::create([
            'alumno_id' => $request->alumno_id,
            'institucion_id' => $institucion_id,
            'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
            'division_id' => $request->division_id,
            'abandono' => $request->abandono,
            'comentario' => $request->comentario,
        ]);

        return redirect(route('exalumnos.index', $institucion_id))
            ->with(['successMessage' => 'Ex alumno agregado con exito!']);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('ExAlumnos/Edit', [
            'institucion_id' => $institucion_id,
            'exalumno' => ExAlumno::with('alumno', 'alumno.user')->findOrFail($id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
            ->orderBy('comienzo')
            ->get()
            ->map(function ($ciclo) {
                return [
                    'id' => $ciclo->id,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                ];
            }),
        ]);
    }

    public function update(UpdateExAlumno $request, $institucion_id, $id)
    {
        ExAlumno::where('id', $id)
        ->update([
            'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
            'abandono' => $request->abandono,
            'comentario' => $request->comentario,
        ]);

        return redirect(route('exalumnos.index', $institucion_id))
            ->with(['successMessage' => 'Ex alumno actualizado con exito!']);
    }

    public function destroy($institucion_id, $id)
    {
        $exAlumno = ExAlumno::findOrFail($id);
        $alumno = Alumno::findOrFail($exAlumno->alumno_id);

        ExAlumno::destroy($id);

        $alumno->exAlumno = '0';
        $alumno->save();

        return back()->with(['successMessage' => 'Ex alumno eliminado con exito!']);

    }
}
