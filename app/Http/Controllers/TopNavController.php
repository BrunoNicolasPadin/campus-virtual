<?php

namespace App\Http\Controllers;

class TopNavController extends Controller
{
    public function mostrarDivisiones()
    {
        $institucion_id = 0;

        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }
        return redirect(route('divisiones.index', $institucion_id));
    }

    public function mostrarCalendario()
    {
        $institucion_id = 0;

        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }

        $year = 2021;

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            return redirect(route('calendario-instituciones.mostrar', [$institucion_id, $year]));
        }
        if (session('tipo') == 'Docente') {
            return redirect(route('calendario-docentes.mostrar', [$institucion_id, $year]));
        }
        if (session('tipo') == 'Alumno' || session('tipo') == 'Padre') {
            return redirect(route('calendario-alumnos.mostrar', [$institucion_id, $year]));
        }
        return redirect('inicio');
        
    }

    public function mostrarCiclosLectivos()
    {
        $institucion_id = 0;

        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }
        return redirect(route('ciclos-lectivos.index', $institucion_id));
    }

    public function mostrarRoles()
    {
        $institucion_id = 0;

        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }
        return redirect(route('roles.index', $institucion_id));
    }

    public function mostrarPerfilInstitucional()
    {
        $institucion_id = 0;

        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }
        return redirect(route('instituciones.show', $institucion_id));
    }
}
