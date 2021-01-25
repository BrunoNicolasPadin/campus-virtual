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
                ->with(['alumno', 'alumno.user'])
                ->paginate(20)
        ]);
    }

    public function store(Request $request, $institucion_id)
    {
        Alumno::where('id', $request->alumno_id)
            ->update([
                'division_id' => null,
            ]);

        ExAlumno::create([
            'alumno_id' => $request->alumno_id,
            'institucion_id' => $institucion_id,
            'activado' => '0',
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
