<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreAlumno;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use App\Services\ClaveDeAcceso\VerificarDIvision;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlumnoController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarDIvision $claveDeAccesoService)
    {
        $this->middleware('auth');
        /* $this->middleware('soloInstitucionDirectivo')->only('index', );
        $this->middleware('alumnoYaCreado')->only('create', 'store');
        $this->middleware('alumnoCorrespondiente')->only('show', 'edit', 'update', 'destroy'); */

        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Alumnos/Index', [
            'institucion_id' => $institucion_id,
            'alumnos' => Alumno::where('institucion_id', $institucion_id)
                ->with('user')
                ->get()
        ]);
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
            Alumno::create([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
                'division_id' => $request->division_id,
            ]);
            return redirect('/dashboard');
        }
        return redirect(route('alumnos.create', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('Alumnos/Show', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with(['user', 'division', 'division.nivel', 'division.orientacion', 'division.curso'])
                ->first(),
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
            'id' => $id,
        ]);
    }

    public function update(StoreAlumno $request, $institucion_id, $id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $request->division_id)) {
            Alumno::where('id', $id)
            ->update([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
                'division_id' => $request->division_id,
            ]);
            return redirect('/dashboard');
        }
        return redirect(route('alumnos.edit', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function destroy($id)
    {
        Alumno::destroy($id);
        return back();
    }
}
