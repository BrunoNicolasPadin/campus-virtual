<?php

namespace App\Repositories\Asignaturas;

use App\Models\Asignaturas\Asignatura;

class AsignaturaRepository
{
    public function find($id)
    {
        return Asignatura::select('id', 'nombre')->findOrFail($id);
    }

    public function get($division_id)
    {
        return Asignatura::where('division_id', $division_id)
            ->orderBy('nombre')
            ->get();
    }
}