<?php

namespace App\Http\Controllers;

class TopNavController extends Controller
{
    public function mostrarDivisiones()
    {
        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            return redirect(route('divisiones.index', $institucion_id));
        }

        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            return redirect(route('listar-divisiones-alumnos', $institucion_id));
        }

        if (session('tipo') == 'Docente') {
            return redirect(route('listar-divisiones-docentes', $institucion_id));
        }
        return redirect(route('inicio'));
    }

    public function mostrarCalendario()
    {
        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }

        $year = 2021;
        $mes = 1;

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            return redirect(route('calendario-instituciones.mostrar', [$institucion_id, $year, $mes]));
        }
        if (session('tipo') == 'Docente') {
            return redirect(route('calendario-docentes.mostrar', [$institucion_id, $year, $mes]));
        }
        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            return redirect(route('calendario-alumnos.mostrar', [$institucion_id, $year, $mes]));
        }
        return redirect(route('inicio'));
        
    }

    public function mostrarCiclosLectivos()
    {
        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
            return redirect(route('ciclos-lectivos.index', $institucion_id));
        }
        return redirect(route('inicio'));
    }

    public function mostrarRoles()
    {
        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
            return redirect(route('roles.index', $institucion_id));
        }
        return redirect(route('inicio'));
    }

    public function mostrarPerfilInstitucional()
    {
        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
            return redirect(route('instituciones.show', $institucion_id));
        }
        return redirect(route('inicio'));
    }
}
