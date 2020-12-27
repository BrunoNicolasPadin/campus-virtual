<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Correccion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\EntregaArchivo;
use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EntregaController extends Controller
{
    public function index($institucion_id, $division_id, $evaluacion_id)
    {
        return Inertia::render('Evaluaciones/Entregas/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entregas' => Entrega::where('evaluacion_id', $evaluacion_id)->with(['alumno', 'alumno.user'])->get(),
        ]);
    }

    public function show($institucion_id, $division_id, $evaluacion_id, $id)
    {
        return Inertia::render('Evaluaciones/Entregas/Show', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->find($id),
            'archivos' => EntregaArchivo::where('entrega_id', $id)->get(),
            'correcciones' => Correccion::where('entrega_id', $id)->get(),
        ]);
    }

    public function edit($institucion_id, $division_id, $evaluacion_id, $id)
    {
        return Inertia::render('Evaluaciones/Entregas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'evaluacion' => Evaluacion::find($evaluacion_id),
            'entrega' => Entrega::with(['alumno', 'alumno.user'])->find($id),
        ]);
    }

    public function update(Request $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        Entrega::where('id', $id)
            ->update([
                'calificacion' => $request->calificacion,
                'comentario' => $request->comentario,
            ]);
        return redirect(route('entregas.show', [$institucion_id, $division_id, $evaluacion_id, $id]))
            ->with(['successMessage' => 'Entrega calificada y/o comentada con exito!']);
    }
}
