<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuscadorDeInstitucionesController extends Controller
{
    public function buscar(Request $request)
    {
        return Inertia::render('Instituciones/Buscador', [
            'usuarios' => User::where('tipo', 'Institucion')
                ->with('instituciones')
                ->when($request->nombre, function($query, $nombre) {
                    $query->where('name', 'LIKE', '%'.$nombre.'%');
                })
                ->orderBy('name')
                ->get()
        ]);
    }
}
