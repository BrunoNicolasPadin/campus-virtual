<?php

namespace App\Http\Controllers\Libretas;

use App\Http\Controllers\Controller;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Libretas\Calificacion;
use App\Models\Libretas\Libreta;
use App\Models\Roles\Alumno;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LibretaController extends Controller
{
    public function index($institucion_id, $alumno_id)
    {
        return Inertia::render('Libretas/Index', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
                ->orderBy('comienzo')
                ->get(),
        ]);
    }

    public function show($institucion_id, $alumno_id, $ciclo_lectivo_id)
    {
        $libreta = Libreta::where('alumno_id', $alumno_id)->where('ciclo_lectivo_id', $ciclo_lectivo_id)->first();
    
        if ($libreta->periodo == 'Bimestre') {
            $periodos = ['1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }

        if ($libreta->periodo == 'Trimestre') {
            $periodos = ['1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }

        if ($libreta->periodo == 'Cuatrimestre') {
            $periodos = ['1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }
    
        return Inertia::render('Libretas/Show', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'ciclo_lectivo_id' => $ciclo_lectivo_id,
            'periodos' => $periodos,
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
                ->orderBy('comienzo')
                ->get(),
            'libretas' => Libreta::where('alumno_id', $alumno_id)
                ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
                ->with(['asignatura', 'calificaciones'])
                ->get(),
        ]);
    }

    public function edit($institucion_id, $alumno_id, $id)
    {
        return Inertia::render('Libretas/Edit', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'libretas' => Libreta::with(['asignatura', 'calificaciones'])->find($id),
        ]);
    }

    public function update(Request $request, $institucion_id, $alumno_id, $id)
    {
        $libreta = Libreta::find($id);

        for ($i=0; $i < count($request->notas); $i++) { 
            Calificacion::where('id', $request->notas[$i]['id'])
                ->update([
                    'calificacion' => $request->notas[$i]['calificacion'],
                ]);
        }

        return redirect(route('libretas.show', [$institucion_id, $alumno_id, $libreta->ciclo_lectivo_id]))
            ->with(['successMessage'  => 'Calificaciones actualizadas con exito!']);
    }
}
