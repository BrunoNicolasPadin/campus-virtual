<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\ExAlumno;
use App\Models\Roles\Padre;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TipoCuentaController extends Controller
{
    public function mostrarCuentas()
    {
        $user_id = Auth::id();
        $directivos = null;
        $docentes = null;
        $alumnos = null;
        $padres = null;

        if (Directivo::where('user_id', $user_id)->exists()) {
            $directivos = $this->obtenerCuentasDirectivo($user_id);
        }
        if (Docente::where('user_id', $user_id)->exists()) {
            $docentes = $this->obtenerCuentasDocente($user_id);
        }
        if (Alumno::where('user_id', $user_id)->exists()) {
            $alumnos = $this->obtenerCuentasAlumno($user_id);
        }
        if (Padre::where('user_id', $user_id)->exists()) {
            $padres = $this->obtenerCuentasPadre($user_id);
        }

        return Inertia::render('Roles/TiposDeCuenta', [
            'directivos' => $directivos,
            'docentes' => $docentes,
            'alumnos' => $alumnos,
            'padres' => $padres,
        ]);
    }

    public function obtenerCuentasDirectivo($user_id)
    {
        return Directivo::where('user_id', $user_id)->with(['institucion', 'institucion.user'])->get();
    }

    public function obtenerCuentasDocente($user_id)
    {
        return Docente::where('user_id', $user_id)->with(['institucion', 'institucion.user'])->get();
    }

    public function obtenerCuentasAlumno($user_id)
    {
        return Alumno::where('user_id', $user_id)->with(['institucion', 'institucion.user'])->get();
    }

    public function obtenerCuentasPadre($user_id)
    {
        return Padre::where('user_id', $user_id)->with(['hijos', 'hijos.user'])->get();
    }
}
