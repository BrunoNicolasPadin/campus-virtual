<?php

namespace App\Jobs\Eliminaciones;

use App\Models\Asignaturas\Asignatura;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EliminarAsignatura implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $asignatura_id;

    public function __construct($asignatura_id)
    {
        $this->asignatura_id = $asignatura_id;
    }

    public function handle()
    {
        Asignatura::destroy($this->asignatura_id);
    }
}
