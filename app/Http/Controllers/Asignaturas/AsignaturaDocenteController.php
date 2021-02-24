<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreDocente;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use App\Services\Docentes\DocenteService;
use Inertia\Inertia;

class AsignaturaDocenteController extends Controller
{
    protected $divisionService;
    protected $asignaturaService;
    protected $docenteService;

    public function __construct(
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService,
        DocenteService $docenteService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('asignaturaCorrespondiente');

        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
        $this->docenteService = $docenteService;
    }

    public function create($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Asignaturas/Docentes/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'asignatura'  => $this->asignaturaService->find($asignatura_id),
            'docentes' => $this->docenteService->get($institucion_id),
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
