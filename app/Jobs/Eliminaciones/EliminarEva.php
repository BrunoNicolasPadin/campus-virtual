<?php

namespace App\Jobs\Eliminaciones;

use App\Models\Evaluaciones\Evaluacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EliminarEva implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $evaluacion_id;

    public function __construct($evaluacion_id)
    {
        $this->evaluacion_id = $evaluacion_id;
    }

    public function handle()
    {
        Evaluacion::destroy($this->evaluacion_id);
    }
}
