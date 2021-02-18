<?php

namespace App\Http\Controllers\Asignaturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asignaturas\StoreAsignatura;
use App\Http\Requests\Asignaturas\UpdateAsignatura;
use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Asignaturas\AsignaturaHorario;
use App\Models\Deudores\Mesa;
use App\Models\Estructuras\Division;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Materiales\Grupo;
use App\Models\Roles\Docente;
use App\Services\Archivos\EliminarEntregasCorrecciones;
use App\Services\Archivos\EliminarGruposMateriales;
use App\Services\FechaHora\CambiarFormatoFecha;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Inertia\Inertia;

class AsignaturaController extends Controller
{
    protected $formatoService;
    protected $formatoFechaService;
    protected $archivosGruposServices;
    protected $archivosEvaServices;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        CambiarFormatoFecha $formatoFechaService,
        EliminarGruposMateriales $archivosGruposServices,
        EliminarEntregasCorrecciones $archivosEvaServices,
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
    }

    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Asignaturas/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
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
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Asignatura guardada con exito!']);
    }

    public function show($institucion_id, $division_id, $id)
    {
        return Inertia::render('Asignaturas/Show', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'asignatura' => Asignatura::findOrFail($id),
            'mesas' => Mesa::where('asignatura_id', $id)->with('asignatura')->orderBy('fechaHora')->paginate(2)
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
        $grupos = Grupo::where('asignatura_id', $id)->get();
        
        foreach ($grupos as $grupo) {
            $this->archivosGruposServices->eliminarGruposMateriales($grupo->id);
        }

        $evaluaciones = Evaluacion::where('asignatura_id', $id)->get();

        foreach ($evaluaciones as $evaluacion) {

            $this->archivosEvaServices->eliminarEntregasCorrecciones($evaluacion->id);
        }
    
        Asignatura::destroy($id);
        return redirect(route('asignaturas.index', [$institucion_id, $division_id]))->with(['successMessage' => 'Asignatura eliminada con exito!']);
    }
}
