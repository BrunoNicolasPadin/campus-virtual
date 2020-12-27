<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Entrega;
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
        //
    }

    public function edit($institucion_id, $division_id, $evaluacion_id, $id)
    {
        //
    }

    public function update(Request $request, $institucion_id, $division_id, $evaluacion_id, $id)
    {
        //
    }
}
