<?php

namespace App\Http\Controllers\Libretas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Libretas\UpdateLibreta;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Deudores\AlumnoDeudor;
use App\Models\Libretas\Calificacion;
use App\Models\Libretas\Libreta;
use App\Models\Roles\Alumno;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class LibretaController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('alumnoCorrespondiente');
        $this->middleware('libretaCicloCorrespondiente')->only('show');
        $this->middleware('soloInstitucionesDirectivos')->only('edit', 'update');
        $this->middleware('libretaCorrespondiente')->only('edit', 'update');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $alumno_id)
    {
        $cicloLectivo = CicloLectivo::where('institucion_id', $institucion_id)->where('activado', 1)->first();
        $libreta = $this->obtenerLibreta($alumno_id, $cicloLectivo->id);

        $periodos = [];
        $libretas = [];
        $deudas = [];

        if (! $libreta == null) {
            $periodos = $this->obtenerPeriodos($libreta);
            $libretas = $this->obtenerLibretas($alumno_id, $cicloLectivo->id);
            $deudas = $this->obtenerDeudas($alumno_id, $cicloLectivo->id);
        }
    
        return Inertia::render('Libretas/Index', [
            'institucion_id' => $institucion_id,
            'tipo' => session('tipo'),
            'alumno' => Alumno::with('user')->find($alumno_id),
            'ciclo_lectivo_id' => $cicloLectivo->id,
            'ciclosLectivos' => CicloLectivo::where('institucion_id', $institucion_id)
                ->orderBy('comienzo')
                ->get()
                ->map(function ($ciclo) {
                    return [
                        'id' => $ciclo->id,
                        'comienzo' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->comienzo),
                        'final' => $this->formatoService->cambiarFormatoParaMostrar($ciclo->final),
                        'activado' => $ciclo->activado,
                    ];
                }),
            'periodos' => $periodos,
            'libretas' => $libretas,
            'libreta' => $libreta,
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
            $periodos = $this->obtenerPeriodos($libreta);
            $libretas = $this->obtenerLibretas($alumno_id, $ciclo_lectivo_id);
            $deudas = $this->obtenerDeudas($alumno_id, $ciclo_lectivo_id);
        }

        return [$libreta, $periodos, $libretas, $deudas, $ciclo_lectivo_id];
    }

    public function edit($institucion_id, $alumno_id, $id)
    {
        return Inertia::render('Libretas/Edit', [
            'institucion_id' => $institucion_id,
            'alumno' => Alumno::with('user')->find($alumno_id),
            'libretas' => Libreta::with(['asignatura', 'calificaciones'])->find($id),
        ]);
    }

    public function update(UpdateLibreta $request, $institucion_id, $alumno_id, $id)
    {
        $libreta = Libreta::find($id);

        for ($i=0; $i < count($request->notas); $i++) { 
            Calificacion::where('id', $request->notas[$i]['id'])
                ->update([
                    'calificacion' => $request->notas[$i]['calificacion'],
                ]);
        }

        return redirect(route('libretas.index', [$institucion_id, $alumno_id]))
            ->with(['successMessage'  => 'Libreta actualizada con éxito!']);
    }

    public function obtenerLibreta($alumno_id, $ciclo_lectivo_id)
    {
        return Libreta::where('alumno_id', $alumno_id)
            ->where('ciclo_lectivo_id', $ciclo_lectivo_id)
            ->with(['division', 'division.nivel', 'division.orientacion', 'division.curso'])
            ->first();
    }

    public function obtenerPeriodos($libreta)
    {
        if ($libreta->periodo_id == 1) {
            return ['1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }

        if ($libreta->periodo_id == 2) {
            return ['1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }

        if ($libreta->periodo_id == 3) {
            return ['1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }
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
