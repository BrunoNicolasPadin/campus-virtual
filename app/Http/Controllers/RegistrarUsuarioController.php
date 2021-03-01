<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RegistrarUsuarioController extends Controller
{
    public function mostrarFormulario()
    {
        return Inertia::render('Auth/Registrarse');
    }
}
