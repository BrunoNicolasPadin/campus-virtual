<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreAsignatura;
use App\Http\Requests\Asignaturas\UpdateAsignatura;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Asignaturas\AsignaturaHorario;
use App\Models\Estructuras\Division;
use App\Models\Roles\Docente;
use Inertia\Inertia;

class AsignaturaController extends Controller
{
    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Asignaturas/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignaturas' => Asignatura::where('division_id', $division_id)
                ->with(['horarios', 'docentes', 'docentes.docente', 'docentes.docente.user'])
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function create($institucion_id, $division_id)
    {
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        return Inertia::render('Asignaturas/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'dias' => $dias,
            'docentes' => Docente::where('institucion_id', $institucion_id)
                ->with('user')
                ->get()
        ]);
    }

    public function store(StoreAsignatura $request, $institucion_id, $division_id)
    {
        $asig = Asignatura::create([
            'division_id' => $division_id,
            'nombre' => $request->nombre,
        ]);

        for ($i=0; $i < count($request->docente); $i++) { 
            AsignaturaDocente::create([
                'asignatura_id' => $asig->id,
                'docente_id' => $request->docente[$i]['docente_id'],
            ]);
        }

        for ($i=0; $i < count($request->diaHorario); $i++) { 
            AsignaturaHorario::create([
                'asignatura_id' => $asig->id,
                'dia' => $request->diaHorario[$i]['dia'],
                'horaDesde' => $request->diaHorario[$i]['horaDesde']['HH'] . ':' . $request->diaHorario[$i]['horaDesde']['mm'] . ':00',
                'horaHasta' => $request->diaHorario[$i]['horaHasta']['HH'] . ':' . $request->diaHorario[$i]['horaHasta']['mm'] . ':00',
            ]);
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Asignatura guardada con exito!']);
    }

    public function edit($institucion_id, $division_id, $id)
    {
        $dias = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];

        return Inertia::render('Asignaturas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'dias' => $dias,
            'docentes' => Docente::where('institucion_id', $institucion_id)
                ->with('user')
                ->get(),
            'asignatura' => Asignatura::with(['horarios', 'docentes', 'docentes.docente', 'docentes.docente.user'])
                ->find($id),
        ]);
    }

    public function update(UpdateAsignatura $request, $institucion_id, $division_id, $id)
    {
        Asignatura::where('id', $id)
            ->update([
                'nombre' => $request->nombre,
            ]);

        for ($i=0; $i < count($request->docente); $i++) { 
            AsignaturaDocente::where('asignatura_id', $id)
                ->update([
                    'docente_id' => $request->docente[$i]['docente_id'],
                ]);
        }

        for ($i=0; $i < count($request->diaHorario); $i++) { 
            AsignaturaHorario::where('id', $request->diaHorario[$i]['id'])
                ->update([
                    'dia' => $request->diaHorario[$i]['dia'],
                    'horaDesde' => $request->diaHorario[$i]['horaDesde'] . ':00',
                    'horaHasta' => $request->diaHorario[$i]['horaHasta'] . ':00',
                ]);
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Asignatura guardada con exito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        Asignatura::destroy($id);
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Asignatura eliminada con exito!']);
    }
}
