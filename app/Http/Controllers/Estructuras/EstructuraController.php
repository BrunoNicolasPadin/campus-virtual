<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estructuras\StoreDivision;
use App\Http\Requests\Estructuras\UpdateDivision;
use App\Models\Estructuras\Curso;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\Nivel;
use App\Models\Estructuras\Orientacion;
use App\Models\Estructuras\Periodo;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class EstructuraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->only('show', 'edit', 'update', 'destroy');
    }

    public function index($institucion_id)
    {
        return Inertia::render('Estructuras/Index', [
            'institucion_id' => $institucion_id,
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with(['nivel', 'orientacion', 'curso'])
                ->orderBy('nivel_id')
                ->orderBy('orientacion_id')
                ->orderBy('curso_id')
                ->orderBy('division')
                ->get(),
        ]);
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

    public function store(StoreDivision $request, $institucion_id)
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
        return Inertia::render('Estructuras/Show', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($id),
        ]);
    }

    public function edit($institucion_id, $id)
    {
        return Inertia::render('Estructuras/Edit', [
            'institucion_id' => $institucion_id,
            'niveles' => Nivel::all(),
            'orientaciones' => Orientacion::all(),
            'cursos' => Curso::all(),
            'periodos' => Periodo::all(),
            'division' => Division::find($id),
        ]);
    }

    public function update(UpdateDivision $request, $institucion_id, $id)
    {
        Division::where('id', $id)
            ->update([
                'nivel_id' => $request->nivel_id,
                'orientacion_id' => $request->orientacion_id,
                'curso_id' => $request->curso_id,
                'division' => strtoupper($request->division),
                'periodo_id' => $request->periodo_id,
            ]);

        if (! $request->claveDeAcceso == '') {
            Division::where('id', $id)
                ->update([
                    'claveDeAcceso' => Hash::make($request->claveDeAcceso),
                ]);
        }
        
        return redirect(route('divisiones.index', $institucion_id))->with(['successMessage' => 'Division editada con exito!']); 
    }

    public function destroy($institucion_id, $id)
    {
        Division::destroy($id);
        return redirect(route('divisiones.index', $institucion_id))->with(['successMessage' => 'Division eliminada con exito!']); 
    }
}
