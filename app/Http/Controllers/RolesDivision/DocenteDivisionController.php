<?php

namespace App\Http\Controllers\RolesDivision;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use Inertia\Inertia;

class DocenteDivisionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
    }

    public function mostrarDocentes($institucion_id, $division_id)
    {
        $docentes = collect();
        $asignaturas = Asignatura::where('division_id', $division_id)->with('docentes', 'docentes.docente', 'docentes.docente.user')->get();

        foreach ($asignaturas as $asignatura) {
            foreach ($asignatura->docentes as $asignaturaDocente) {
                $docentes = $docentes->push($asignaturaDocente->docente);
            }
        }
        $docentes = $docentes->unique();

        return Inertia::render('RolesDivision/Docentes', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'docentes' => $docentes,
        ]);
    }
}
