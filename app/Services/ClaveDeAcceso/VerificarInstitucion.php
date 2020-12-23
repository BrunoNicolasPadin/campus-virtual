<?php

namespace App\Services\ClaveDeAcceso;

use App\Models\Instituciones\Institucion;
use Illuminate\Support\Facades\Hash;

class VerificarInstitucion
{
    public function verificarClaveDeAcceso($claveIngresada, $institucion_id)
    {
        $institucion = Institucion::find($institucion_id);

        if (Hash::check($claveIngresada, $institucion->claveDeAcceso)) {
            return true;
        }
        return false;
    }
}