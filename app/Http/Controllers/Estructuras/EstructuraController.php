<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estructuras\StoreDivision;
use App\Http\Requests\Estructuras\UpdateDivision;
use App\Models\Estructuras\Curso;
use App\Models\Estructuras\Division;
use App\Models\Estructuras\FormaEvaluacion;
use App\Models\Estructuras\Nivel;
use App\Models\Estructuras\Orientacion;
use App\Models\Estructuras\Periodo;
use App\Services\Division\DivisionService;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class EstructuraController extends Controller
{
    protected $divisionService;

    public function __construct(DivisionService $divisionService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos')->except('index', 'show');
        $this->middleware('divisionCorrespondiente')->only('show', 'edit', 'update', 'destroy');

        $this->divisionService = $divisionService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Estructuras/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'divisiones' => Division::where('institucion_id', $institucion_id)
                ->with(['nivel', 'orientacion', 'curso'])
                ->orderBy('nivel_id')
                ->orderBy('orientacion_id')
                ->orderBy('curso_id')
                ->orderBy('division')
                ->paginate(10),
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
            'formasEvaluacion' => FormaEvaluacion::where('institucion_id', $institucion_id)->get(),
        ]);
    }

    public function store(StoreDivision $request, $institucion_id)
    {
        for ($i=0; $i < count($request->divisiones); $i++) { 
            Division::create([
                'institucion_id' => $institucion_id,
                'nivel_id' => $request->nivel_id,
                'orientacion_id' => $request->orientacion_id,
                'curso_id' => $request->curso_id,
                'division' => $request->divisiones[$i]['division'],
                'periodo_id' => $request->periodo_id,
                'forma_evaluacion_id' => $request->forma_evaluacion_id,
                'claveDeAcceso' => Hash::make($request->divisiones[$i]['claveDeAcceso']),
            ]);
        }

        return redirect(route('divisiones.create', $institucion_id))
            ->with(['successMessage' => 'Divisiones agregadas con éxito!']);
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('Estructuras/Show', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($id),
            'tipo' => session('tipo'),
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
            'division' => Division::findOrFail($id),
            'formasEvaluacion' => FormaEvaluacion::where('institucion_id', $institucion_id)->get(),
        ]);
    }

    public function update(UpdateDivision $request, $institucion_id, $id)
    {
        Division::where('id', $id)
            ->update([
                'nivel_id' => $request->nivel_id,
                'orientacion_id' => $request->orientacion_id,
                'curso_id' => $request->curso_id,
                'division' => $request->division,
                'periodo_id' => $request->periodo_id,
                'forma_evaluacion_id' => $request->forma_evaluacion_id,
            ]);

        if (! $request->claveDeAcceso == '') {
            Division::where('id', $id)
                ->update([
                    'claveDeAcceso' => Hash::make($request->claveDeAcceso),
                ]);
        }
        
        return redirect(route('divisiones.index', $institucion_id))
            ->with(['successMessage' => 'División actualizada con éxito!']); 
    }

    public function destroy($institucion_id, $id)
    {
        Division::destroy($id);
        return redirect(route('divisiones.index', $institucion_id))
            ->with(['successMessage' => 'División eliminada con éxito!']); 
    }
}
