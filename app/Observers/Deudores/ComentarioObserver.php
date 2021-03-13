<?php

namespace App\Observers\Deudores;

use App\Jobs\Deudores\NuevoComentarioJob;
use App\Models\Deudores\RendirComentario;

class ComentarioObserver
{
    public function created(RendirComentario $rendirComentario)
    {
        $tipo = session('tipo');
        NuevoComentarioJob::dispatch($rendirComentario, $tipo);
        
    }
}
