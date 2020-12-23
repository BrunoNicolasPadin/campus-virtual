<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Curso;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\Nivel;
use App\Models\Estructuras\Orientacion;
use App\Models\Estructuras\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class EstructuraController extends Controller
{
    public function index($institucion_id)
    {
        //
    }

    public function create($institucion_id)
    {
        return Inertia::render('Estructuras/Create', [
            'institucion_id' => $institucion_id,
            'niveles' => Nivel::all(),
            'orientaciones' => Orientacion::all(),
            'cursos' => Curso::all(),
            'periodos' => Periodo::all(),
        ]);
    }

    public function store(Request $request, $institucion_id)
    {
        $div = strtoupper($request->division);
        $divisiones = explode (",", $div);

        for ($i=0; $i < count($divisiones); $i++) { 
            Division::create([
                'institucion_id' => $institucion_id,
                'nivel_id' => $request->nivel_id,
                'orientacion_id' => $request->orientacion_id,
                'curso_id' => $request->curso_id,
                'division' => trim($divisiones[$i], " "),
                'periodo_id' => $request->periodo_id,
                'claveDeAcceso' => Hash::make('division' . $divisiones[$i]),
            ]);
        }

        return redirect(route('divisiones.create', $institucion_id))->with(['successMessage' => 'Divisiones creadas con exito!']);
    }

    public function show($institucion_id, $id)
    {
        //
    }

    public function edit($institucion_id, $id)
    {
        //
    }

    public function update(Request $request, $institucion_id, $id)
    {
        //
    }

    public function destroy($institucion_id, $id)
    {
        //
    }
}
