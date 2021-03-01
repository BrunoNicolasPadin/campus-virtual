<?php

namespace App\Http\Controllers\ExAlumnos;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExAlumnos\StoreExAlumno;
use App\Http\Requests\ExAlumnos\UpdateExAlumno;
use App\Models\Roles\ExAlumno;
use App\Models\Roles\Alumno;
use App\Services\Alumnos\AlumnoService;
use App\Services\CiclosLectivos\CicloLectivoService;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExAlumnoController extends Controller
{
    protected $formatoService;
    protected $divisionService;
    protected $cicloLectivoService;
    protected $alumnoService;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        DivisionService $divisionService,
        CicloLectivoService $cicloLectivoService,
        AlumnoService $alumnoService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('verificarExAlumnoNuevo')->only('store');
        $this->middleware('exAlumnoCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
        $this->cicloLectivoService = $cicloLectivoService;
        $this->alumnoService = $alumnoService;
    }

    public function index($institucion_id)
    {
        $exAlumnos = ExAlumno::select('id', 'alumno_id', 'ciclo_lectivo_id', 'division_id', 'abandono', 'finalizo', 'cambio')
            ->where('institucion_id', $institucion_id)
            ->with(array(
                'alumno' => function($query){
                    $query->select('id', 'user_id');
                },
                'alumno.user' => function($query){
                    $query->select('id', 'name', 'profile_photo_path');
                },
                'division' => function($query){
                    $query->select('id', 'nivel_id', 'orientacion_id', 'curso_id', 'division');
                },
                'division.nivel' => function($query){
                    $query->select('id', 'nombre');
                },
                'division.orientacion' => function($query){
                    $query->select('id', 'nombre');
                },
                'division.curso' => function($query){
                    $query->select('id', 'nombre');
                },
                'ciclo_lectivo' => function($query){
                    $query->select('id', 'comienzo', 'final');
                },
            ))
            ->orderBy('ciclo_lectivo_id')
            ->paginate(1000)
            ->transform(function ($exalumno) {
                return [
                    'id' => $exalumno->id,
                    'alumno_id' => $exalumno->alumno_id,
                    'division_id' => $exalumno->division_id,
                    'name' => $exalumno->alumno->user->name,
                    'fotoDePerfil' => $exalumno->alumno->user->profile_photo_path,
                    'division' => $exalumno->division,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($exalumno->ciclo_lectivo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($exalumno->ciclo_lectivo->final),
                    'abandono' => $exalumno->abandono,
                    'cambio' => $exalumno->cambio,
                    'finalizo' => $exalumno->finalizo,
                ];
            });
        return Inertia::render('ExAlumnos/Index', [
            'institucion_id' => $institucion_id,
            'exAlumnos' => $exAlumnos,
            'divisiones' => $this->divisionService->get($institucion_id),
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function filtrarExAlumnos($institucion_id, Request $filtros)
    {
        return ExAlumno::select('id', 'alumno_id', 'ciclo_lectivo_id', 'division_id', 'abandono', 'finalizo', 'cambio')
            ->where('institucion_id', $institucion_id)
            ->when($filtros->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
                return $query->where('ciclo_lectivo_id', $ciclo_lectivo_id);
            })
            ->when($filtros->division_id, function ($query, $division_id) {
                return $query->where('division_id', $division_id);
            })
            ->when($filtros->condicion == 'abandono', function ($query, $abandono) {
                return $query->where('abandono', true);
            })
            ->when($filtros->condicion == 'finalizo', function ($query, $finalizo) {
                return $query->where('finalizo', true);
            })
            ->when($filtros->condicion == 'cambio', function ($query, $cambio) {
                return $query->where('cambio', true);
            })
            ->with(array(
                'alumno' => function($query){
                    $query->select('id', 'user_id');
                },
                'alumno.user' => function($query){
                    $query->select('id', 'name', 'profile_photo_path');
                },
                'division' => function($query){
                    $query->select('id', 'nivel_id', 'orientacion_id', 'curso_id', 'division');
                },
                'division.nivel' => function($query){
                    $query->select('id', 'nombre');
                },
                'division.orientacion' => function($query){
                    $query->select('id', 'nombre');
                },
                'division.curso' => function($query){
                    $query->select('id', 'nombre');
                },
                'ciclo_lectivo' => function($query){
                    $query->select('id', 'comienzo', 'final');
                },
            ))
            ->orderBy('ciclo_lectivo_id')
            ->paginate(1000)
            ->transform(function ($exalumno) {
                return [
                    'id' => $exalumno->id,
                    'alumno_id' => $exalumno->alumno_id,
                    'division_id' => $exalumno->division_id,
                    'name' => $exalumno->alumno->user->name,
                    'fotoDePerfil' => $exalumno->alumno->user->profile_photo_path,
                    'division' => $exalumno->division,
                    'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($exalumno->ciclo_lectivo->comienzo),
                    'final' => $this->formatoService->cambiarFormatoParaMostrar($exalumno->ciclo_lectivo->final),
                    'abandono' => $exalumno->abandono,
                    'cambio' => $exalumno->cambio,
                    'finalizo' => $exalumno->finalizo,
                ];
            });
    }

    public function createExAlumno($institucion_id, $alumno_id)
    {
        return Inertia::render('ExAlumnos/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoService->find($alumno_id),
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function store(StoreExAlumno $request, $institucion_id)
    {
        Alumno::where('id', $request->alumno_id)
            ->update([
                'division_id' => null,
                'exAlumno' => '1',
            ]);

        $exAlumno = new ExAlumno();
        $exAlumno->comentario = $request->comentario;
        $exAlumno->abandono = $request->abandono;
        $exAlumno->finalizo = $request->finalizo;
        $exAlumno->cambio = $request->cambio;
        $exAlumno->institucion()->associate($institucion_id);
        $exAlumno->alumno()->associate($request->alumno_id);
        $exAlumno->division()->associate($request->division_id);
        $exAlumno->ciclo_lectivo()->associate($request->ciclo_lectivo_id);
        $exAlumno->save();

        return redirect(route('exalumnos.index', $institucion_id))
            ->with(['successMessage' => 'Ex alumno agregado con éxito!']);
    }

    public function edit($institucion_id, $id)
    {
        $exAlumno = ExAlumno::select('id', 'alumno_id', 'ciclo_lectivo_id', 'comentario', 'abandono', 'finalizo', 'cambio')
            ->where('id', $id)
            ->with(array(
                'alumno' => function($query){
                    $query->select('id', 'user_id');
                },
                'alumno.user' => function($query){
                    $query->select('id', 'name', 'profile_photo_path');
                },
            ))
            ->first();

        return Inertia::render('ExAlumnos/Edit', [
            'institucion_id' => $institucion_id,
            'exAlumno' => $exAlumno,
            'ciclosLectivos' => $this->cicloLectivoService->obtenerCiclosParaMostrar($institucion_id),
        ]);
    }

    public function update(UpdateExAlumno $request, $institucion_id, $id)
    {
        ExAlumno::where('id', $id)
        ->update([
            'ciclo_lectivo_id' => $request->ciclo_lectivo_id,
            'abandono' => $request->abandono,
            'finalizo' => $request->finalizo,
            'cambio' => $request->cambio,
            'comentario' => $request->comentario,
        ]);

        return redirect(route('exalumnos.index', $institucion_id))
            ->with(['successMessage' => 'Ex alumno actualizado con éxito!']);
    }

    public function destroy($institucion_id, $id)
    {
        $exAlumno = ExAlumno::findOrFail($id);
        $alumno = Alumno::findOrFail($exAlumno->alumno_id);

        ExAlumno::destroy($id);

        $alumno->exAlumno = '0';
        $alumno->save();

        return back()->with(['successMessage' => 'Ex alumno eliminado con éxito!']);

    }
}
