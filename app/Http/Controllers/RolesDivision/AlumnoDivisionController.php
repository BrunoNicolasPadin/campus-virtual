<?php

namespace App\Http\Controllers\RolesDivision;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\PasarDeAnioUpdate;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use App\Services\Division\DivisionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlumnoDivisionController extends Controller
{
    protected $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->only('sacarloDeLaDivision');
        $this->middleware('alumnoDivisionCorrespondiente')->only('sacarloDeLaDivision');

        $this->divisionService = $divisionService;
    }

    public function mostrarAlumnos($institucion_id, $division_id)
    {
        $alumnos = Alumno::select('users.name', 'users.profile_photo_path', 'alumnos.id')
            ->where('alumnos.division_id', $division_id)
            ->join('users', 'users.id', 'alumnos.user_id')
            ->paginate(10);

        return Inertia::render('RolesDivision/Alumnos', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'user_id' => Auth::id(),
            'division' => $this->divisionService->find($division_id),
            'alumnos' => $alumnos,
        ]);
    }

    public function hacerlosPasar($institucion_id, $division_id)
    {
        $alumnos = Alumno::select('users.name', 'users.profile_photo_path', 'alumnos.id')
            ->where('alumnos.division_id', $division_id)
            ->join('users', 'users.id', 'alumnos.user_id')
            ->get();

        return Inertia::render('RolesDivision/HacerlosPasar', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'divisiones' => $this->divisionService->get($institucion_id),
            'alumnos' => $alumnos,
        ]);
    }

    public function cambiarCurso(PasarDeAnioUpdate $request, $institucion_id, $division_id)
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
