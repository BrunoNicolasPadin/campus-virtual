<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Models\Materiales\Grupo;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuscarGruposController extends Controller
{
    protected $divisionService;
    protected $asignaturaService;

    public function __construct(
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');

        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
    }

    public function filtrarPorAsignaturas($institucion_id, $division_id, $asignatura_id)
    {
        $gruposTodos = Grupo::select('id', 'asignatura_id', 'nombre')
        ->where('division_id', $division_id)
        ->when($asignatura_id, function ($query, $asignatura_id) {
            return $query->where('asignatura_id', $asignatura_id);
        })
        ->with(array(
            'asignatura' => function($query){
                $query->select('id', 'nombre');
            },
        ))
        ->paginate(10);

        return Inertia::render('Materiales/Grupos/Filtrados', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
            'asignaturas' => $this->asignaturaService->get($division_id),
            'gruposTodos' => $gruposTodos,
        ]);
    }
}
