<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreAsignatura;
use App\Http\Requests\Asignaturas\UpdateAsignatura;
use App\Jobs\Asignaturas\AsignaturaDestroyJob;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Asignaturas\AsignaturaHorario;
use App\Models\Estructuras\Division;
use App\Services\Asignaturas\AsignaturaService;
use App\Services\Division\DivisionService;
use App\Services\Docentes\DocenteService;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class AsignaturaController extends Controller
{
    protected $formatoService;
    protected $formatoFechaService;
    protected $divisionService;
    protected $asignaturaService;
    protected $docenteService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        CambiarFormatoFecha $formatoFechaService,
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService,
        DocenteService $docenteService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->except('show');
        $this->middleware('soloInstitucionesDirectivos')->except('index');
        $this->middleware('asignaturaCorrespondiente')->only('edit', 'update', 'destroy');

        $this->formatoService = $formatoService;
        $this->formatoFechaService = $formatoFechaService;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
        $this->docenteService = $docenteService;
    }

    public function index($institucion_id, $division_id)
    {
        $asignaturas = Asignatura::select('asignaturas.id', 'asignaturas.nombre')
            ->where('asignaturas.division_id', $division_id)
            ->with(array(
                'docentes' => function($query){
                    $query->select('asignatura_id', 'docente_id');
                },
                'docentes.docente' => function($query){
                    $query->select('id', 'user_id');
                },
                'docentes.docente.user' => function($query){
                    $query->select('id','name');
                },
                'horarios' => function($query){
                    $query->select('asignatura_id','dia', 'horaDesde', 'horaHasta');
                }
            ))
            ->orderBy('nombre')
            ->get();

            return Inertia::render('Asignaturas/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignaturas' => $asignaturas,
        ]);
    }

    public function create($institucion_id, $division_id)
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        return Inertia::render('Asignaturas/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'dias' => $dias,
            'docentes' => $this->docenteService->get($institucion_id),
        ]);
    }

    public function store(StoreAsignatura $request, $institucion_id, $division_id)
    {
        $division = Division::select('id')->findOrFail($division_id);
        $asignatura = new Asignatura();
        $asignatura->nombre = $request->nombre;
        $asignatura->division()->associate($division);
        $asignatura->save();

        if (! $request->docente[0]['docente_id'] == null) {
            for ($i=0; $i < count($request->docente); $i++) { 

                $asignaturaDocente = new AsignaturaDocente();
                $asignaturaDocente->asignatura()->associate($asignatura);
                $asignaturaDocente->docente()->associate($request->docente[$i]['docente_id']);
                $asignaturaDocente->save();
            }
        }

        for ($i=0; $i < count($request->diaHorario); $i++) { 
            $asignaturaHorario = new AsignaturaHorario();
            $asignaturaHorario->dia = $request->diaHorario[$i]['dia'];
            $asignaturaHorario->horaDesde = $request->diaHorario[$i]['horaDesde']['HH'] . ':' . $request->diaHorario[$i]['horaDesde']['mm'] . ':00';
            $asignaturaHorario->horaHasta = $request->diaHorario[$i]['horaHasta']['HH'] . ':' . $request->diaHorario[$i]['horaHasta']['mm'] . ':00';
            $asignaturaHorario->asignatura()->associate($asignatura);
            $asignaturaHorario->save();
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Asignatura creada con éxito!']);
    }

    public function edit($institucion_id, $division_id, $id)
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        $asignatura = Asignatura::select('asignaturas.id', 'asignaturas.nombre')
            ->with(array(
                'docentes' => function($query){
                    $query->select('asignatura_id', 'docente_id');
                },
                'docentes.docente' => function($query){
                    $query->select('id', 'user_id');
                },
                'docentes.docente.user' => function($query){
                    $query->select('id','name');
                },
                'horarios' => function($query){
                    $query->select('id', 'asignatura_id','dia', 'horaDesde', 'horaHasta');
                }
            ))
            ->findOrFail($id);

        return Inertia::render('Asignaturas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'dias' => $dias,
            'docentes' => $this->docenteService->get($institucion_id),
            'asignatura' => $asignatura,
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
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Asignatura actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        AsignaturaDestroyJob::dispatch($id);
    
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Asignatura eliminada con éxito!']);
    }
}
