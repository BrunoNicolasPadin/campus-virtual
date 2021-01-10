<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreDocente;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Estructuras\Division;
use App\Models\Roles\Docente;
use Inertia\Inertia;

class AsignaturaDocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('asignaturaCorrespondiente');
    }

    public function create($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Asignaturas/Docentes/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignatura'  => Asignatura::find($asignatura_id),
            'docentes' => Docente::where('institucion_id', $institucion_id)
                ->with('user')
                ->get()
        ]);
    }

    public function store(StoreDocente $request, $institucion_id, $division_id, $asignatura_id)
    {
        for ($i=0; $i < count($request->docente); $i++) { 
            AsignaturaDocente::create([
                'asignatura_id' => $asignatura_id,
                'docente_id' => $request->docente[$i]['docente_id'],
            ]);
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Docente/s agregados con exito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        AsignaturaDocente::destroy($id);
        return back();
    }
}
