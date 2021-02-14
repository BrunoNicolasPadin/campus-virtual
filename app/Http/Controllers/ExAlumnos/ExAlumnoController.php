<?php

namespace App\Http\Controllers\ExAlumnos;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExAlumnos\StoreExAlumno;
use App\Http\Requests\ExAlumnos\UpdateExAlumno;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Roles\ExAlumno;
use App\Models\Roles\Alumno;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
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
                ->paginate(20),
            'divisiones' => Division::with(['nivel', 'orientacion', 'curso'])->where('institucion_id', $institucion_id)->get(),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                    ];
                }),
        ]);
    }

    public function filtrarExAlumnos($institucion_id, Request $filtros)
    {
        return ExAlumno::where('institucion_id', $institucion_id)
            ->when($filtros->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
                return $query->where('ciclo_lectivo_id', $ciclo_lectivo_id);
            })
            ->when($filtros->division_id, function ($query, $division_id) {
                return $query->where('division_id', $division_id);
            })
            ->when($filtros->abandono, function ($query, $abandono) {
                return $query->where('abandono', $abandono);
            })
            ->when($filtros->abandono == '0', function ($query, $abandono) {
                return $query->where('abandono', '0');
            })
            ->with(['alumno', 'alumno.user', 'division', 'division.nivel', 'division.orientacion', 'division.curso'])
            ->orderBy('ciclo_lectivo_id')
            ->paginate(20)
            ->transform(function ($exalumno) {
                return [
                    'id' => $exalumno->id,
                    'alumno_id' => $exalumno->alumno_id,
                    'division_id' => $exalumno->division_id,
                    'alumno' => $exalumno->alumno,
                    'division' => $exalumno->division,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($exalumno->ciclo_lectivo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($exalumno->ciclo_lectivo->final),
                    'abandono' => $exalumno->abandono,
                ];
            });
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
