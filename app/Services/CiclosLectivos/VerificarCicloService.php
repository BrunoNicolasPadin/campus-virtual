<?php

namespace App\Services\CiclosLectivos;

use App\Models\CiclosLectivos\CicloLectivo;

class VerificarCicloService
{
    public function verificarCicloLectivo($ciclo_lectivo_id)
    {
        $cicloLectivo = CicloLectivo::findOrFail($ciclo_lectivo_id);

        if ($cicloLectivo->institucion_id == session('institucion_id')) {
            return true;
        }
        return false;
    }
}