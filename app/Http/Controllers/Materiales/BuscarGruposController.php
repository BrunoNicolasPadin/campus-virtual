<?php

namespace App\Http\Controllers\Materiales;

use App\Http\Controllers\Controller;
use App\Models\Materiales\Grupo;
use Illuminate\Http\Request;

class BuscarGruposController extends Controller
{
    public function filtrarPorAsignaturas($institucion_id, $division_id, Request $filtros)
    {
        return Grupo::where('division_id', $division_id)
        ->when($filtros->asignatura_id, function ($query, $asignatura_id) {
            return $query->where('asignatura_id', $asignatura_id);
        })
        ->with('asignatura')
        ->paginate(20);
    }
}
