<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Estructuras\Division;
use App\Services\Division\DivisionService;
use Inertia\Inertia;

class ListarDivisionesController extends Controller
{
    protected $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->only('index');

        $this->divisionService = $divisionService;
    }

    public function paraAlumnos($institucion_id)
    {
        return Inertia::render('Estructuras/Show', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find(session('division_id')),
            'tipo' => session('tipo'),
        ]);
    }

    public function paraDocentes($institucion_id)
    {
        $docente_id = session('tipo_id');

        $divisiones = AsignaturaDocente::select('divisiones.id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
        'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre')
            ->where('docente_id', $docente_id)
            ->join('asignaturas', 'asignaturas.id', 'asignaturas_docentes.asignatura_id')
            ->join('divisiones', 'divisiones.id', 'asignaturas.division_id')
            ->join('niveles', 'niveles.id', 'divisiones.nivel_id')
            ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
            ->join('cursos', 'cursos.id', 'divisiones.curso_id')
            ->orderBy('divisiones.nivel_id')
            ->orderBy('divisiones.curso_id')
            ->orderBy('divisiones.division')
            ->orderBy('divisiones.orientacion_id')
            ->paginate(10);

            $divisiones = $divisiones->unique();

            return Inertia::render('Estructuras/ListarDivisionesDocentes', [
                'institucion_id' => $institucion_id,
                'tipo' => session('tipo'),
                'divisiones' => $divisiones,
            ]);
    }
}
