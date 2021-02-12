<?php

namespace App\Observers;

use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Libretas\Calificacion;
use App\Models\Libretas\Libreta;
use App\Models\Roles\Alumno;

class AlumnoObserver
{
    public function created(Alumno $alumno)
    {
        $this->cargarLibreta($alumno);
    }

    public function updated(Alumno $alumno)
    {
        if ($alumno->isDirty('division_id')) {
            $this->cargarLibreta($alumno);
        }
    }

    public function cargarLibreta($alumno)
    {
        $cicloLectivo = CicloLectivo::where('institucion_id', $alumno->institucion_id)->where('activado', '1')->first();
        $this->eliminarLibretas($cicloLectivo->id, $alumno->id);

        $asignaturas = Asignatura::where('division_id', $alumno->division_id)->get();
        $division = Division::find($alumno->division_id);

        if ($division->periodo_id == 1) {
            $periodos = ['1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }

        if ($division->periodo_id == 2) {
            $periodos = ['1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }

        if ($division->periodo_id == 1) {
            $periodos = ['1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }

        foreach ($asignaturas as $asignatura) {

            $libreta = Libreta::create([
                'alumno_id' => $alumno->id,
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

    /* public function deleted(Alumno $alumno)
    {
        //
    }

    public function restored(Alumno $alumno)
    {
        //
    }

    public function forceDeleted(Alumno $alumno)
    {
        //
    } */
}
