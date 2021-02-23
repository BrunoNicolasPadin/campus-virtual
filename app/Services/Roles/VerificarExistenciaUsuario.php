<?php

namespace App\Services\Roles;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use Illuminate\Support\Facades\Auth;

class VerificarExistenciaUsuario
{
    public function verificarRol()
    {
        $user_id = Auth::id();

        if (session('tipo') == 'Institucion') {
            return $this->verificarInstitucion($user_id);
        }
        if (session('tipo') == 'Directivo') {
            return $this->verificarDirectivo($user_id);
        }
        if (session('tipo') == 'Docente') {
            return $this->verificarDocente($user_id);
        }
        if (session('tipo') == 'Alumno') {
            return $this->verificarAlumno($user_id);
        }
        if (session('tipo') == 'Padre') {
            return $this->verificarPadre($user_id);
        }
        return false;
    }

    public function verificarInstitucion($user_id)
    {
        if (Institucion::where('user_id', $user_id)
            ->exists()) {
            return true;
        }
        return false;
    }

    public function verificarDirectivo($user_id)
    {
        if (Directivo::where('user_id', $user_id)
            ->exists()) {
            return true;
        }
        return false;
    }

    public function verificarDocente($user_id)
    {
        if (Docente::where('user_id', $user_id)
            ->exists()) {
            return true;
        }
        return false;
    }

    public function verificarAlumno($user_id)
    {
        if (Alumno::where('user_id', $user_id)
            ->exists()) {
            return true;
        }
        return false;
    }

    public function verificarPadre($user_id)
    {
        if (Padre::where('user_id', $user_id)
            ->exists()) {
            return true;
        }
        return false;
    }
}