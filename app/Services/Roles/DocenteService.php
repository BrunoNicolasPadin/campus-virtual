<?php

namespace App\Services\Roles;

use App\Models\Asignaturas\AsignaturaDocente;

class DocenteService
{
    public function verificarDocenteDivision($division_id)
    {
        $asignaturasDocentes = AsignaturaDocente::where('docente_id', session('tipo_id'))->get();

        foreach ($asignaturasDocentes as $asignaturaDocente) {
            
            if ($asignaturaDocente->asignatura->division_id == $division_id) {
                return true;
            }
        }
        return false;
    }

    public function verificarDocenteId($asignatura_id)
    {
        $asignaturasDocentes = AsignaturaDocente::where('asignatura_id', $asignatura_id)->get();

        foreach ($asignaturasDocentes as $asignaturaDocente) {
            if ($asignaturaDocente->docente_id == session('tipo_id')) {
                return true;
            }
        }
        return false;
    }
}