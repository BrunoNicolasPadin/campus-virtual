<?php

namespace App\Jobs\Materiales;

use App\Models\Materiales\Grupo;
use App\Models\Materiales\Material;
use App\Services\Archivos\EliminarGruposMateriales;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GrupoDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $grupo_id;
    
    public function __construct($grupo_id)
    {
        $this->grupo_id = $grupo_id;
    }

    public function handle()
    {
        /* $gruposMaterialesService = new EliminarGruposMateriales(); */
        
        $materiales = Material::where('grupo_id', $this->grupo_id)->get();
        foreach ($materiales as $material) {
            Storage::delete('public/Materiales/' . $material->archivo);
        }
        /* $gruposMaterialesService->eliminarGruposMateriales($this->grupo_id); */
        Grupo::destroy($this->grupo_id);
        
    }
}
