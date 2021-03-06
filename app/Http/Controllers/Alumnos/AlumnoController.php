<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreAlumno;
use App\Http\Requests\Roles\StoreDirectivo;
use App\Jobs\Alumnos\AlumnoDestroyJob;
use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use App\Repositories\Alumnos\AlumnoRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\ClaveDeAcceso\VerificarDivision;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlumnoController extends Controller
{
    protected $claveDeAccesoService;
    protected $claveInstitucion;
    protected $divisionRepository;
    protected $alumnoRepository;

    public function __construct(
        VerificarDivision $claveDeAccesoService,
        VerificarInstitucion $claveInstitucion,
        DivisionRepository $divisionRepository,
        AlumnoRepository $alumnoRepository
    )

    {
        $this->middleware('auth');
        $this->middleware('soloInstitucionesDirectivos')->only('index');
        $this->middleware('alumnoYaCreado')->only('verificarClave', 'create', 'store');
        $this->middleware('institucionCorrespondiente')->except('verificarClave', 'create', 'store');
        $this->middleware('soloInstitucionesDirectivosAlumnos')->only('show', 'edit', 'update', 'destroy');
        $this->middleware('alumnoCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->claveDeAccesoService = $claveDeAccesoService;
        $this->claveInstitucion = $claveInstitucion;
        $this->divisionRepository = $divisionRepository;
        $this->alumnoRepository = $alumnoRepository;
    }

    public function index($institucion_id, Request $request)
    {
        return Inertia::render('Alumnos/Index', [
            'institucion_id' => $institucion_id,
            'alumnos' => Alumno::select('alumnos.id', 'users.name', 'users.profile_photo_path')
                ->where('institucion_id', $institucion_id)
                ->where('alumnos.exAlumno', '0')
                ->where('alumnos.eliminado', '0')
                ->join('users', 'users.id', 'alumnos.user_id')
                ->when($request->nombre, function($query, $nombre) {
                    $query->where('users.name', 'LIKE', '%'.$nombre.'%');
                })
                ->orderBy('users.name')
                ->paginate(20)
                ->transform(function ($alumno) {
                    return [
                        'id' => $alumno->id,
                        'name'  => $alumno->name,
                        'foto' => $alumno->profile_photo_path,
                    ];
                }),
            'nombreProp' => $request->nombre,
        ]);
    }

    public function verificarClave($institucion_id, StoreDirectivo $request)
    {
        if ($this->claveInstitucion->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {
            return redirect(route('alumnos.create', $institucion_id));
        }
        return redirect(route('roles.anotarse', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function create($institucion_id)
    {
        return Inertia::render('Alumnos/Create', [
            'institucion_id' => $institucion_id,
            'divisiones' => $this->divisionRepository->get($institucion_id),
        ]);
    }

    public function store(StoreAlumno $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $request->division_id)) {

            $alumno = new Alumno();
            $alumno->activado = 0;
            $alumno->exAlumno = 0;
            /* $alumno->eliminado = 0; */
            $alumno->user()->associate(Auth::id());
            $alumno->institucion()->associate($institucion_id);
            $alumno->division()->associate($request->division_id);
            $alumno->save();

            return redirect(route('roles.mostrarCuentas'))
                ->with(['successMessage' => 'Te registraste exitosamente como alumno, ahora activa tu cuenta.']);
        }
        return redirect(route('alumnos.create', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        $alumno = Alumno::select('alumnos.id', 'alumnos.exAlumno', 'divisiones.id AS division_id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
        'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre', 'users.name')
            ->where('alumnos.id', $id)
            ->leftjoin('divisiones', 'alumnos.division_id', 'divisiones.id')
            ->leftjoin('niveles', 'niveles.id', 'divisiones.nivel_id')
            ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
            ->leftjoin('cursos', 'cursos.id', 'divisiones.curso_id')
            ->join('users', 'users.id', 'alumnos.user_id')
            ->first();

        $padres = Padre::where('alumno_id', $alumno->id)
            ->with(array(
                'user' => function($query){
                    $query->select('id', 'name');
                },
            ))
            ->get();

        return Inertia::render('Alumnos/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'alumno' => $alumno,
            'padres' => $padres,
        ]);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Alumnos/Edit', [
            'institucion_id' => $institucion_id,
            'divisiones' => $this->divisionRepository->get($institucion_id),
            'alumno' => $this->alumnoRepository->find($id),
        ]);
    }

    public function update(StoreAlumno $request, $institucion_id, $id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $request->division_id)) {
            $alumno = Alumno::findOrFail($id);
            $alumno->division_id = $request->division_id;
            $alumno->exAlumno = '0';
            $alumno->save();

            if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
                session(['division_id' => $request->division_id]);
            }

            return redirect(route('divisiones.show', [$institucion_id, $request->division_id]))
                ->with(['successMessage' => 'Cambio de división exitoso.']);
        }
        return back()->withErrors('Clave de acceso incorrecta.');
    }

    public function destroy($institucion_id, $id)
    {
        $message = 'Alumno eliminado con éxito!';

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            AlumnoDestroyJob::dispatch($id);
            return redirect(route('alumnos.index', $institucion_id))->with(['successMessage' => $message]);
        }

        if (session('tipo') == 'Alumno') {
            AlumnoDestroyJob::dispatch($id);
            $message = 'Te eliminaste con éxito!';
            session()->forget(['tipo', 'alumno_id', 'division_id', 'institucion_id']);
            return redirect(route('roles.mostrarCuentas'))->with(['successMessage' => $message]);
        }
        else {
            return back()->withErrors('Debe tener activado la cuenta que desea eliminar.');
        }
    }

    public function eliminacionDefinitiva($institucion_id, $id)
    {
        Alumno::destroy($id);
        return redirect(route('alumnos.index', $institucion_id))->with(['successMessage' => 'Eliminación definitiva realizada con éxito!']);
    }
}
