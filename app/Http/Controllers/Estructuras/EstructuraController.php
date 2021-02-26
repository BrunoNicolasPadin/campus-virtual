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
        $divisiones = Division::select('divisiones.id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
            'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre')
            ->join('niveles', 'niveles.id', 'divisiones.nivel_id')
            ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
            ->join('cursos', 'cursos.id', 'divisiones.curso_id')
            ->orderBy('divisiones.nivel_id')
            ->orderBy('divisiones.curso_id')
            ->orderBy('divisiones.division')
            ->orderBy('divisiones.orientacion_id')
            ->paginate(10);
        return Inertia::render('Estructuras/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'divisiones' => $divisiones,
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
            'formasEvaluacion' => FormaEvaluacion::select('id', 'nombre')->where('institucion_id', $institucion_id)->get(),
        ]);
    }

    public function store(StoreDivision $request, $institucion_id)
    {
        for ($i=0; $i < count($request->divisiones); $i++) { 

            $division = new Division();
            $division->division = $request->divisiones[$i]['division'];
            $division->claveDeAcceso = Hash::make($request->divisiones[$i]['claveDeAcceso']);
            $division->institucion()->associate($institucion_id);
            $division->nivel()->associate($request->nivel_id);
            $division->orientacion()->associate($request->orientacion_id);
            $division->curso()->associate($request->curso_id);
            $division->periodo()->associate($request->periodo_id);
            $division->formaEvaluacion()->associate($request->forma_evaluacion_id);
            $division->save();
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
            'formasEvaluacion' => FormaEvaluacion::select('id', 'nombre')->where('institucion_id', $institucion_id)->get(),
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
