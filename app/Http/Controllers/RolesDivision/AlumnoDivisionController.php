<?php

namespace App\Http\Controllers\RolesDivision;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Roles\Alumno;
use Inertia\Inertia;

class AlumnoDivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
    }

    public function mostrarAlumnos($institucion_id, $division_id)
    {
        return Inertia::render('RolesDivision/Alumnos', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'alumnos' => Alumno::where('division_id', $division_id)->with('user')->paginate(20),
        ]);
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
