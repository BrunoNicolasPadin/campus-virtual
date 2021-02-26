<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreHorario;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaHorario;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use Inertia\Inertia;

class AsignaturaHorarioController extends Controller
{
    protected $divisionService;
    protected $asignaturaService;

    public function __construct(
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService
    )
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
        $this->middleware('asignaturaCorrespondiente');

        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
    }

    public function create($institucion_id, $division_id, $asignatura_id)
    {
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        return Inertia::render('Asignaturas/Horarios/Create', [
            'institucion_id' => $institucion_id,
            'dias' => $dias,
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($asignatura_id),
        ]);
    }

    public function store(StoreHorario $request, $institucion_id, $division_id, $asignatura_id)
    {
        $asignatura = Asignatura::findOrFail($asignatura_id);
        
        for ($i=0; $i < count($request->diaHorario); $i++) { 

            $asignaturaHorario = new AsignaturaHorario();
            $asignaturaHorario->dia = $request->diaHorario[$i]['dia'];
            $asignaturaHorario->horaDesde = $request->diaHorario[$i]['horaDesde']['HH'] . ':' . $request->diaHorario[$i]['horaDesde']['mm'] . ':00';
            $asignaturaHorario->horaHasta = $request->diaHorario[$i]['horaHasta']['HH'] . ':' . $request->diaHorario[$i]['horaHasta']['mm'] . ':00';
            $asignaturaHorario->asignatura()->associate($asignatura);
            $asignaturaHorario->save();
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Horarios agregados con exito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        AsignaturaHorario::destroy($id);
        return back();
    }
}
