<?php

namespace App\Http\Controllers\RolesDivision;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlumnoDivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->only('sacarloDeLaDivision');
        $this->middleware('alumnoDivisionCorrespondiente')->only('sacarloDeLaDivision');
    }

    public function mostrarAlumnos($institucion_id, $division_id)
    {
        return Inertia::render('RolesDivision/Alumnos', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'user_id' => Auth::id(),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'alumnos' => Alumno::where('division_id', $division_id)->with('user')->paginate(20),
        ]);
    }

    public function hacerlosPasar($institucion_id, $division_id)
    {
        return Inertia::render('RolesDivision/HacerlosPasar', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->findOrFail($division_id),
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->orderBy('nivel_id')
                ->orderBy('orientacion_id')
                ->orderBy('curso_id')
                ->orderBy('division')
                ->with(['nivel', 'orientacion', 'curso'])
                ->get(),
            'alumnos' => Alumno::where('division_id', $division_id)->with('user')->get(),
        ]);
    }

    public function cambiarCurso(Request $request, $institucion_id, $division_id)
    {
        for ($i=0; $i < count($request->alumno_id); $i++) { 
            $alumno = Alumno::findOrFail($request->alumno_id[$i]);
            $alumno->division_id = $request->division_id;
            $alumno->save();
        }

        return redirect(route('alumnosDivision.mostrar', [$institucion_id, $division_id]))
            ->with((['successMessage' => 'Alumnos pasados de año con éxito!']));
        
    }

    public function sacarloDeLaDivision($institucion_id, $division_id, $alumno_id)
    {
        $alumno = Alumno::where('id', $alumno_id)
            ->update([
                'division_id' => null,
            ]);

        return back();
    }
}
