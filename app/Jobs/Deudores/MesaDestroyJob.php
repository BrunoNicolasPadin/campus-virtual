<?php

namespace App\Jobs\Deudores;

use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MesaDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mesa_id;

    public function __construct($mesa_id)
    {
        $this->mesa_id = $mesa_id;
    }

    public function handle()
    {
        $archivos = MesaArchivo::where('mesa_id', $this->mesa_id)->get();

        foreach ($archivos as $archivo) {
            Storage::delete('public/Mesas/Archivos/' . $archivo->archivo);
        }

        $inscripciones = Inscripcion::where('mesa_id', $this->mesa_id)->get();

        foreach ($inscripciones as $inscripcion) {
            
            $this->dispatch(new InscripcionDestroyJob($inscripcion->id));
        }

        Mesa::destroy($this->mesa_id);
    }
}
