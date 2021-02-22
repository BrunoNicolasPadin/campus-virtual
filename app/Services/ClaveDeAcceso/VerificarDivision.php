<?php

namespace App\Services\ClaveDeAcceso;

use App\Models\Estructuras\Division;
use Illuminate\Support\Facades\Hash;

class VerificarDivision
{
    public function verificarClaveDeAcceso($claveIngresada, $id)
    {
        $division = Division::find($id);

        if (Hash::check($claveIngresada, $division->claveDeAcceso)) {
            return true;
        }
        return false;
    }
}