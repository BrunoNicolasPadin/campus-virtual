<?php

namespace App\Http\Controllers\RolesDivision;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\Estructuras\Division;
use App\Repositories\Estructuras\DivisionRepository;
use Inertia\Inertia;

class DocenteDivisionController extends Controller
{
    protected $divisionRepository;

    public function __construct(DivisionRepository $divisionRepository)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');

        $this->divisionRepository = $divisionRepository;
    }

    public function mostrarDocentes($institucion_id, $division_id)
    {
        $docentes = Asignatura::select('users.name', 'users.profile_photo_path', 'docentes.id')
            ->where('division_id', $division_id)
            ->join('asignaturas_docentes', 'asignaturas_docentes.asignatura_id', 'asignaturas.id')
            ->leftjoin('docentes', 'docentes.id', 'asignaturas_docentes.docente_id')
            ->leftjoin('users', 'users.id', 'docentes.user_id')
            ->get();
        $docentes = $docentes->unique('id');

        return Inertia::render('RolesDivision/Docentes', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'docentes' => $docentes,
        ]);
    }
}
