<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaHorario;
use App\Models\Estructuras\Division;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AsignaturaHorarioController extends Controller
{
    public function create($institucion_id, $division_id, $asignatura_id)
    {
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        return Inertia::render('Asignaturas/Horarios/Create', [
            'institucion_id' => $institucion_id,
            'dias' => $dias,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignatura'  => Asignatura::find($asignatura_id),
        ]);
    }

    public function store(Request $request, $institucion_id, $division_id, $asignatura_id)
    {
        for ($i=0; $i < count($request->diaHorario); $i++) { 
            AsignaturaHorario::create([
                'asignatura_id' => $asignatura_id,
                'dia' => $request->diaHorario[$i]['dia'],
                'horaDesde' => $request->diaHorario[$i]['horaDesde']['HH'] . ':' . $request->diaHorario[$i]['horaDesde']['mm'] . ':00',
                'horaHasta' => $request->diaHorario[$i]['horaHasta']['HH'] . ':' . $request->diaHorario[$i]['horaHasta']['mm'] . ':00',
            ]);
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Horarios agregados con exito!']);
    }

    public function destroy($institucion_id, $division_id, $asignatura_id, $id)
    {
        AsignaturaHorario::destroy($id);
        return back();
    }
}
