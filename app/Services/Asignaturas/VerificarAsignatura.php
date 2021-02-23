<?php

namespace App\Services\Asignaturas;

use App\Models\Asignaturas\Asignatura;
use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Estructuras\Division;

class VerificarAsignatura
{
    public function verificarInstitucionDirectivo($asignatura_id)
    {
        $asignatura = Asignatura::select('id')
            ->addSelect(
                ['institucion_id' => Division::select('institucion_id')
                    ->whereColumn('id', 'division_id')
                    ->limit(1)
                ])
            ->findOrFail($asignatura_id);

        if ($asignatura->institucion_id == session('institucion_id')) {
            return true;
        }
        return false;
    }

    public function verificarDocente($asignatura_id)
    {
        if (AsignaturaDocente::where('asignatura_id', $asignatura_id)->where('docente_id', session('tipo_id'))->exists()) {
            return true;
        }
        return false;
    }
}