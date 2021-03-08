<?php

namespace App\Http\Controllers\Libretas;

use App\Http\Controllers\Controller;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Deudores\AlumnoDeudor;
use App\Models\Libretas\Calificacion;
use App\Models\Libretas\Libreta;
use App\Repositories\Alumnos\AlumnoRepository;
use App\Repositories\CiclosLectivos\CicloLectivoRepository;
use App\Repositories\Estructuras\DivisionRepository;
use App\Repositories\Libretas\LibretaRepository;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LibretaController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $cicloLectivoRepository;
    protected $alumnoRepository;
    protected $libretaRepository;

    public function __construct(
        CambiarFormatoFecha $formatoService, 
        DivisionRepository $divisionRepository,
        CicloLectivoRepository $cicloLectivoRepository,
        AlumnoRepository $alumnoRepository,
        LibretaRepository $libretaRepository,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('alumnoCorrespondiente');
        $this->middleware('libretaCicloCorrespondiente')->only('show');
        $this->middleware('soloInstitucionesDirectivos')->only('edit', 'update');
        $this->middleware('libretaCorrespondiente')->only('edit', 'update');

        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
        $this->cicloLectivoRepository = $cicloLectivoRepository;
        $this->alumnoRepository = $alumnoRepository;
        $this->libretaRepository = $libretaRepository;
    }

    public function index($institucion_id, $alumno_id)
    {
        $cicloLectivo = CicloLectivo::where('institucion_id', $institucion_id)->where('activado', 1)->first();

        $libreta = null;
        $periodos = [];
        $libretas = [];
        $deudas = [];

        return Inertia::render('Libretas/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'ciclo_lectivo_id' => $cicloLectivo->id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'ciclosLectivos' => $this->cicloLectivoRepository->obtenerCiclosParaMostrar($institucion_id),
            'periodos' => $periodos,
            'libreta' => $libreta,
            'libretas' => $libretas,
            'deudas' => $deudas,
        ]);
    }

    public function show($institucion_id, $alumno_id, $ciclo_lectivo_id)
    {
        $libreta = $this->obtenerLibreta($alumno_id, $ciclo_lectivo_id);

        $periodos = [];
        $libretas = [];
        $deudas = [];

        if (! $libreta == null) {
            $periodos = $this->libretaRepository->obtenerPeriodos($libreta);
            $libretas = $this->obtenerLibretas($alumno_id, $ciclo_lectivo_id);
            $deudas = $this->obtenerDeudas($alumno_id, $ciclo_lectivo_id);
        }

        return [$libreta, $periodos, $libretas, $deudas, $ciclo_lectivo_id];
    }

    public function edit($institucion_id, $alumno_id, $id)
    {
        $libreta = Libreta::select('division_id')->findOrFail($id);
        $arrayTemporal = $this->divisionRepository->obtenerFormaEvaluacion($libreta->division_id);

        $libretas = Libreta::select('id', 'asignatura_id')
            ->where('id', $id)
            ->with(array(
                'asignatura' => function($query){
                    $query->select('id', 'nombre');
                },
                'calificaciones' => function($query){
                    $query->select('libreta_id', 'id', 'calificacion', 'periodo');
                },
            ))
            ->first();

        return Inertia::render('Libretas/Edit', [
            'institucion_id' => $institucion_id,
            'alumno' => $this->alumnoRepository->find($alumno_id),
            'libretas' => $libretas,
            'formasDescripcion' => $arrayTemporal[0],
            'tipoEvaluacion' => $arrayTemporal[1],
        ]);
    }

    public function update(Request $request, $institucion_id, $alumno_id, $id)
    {
        for ($i=0; $i < count($request->notas); $i++) { 
            
            $calificacion = Calificacion::findOrFail($request->notas[$i]['id']);
            $calificacion->calificacion = $request->notas[$i]['calificacion'];
            $calificacion->save();
        }

        return redirect(route('libretas.index', [$institucion_id, $alumno_id]))
            ->with(['successMessage'  => 'Libreta actualizada con éxito!']);
    }

    public function obtenerLibreta($alumno_id, $ciclo_lectivo_id)
    {
        return Libreta::select('libretas.periodo_id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
        'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre', 'formas_evaluacion.tipo')
        ->where('libretas.alumno_id', $alumno_id)
        ->where('libretas.ciclo_lectivo_id', $ciclo_lectivo_id)
        ->join('divisiones', 'libretas.division_id', 'divisiones.id')
        ->join('niveles', 'niveles.id', 'divisiones.nivel_id')
        ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
        ->join('cursos', 'cursos.id', 'divisiones.curso_id')
        ->join('formas_evaluacion', 'formas_evaluacion.id', 'divisiones.forma_evaluacion_id')
        ->first();
    }

    public function obtenerDeudas($alumno_id, $ciclo_lectivo_id)
    {
        return AlumnoDeudor::where('alumno_id', $alumno_id)
            ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with('asignatura')
            ->get();
    }

    public function obtenerLibretas($alumno_id, $ciclo_lectivo_id)
    {
        return Libreta::where('alumno_id', $alumno_id)
            ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with(['asignatura', 'calificaciones', 'division', 'division.nivel', 'division.orientacion', 'division.curso'])
            ->get();
    }
}
