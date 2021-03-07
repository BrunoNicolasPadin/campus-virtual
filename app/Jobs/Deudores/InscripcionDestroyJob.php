<?php

namespace App\Jobs\Deudores;

use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\RendirCorreccion;
use App\Models\Deudores\RendirEntrega;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InscripcionDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inscripcion_id;

    public function __construct($inscripcion_id)
    {
        $this->inscripcion_id = $inscripcion_id;
    }

    public function handle()
    {
        $entregas = RendirEntrega::where('inscripcion_id', $this->inscripcion_id)->get();
        $correcciones = RendirCorreccion::where('inscripcion_id', $this->inscripcion_id)->get();

        foreach ($entregas as $entrega) {
            Storage::delete('public/Deudores/Entregas/' . $entrega->archivo);
        }

        foreach ($correcciones as $correccion) {
            Storage::delete('public/Deudores/Correcciones/' . $correccion->archivo);
        }

        Inscripcion::destroy($this->inscripcion_id);
    }
}
