<?php

namespace App\Services\Archivos;

use App\Models\Materiales\Material;
use Illuminate\Support\Facades\Storage;

class EliminarGruposMateriales
{
    public function eliminarGruposMateriales($grupo_id)
    {
        $materiales = Material::where('grupo_id', $grupo_id)->get();
        foreach ($materiales as $material) {
            Storage::delete('public/Materiales/' . $material->archivo);
        }
    }
}