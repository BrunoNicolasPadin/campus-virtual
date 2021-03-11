<?php

namespace App\Http\Controllers\ExAlumnos;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExAlumnos\StoreExAlumno;
use App\Http\Requests\ExAlumnos\UpdateExAlumno;
use App\Models\Roles\ExAlumno;
use App\Models\Roles\Alumno;
use App\Repositories\Alumnos\AlumnoRepository;
use App\Repositories\CiclosLectivos\CicloLectivoRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ExAlumnoController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $cicloLectivoRepository;
    protected $alumnoRepository;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        DivisionRepository $divisionRepository,
        CicloLectivoRepository $cicloLectivoRepository,
        AlumnoRepository $alumnoRepository
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('verificarExAlumnoNuevo')->only('store');
        $this->middleware('exAlumnoCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
        $this->cicloLectivoRepository = $cicloLectivoRepository;
        $this->alumnoRepository = $alumnoRepository;
    }

    public function index($institucion_id, Request $filtros)
    {
        $exAlumnos = DB::table('ex_alumnos')
            ->select('ex_alumnos.id', 'ex_alumnos.alumno_id', 'ex_alumnos.division_id', 'ex_alumnos.abandono', 'ex_alumnos.finalizo', 'ex_alumnos.cambio', 
            'ex_alumnos.debeRendir', 'divisiones.id AS division_id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
            'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre', 'users.name', 'users.profile_photo_path',
            'ciclos_lectivos.comienzo', 'ciclos_lectivos.final')
            ->where('ex_alumnos.institucion_id', $institucion_id)
            ->leftjoin('divisiones', 'ex_alumnos.division_id', 'divisiones.id')
            ->leftjoin('niveles', 'niveles.id', 'divisiones.nivel_id')
            ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
            ->leftjoin('cursos', 'cursos.id', 'divisiones.curso_id')
            ->join('alumnos', 'alumnos.id', 'ex_alumnos.alumno_id')
            ->join('users', 'users.id', 'alumnos.user_id')
            ->join('ciclos_lectivos', 'ciclos_lectivos.id', 'ex_alumnos.ciclo_lectivo_id')
            ->when($filtros->ciclo_lectivo_id, function ($query, $ciclo_lectivo_id) {
                return $query->where('ex_alumnos.ciclo_lectivo_id', $ciclo_lectivo_id);
            })
            ->when($filtros->division_id, function ($query, $division_id) {
                return $query->where('ex_alumnos.division_id', $division_id);
            })
            ->when($filtros->condicion == 'abandono', function ($query, $abandono) {
                return $query->where('ex_alumnos.abandono', true);
            })
            ->when($filtros->condicion == 'finalizo', function ($query, $finalizo) {
                return $query->where('ex_alumnos.finalizo', true);
            })
            ->when($filtros->condicion == 'cambio', function ($query, $cambio) {
                return $query->where('ex_alumnos.cambio', true);
            })
            ->when($filtros->condicion == 'debeRendir', function ($query, $cambio) {
                return $query->where('ex_alumnos.debeRendir', true);
            })
            ->orderBy('users.name')
            ->paginate(10)
            ->withQueryString()
            ->through(function ($exalumno) {
                return [
                    'id' => $exalumno->id,
                    'alumno_id' => $exalumno->alumno_id,
                    'division_id' => $exalumno->division_id,
                    'name' => $exalumno->name,
                    'fotoDePerfil' => $exalumno->profile_photo_path,
                    'division' => $exalumno->nivel_nombre . ' - ' . $exalumno->orientacion_nombre . ' - ' . $exalumno->curso_nombre . ' - ' . $exalumno->division,
                    'ciclo_lectivo' => $this->formatoService->cambiarFormatoParaMostrar($exalumno->comienzo) . ' - ' . $this->formatoService->cambiarFormatoParaMostrar($exalumno->final),
                    'abandono' => $exalumno->abandono,
                    'cambio' => $exalumno->cambio,
                    'finalizo' => $exalumno->finalizo,
                    'debeRendir' => $exalumno->debeRendir,
                ];
            });
        return Inertia::render('ExAlumnos/Index', [
            'institucion_id' => $institucion_id,
            'exAlumnos' => $exAlumnos,
            'divisiones' => $this->divisionRepository->get($institucion_id),
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
            'ciclo_lectivo_id_index' => $filtros->ciclo_lectivo_id,
            'division_id_index' => $filtros->division_id,
            'condicion_index' => $filtros->condicion,
        ]);
    }

    public function createExAlumno($institucion_id, $alumno_id)
    {
        return Inertia::render('ExAlumnos/Create', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
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
        $exAlumno->debeRendir = $request->debeRendir;
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
        $exAlumno = ExAlumno::select('id', 'alumno_id', 'ciclo_lectivo_id', 'comentario', 'abandono', 'finalizo', 'cambio', 'debeRendir')
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
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
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
            'debeRendir' => $request->debeRendir,
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
