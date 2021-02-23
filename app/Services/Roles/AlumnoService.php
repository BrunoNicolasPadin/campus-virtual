<?php

namespace App\Services\Roles;

use App\Models\Roles\Alumno;
use App\Models\Roles\Padre;
use Illuminate\Support\Facades\Auth;

class AlumnoService
{
    public function AlumnoCorrespondiente($alumno_id)
    {
        $alumno = Alumno::findOrFail($alumno_id);

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {

            if (session('institucion_id') == $alumno->institucion_id) {
                return true;
            }
            return false;
        }

        if (session('tipo') == 'Alumno') {

            if (Alumno::where('id', $alumno->id)
                ->where('user_id', Auth::id())
                ->exists()) {
                    return true;
            }
            return false;
        }

        if (session('tipo') == 'Padre') {

            if (Padre::where('user_id', Auth::id())
                ->where('alumno_id', $alumno->id)
                ->exists()) {
                    return true;
            }
            return false;
        }
        return false;
    }
}