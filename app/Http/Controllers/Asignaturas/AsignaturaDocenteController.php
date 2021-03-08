<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreDocente;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Repositories\Asignaturas\AsignaturaRepository;
use App\Repositories\Docentes\DocenteRepository;
use App\Repositories\Estructuras\DivisionRepository;
use Inertia\Inertia;

class AsignaturaDocenteController extends Controller
{
    protected $divisionRepository;
    protected $asignaturaRepository;
    protected $docenteRepository;

    public function __construct(
        DivisionRepository $divisionRepository,
        AsignaturaRepository $asignaturaRepository,
        DocenteRepository $docenteRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('asignaturaCorrespondiente');

        $this->divisionRepository = $divisionRepository;
        $this->asignaturaRepository = $asignaturaRepository;
        $this->docenteRepository = $docenteRepository;
    }

    public function create($institucion_id, $division_id, $asignatura_id)
    {
        return Inertia::render('Asignaturas/Docentes/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'asignatura'  => $this->asignaturaRepository->find($asignatura_id),
            'docentes' => $this->docenteRepository->get($institucion_id),
        ]);
    }

    public function store(StoreDocente $request, $institucion_id, $division_id, $asignatura_id)
    {
        $asignatura = Asignatura::findOrFail($asignatura_id);

        for ($i=0; $i < count($request->docente); $i++) { 

            $asignaturaDocente = new AsignaturaDocente();
            $asignaturaDocente->asignatura()->associate($asignatura);
            $asignaturaDocente->docente()->associate($request->docente[$i]['docente_id']);
            $asignaturaDocente->save();
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Docente/s agregados con exito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        AsignaturaDocente::destroy($id);
        return back();
    }
}
