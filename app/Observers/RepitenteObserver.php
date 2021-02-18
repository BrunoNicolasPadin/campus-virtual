<?php

namespace App\Observers;

use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Libretas\Calificacion;
use App\Models\Libretas\Libreta;
use App\Models\Repitentes\Repitente;

class RepitenteObserver
{
    public function created(Repitente $repitente)
    {
        $this->cargarLibreta($repitente);
    }

    public function updated(Repitente $repitente)
    {
        if ($repitente->isDirty('division_id')) {
            $this->cargarLibreta($repitente);
        }
    }

    public function deleted(Repitente $repitente)
    {
        $cicloLectivo = CicloLectivo::where('institucion_id', $repitente->institucion_id)->where('activado', '1')->first();
        $this->eliminarLibretas($cicloLectivo->id, $repitente->alumno_id);
    }

    public function cargarLibreta($repitente)
    {
        $cicloLectivo = CicloLectivo::where('institucion_id', $repitente->institucion_id)->where('activado', '1')->first();
        $this->eliminarLibretas($cicloLectivo->id, $repitente->alumno_id);

        $asignaturas = Asignatura::where('division_id', $repitente->division_id)->get();
        $division = Division::find($repitente->division_id);

        if ($division->periodo_id == 1) {
            $periodos = ['1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }

        if ($division->periodo_id == 2) {
            $periodos = ['1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }

        if ($division->periodo_id == 3) {
            $periodos = ['1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }

        foreach ($asignaturas as $asignatura) {

            $libreta = Libreta::create([
                'alumno_id' => $repitente->alumno_id,
                'ciclo_lectivo_id' => $cicloLectivo->id,
                'division_id' => $division->id,
                'asignatura_id' => $asignatura->id,
                'periodo_id' => $division->periodo_id,
            ]);

            for ($k=0; $k < count($periodos); $k++) { 
                Calificacion::create([
                    'libreta_id' => $libreta->id,
                    'periodo' => $periodos[$k],
                ]);
            }
        }
    }

    public function eliminarLibretas($ciclo_lectivo_id, $alumno_id)
    {
        $libretas = Libreta::where('alumno_id', $alumno_id)->where('ciclo_lectivo_id', $ciclo_lectivo_id)->get();
        
        foreach ($libretas as $libreta) {
            Libreta::destroy($libreta->id);
        }
    }
}
