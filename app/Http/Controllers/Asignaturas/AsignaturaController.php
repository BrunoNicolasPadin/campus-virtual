<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreAsignatura;
use App\Http\Requests\Asignaturas\UpdateAsignatura;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Asignaturas\AsignaturaHorario;
use App\Models\Deudores\Mesa;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Materiales\Grupo;
use App\Services\Archivos\EliminarEntregasCorrecciones;
use App\Services\Archivos\EliminarGruposMateriales;
use App\Services\Archivos\EliminarMesas;
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
    protected $archivosGruposServices;
    protected $archivosEvaServices;
    protected $mesasService;
    protected $divisionService;
    protected $asignaturaService;
    protected $docenteService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        CambiarFormatoFecha $formatoFechaService,
        EliminarGruposMateriales $archivosGruposServices,
        EliminarEntregasCorrecciones $archivosEvaServices,
        EliminarMesas $mesasService,
        DivisionService $divisionService, 
        AsignaturaService $asignaturaService,
        DocenteService $docenteService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente')->except('show');
        $this->middleware('soloInstitucionesDirectivos')->except('index', 'show');
        $this->middleware('asignaturaCorrespondiente')->only('edit', 'update', 'destroy');
        $this->middleware('asignaturaAdeudadaCorrespondiente')->only('show');

        $this->formatoService = $formatoService;
        $this->formatoFechaService = $formatoFechaService;
        $this->archivosGruposServices = $archivosGruposServices;
        $this->archivosEvaServices = $archivosEvaServices;
        $this->mesasService = $mesasService;
        $this->divisionService = $divisionService;
        $this->asignaturaService = $asignaturaService;
        $this->docenteService = $docenteService;
    }

    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Asignaturas/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignaturas' => Asignatura::where('division_id', $division_id)
                ->with(['horarios', 'docentes', 'docentes.docente', 'docentes.docente.user'])
                ->orderBy('nombre')
                ->get(),
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
        $asig = Asignatura::create([
            'division_id' => $division_id,
            'nombre' => $request->nombre,
        ]);
        
        if (! $request->docente[0]['docente_id'] == null) {
            for ($i=0; $i < count($request->docente); $i++) { 
                AsignaturaDocente::create([
                    'asignatura_id' => $asig->id,
                    'docente_id' => $request->docente[$i]['docente_id'],
                ]);
            }
        }

        for ($i=0; $i < count($request->diaHorario); $i++) { 
            AsignaturaHorario::create([
                'asignatura_id' => $asig->id,
                'dia' => $request->diaHorario[$i]['dia'],
                'horaDesde' => $request->diaHorario[$i]['horaDesde']['HH'] . ':' . $request->diaHorario[$i]['horaDesde']['mm'] . ':00',
                'horaHasta' => $request->diaHorario[$i]['horaHasta']['HH'] . ':' . $request->diaHorario[$i]['horaHasta']['mm'] . ':00',
            ]);
        }
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Asignatura creada con éxito!']);
    }

    public function show($institucion_id, $division_id, $id)
    {
        return Inertia::render('Asignaturas/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => $this->divisionService->find($division_id),
            'asignatura' => $this->asignaturaService->find($id),
            'mesas' => Mesa::where('asignatura_id', $id)->with('asignatura')->orderBy('fechaHora')->paginate(10)
                ->transform(function ($mesa) {
                    return [
                        'id' => $mesa->id,
                        'asignatura_id' => $mesa->asignatura_id,
                        'asignatura' => $mesa->asignatura,
                        'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHora),
                        'comentario' => $mesa->comentario,
                    ];
                }),
            'grupos' => Grupo::where('asignatura_id', $id)->orderBy('created_at')->get()
                ->map(function ($grupo) {
                    return [
                        'id' => $grupo->id,
                        'asignatura_id' => $grupo->asignatura_id,
                        'nombre' => $grupo->nombre,
                    ];
                }),
        ]);
    }

    public function edit($institucion_id, $division_id, $id)
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        return Inertia::render('Asignaturas/Edit', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionService->find($division_id),
            'dias' => $dias,
            'docentes' => $this->docenteService->get($institucion_id),
            'asignatura' => Asignatura::with(['horarios', 'docentes', 'docentes.docente', 'docentes.docente.user'])
                ->findOrFail($id),
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
        $grupos = Grupo::where('asignatura_id', $id)->get();
        foreach ($grupos as $grupo) {
            $this->archivosGruposServices->eliminarGruposMateriales($grupo->id);
        }

        $evaluaciones = Evaluacion::where('asignatura_id', $id)->get();
        foreach ($evaluaciones as $evaluacion) {

            $this->archivosEvaServices->eliminarEntregasCorrecciones($evaluacion->id);
        }

        $mesas = Mesa::where('asignatura_id', $id)->get();
        foreach ($mesas as $mesa) {
            
            $this->mesasService->eliminarMesas($mesa->id);
        }
        
    
        Asignatura::destroy($id);
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))
            ->with(['successMessage' => 'Asignatura eliminada con éxito!']);
    }
}
