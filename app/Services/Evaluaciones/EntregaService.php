<?php

namespace App\Services\Evaluaciones;

use App\Models\Evaluaciones\Entrega;

class EntregaService
{
    public function find($id)
    {
        return Entrega::with(['alumno', 'alumno.user'])->findOrFail($id);
    }
}