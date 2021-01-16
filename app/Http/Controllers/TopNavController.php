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
