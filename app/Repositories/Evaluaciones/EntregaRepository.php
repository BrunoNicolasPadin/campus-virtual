<?php

namespace App\Repositories\Evaluaciones;

use App\Models\Evaluaciones\Entrega;

class EntregaRepository
{
    public function find($id)
    {
        return Entrega::with(['alumno', 'alumno.user'])->findOrFail($id);
    }
}