<?php

namespace App\Jobs\Eliminaciones;

use App\Models\Roles\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EliminarAlumno implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $alumno_id;

    public function __construct($alumno_id)
    {
        $this->alumno_id = $alumno_id;
    }

    public function handle()
    {
        Alumno::where('id', $this->alumno_id)
            ->update([
                'eliminada' => 1,
            ]);

        /* Alumno::destroy($this->alumno_id); */
    }
}
