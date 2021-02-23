<?php

namespace App\Services\Muro;

use Illuminate\Support\Facades\Auth;

class EliminarService
{
    public function verificarUsuarioParaEliminar($user_id, $institucion_id)
    {
        if ($user_id == Auth::id()) {
            return true;
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($institucion_id == session('institucion_id')) {
                return true;
            }
            return false;
        }

        return false;
    }
}