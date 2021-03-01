<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InicioController extends Controller
{
    public function mostrarInicio()
    {
        $autenticado = false;
        if (Auth::check()) {
            $autenticado = true;
        }

        return Inertia::render('Inicio', [
            'autenticado' => $autenticado,
        ]);

    }
}
