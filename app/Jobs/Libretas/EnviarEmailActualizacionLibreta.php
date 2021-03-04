<?php

namespace App\Jobs;

use App\Events\LibretaActualizada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarEmailActualizacionLibreta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $calificacion;

    public function __construct($calificacion)
    {
        $this->calificacion = $calificacion;
    }

    public function handle()
    {
        event(new LibretaActualizada($this->calificacion));
    }
}
