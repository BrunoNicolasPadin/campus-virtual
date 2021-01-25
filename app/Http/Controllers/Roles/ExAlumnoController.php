<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Roles\ExAlumno;
use App\Models\Roles\Alumno;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExAlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('verificarExAlumnoNuevo')->only('store');
        $this->middleware('exAlumnoCorrespondiente')->only('destroy');
    }
    public function index($institucion_id)
    {
        return Inertia::render('ExAlumnos/Index', [
            'institucion_id' => $institucion_id,
            'exalumnos' => ExAlumno::where('institucion_id', $institucion_id)
                ->with('user')
                ->paginate(20)
        ]);
    }

    public function store(Request $request, $institucion_id)
    {
        $alumno = Alumno::findOrFail($request->alumno_id);
        $alumno->division_id = null;
        $alumno->save();

        ExAlumno::create([
            'user_id' => $alumno->user_id,
            'institucion_id' => $institucion_id,
        ]);

        return redirect(route('exalumnos.index', $institucion_id))
            ->with(['successMessage' => 'Ex alumno agregado con exito!']);
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
