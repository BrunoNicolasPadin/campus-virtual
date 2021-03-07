<?php

namespace App\Jobs\Muro;

use App\Models\Muro\Muro;
use App\Models\Muro\MuroArchivo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PublicacionDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $publicacion_id;

    public function __construct($publicacion_id)
    {
        $this->publicacion_id = $publicacion_id;
    }

    public function handle()
    {
        $archivos = MuroArchivo::where('muro_id', $this->publicacion_id)->get();
        foreach ($archivos as $archivo) {
            Storage::delete('public/Muro/' . $archivo->archivo);
        }
        Muro::destroy($this->publicacion_id);
    }
}
