<?php

namespace App\Services\Mesas;

use App\Models\Deudores\AlumnoDeudor;

class DeudorService
{
    public function verificarGeneral($asignatura_id)
    {
        if (session('tipo') == 'Alumno') {
            $alumno_id = session('tipo_id');
            return $this->verificarDeudor($alumno_id, $asignatura_id);
        }
        if (session('tipo') == 'Padre') {
            $alumno_id = session('alumno_id');
            return $this->verificarDeudor($alumno_id, $asignatura_id);
        }
    }

    public function verificarDeudor($alumno_id, $asignatura_id)
    {
        if (AlumnoDeudor::where('alumno_id', $alumno_id)->where('asignatura_id', $asignatura_id)->where('aprobado', '0')->exists()) {
            return true;
        }
        return false;
    }
}

    