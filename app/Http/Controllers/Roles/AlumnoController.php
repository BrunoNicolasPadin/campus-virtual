<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreAlumno;
use App\Http\Requests\Roles\StoreDirectivo;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use App\Services\ClaveDeAcceso\VerificarDIvision;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlumnoController extends Controller
{
    protected $claveDeAccesoService;
    protected $claveInstitucion;

    public function __construct(
        VerificarDivision $claveDeAccesoService,
        VerificarInstitucion $claveInstitucion
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
    }

    public function index($institucion_id)
    {
        return Inertia::render('Alumnos/Index', [
            'institucion_id' => $institucion_id,
            'alumnos' => Alumno::where('institucion_id', $institucion_id)
                ->where('division_id', '<>', 'null')
                ->with('user', 'padres', 'padres.user')
                ->paginate(20)
                ->transform(function ($alumno) {
                    return [
                        'id' => $alumno->id,
                        'user'  => $alumno->user->only('name'),
                        'padres' => $alumno->padres,
                    ];
                }),
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
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with(['nivel', 'orientacion', 'curso'])
                ->orderBy('nivel_id')
                ->orderBy('orientacion_id')
                ->orderBy('curso_id')
                ->orderBy('division')
                ->get(),
        ]);
    }

    public function store(StoreAlumno $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $request->division_id)) {
            $alumno = Alumno::create([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
                'division_id' => $request->division_id,
                'activado' => 0,
            ]);

            session(['tipo' => 'Alumno']);
            session(['alumno_id' => $alumno->id]);
            session(['institucion_id' => $institucion_id]);
            session(['division_id' => $request->division_id]);

            return redirect(route('roles.mostrarCuentas'));
        }
        return redirect(route('alumnos.create', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('Alumnos/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'alumno' => Alumno::with(['user', 'division', 'division.nivel', 'division.orientacion', 'division.curso'])
                ->find($id),
        ]);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Alumnos/Edit', [
            'institucion_id' => $institucion_id,
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with(['nivel', 'orientacion', 'curso'])
                ->orderBy('nivel_id')
                ->orderBy('orientacion_id')
                ->orderBy('curso_id')
                ->orderBy('division')
                ->get(),
            'alumno' => Alumno::with('user')->findOrFail($id),
        ]);
    }

    public function update(StoreAlumno $request, $institucion_id, $id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $request->division_id)) {
            $alumno = Alumno::find($id);
            $alumno->division_id = $request->division_id;
            $alumno->save();
            session(['division_id' => $request->division_id]);
            return redirect(route('divisiones.show', [$institucion_id, $request->division_id]));
        }
        return back()->withErrors('Clave de acceso incorrecta.');
    }

    public function destroy($id)
    {
        Alumno::destroy($id);

        $message = 'Alumno eliminado con exito!';

        if (session('tipo') == 'Alumno') {
            $message = 'Te eliminaste con exito!';
            session()->forget(['tipo', 'alumno_id', 'division_id', 'institucion_id']);
        }
        else {
            return back()->withErrors('Debe tener activado la cuenta que desea eliminar.');
        }

        return redirect(route('roles.mostrarCuentas'))->with(['successMessage' => $message]);
    }
}
