<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Evaluaciones\Correccion;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\EntregaArchivo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class EntregaDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entrega_id;

    public function __construct($entrega_id)
    {
        $this->entrega_id = $entrega_id;
    }

    public function handle()
    {
        $entregasArchivos = EntregaArchivo::where('entrega_id', $this->entrega_id)->get();
        $correcciones = Correccion::where('entrega_id', $this->entrega_id)->get();

        foreach ($entregasArchivos as $entrega) {
            Storage::disk('s3')->delete('Evaluaciones/Entregas/' . $entrega->archivo);
        }

        foreach ($correcciones as $correccion) {
            Storage::disk('s3')->delete('Evaluaciones/Correcciones/' . $correccion->archivo);
        }

        Entrega::destroy($this->entrega_id);
    }
}
