<?php

namespace App\Http\Controllers\Suscripciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuscripcionController extends Controller
{
    public function mostrarDetalles()
    {
        return Inertia::render('Suscripciones/Detalles');
    }
}
