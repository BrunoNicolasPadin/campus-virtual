<?php

namespace App\Jobs\Deudores;

use App\Models\Deudores\Mesa;
use App\Models\Roles\Alumno;
use App\Notifications\Deudores\ActualizacionInscripcionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ActualizacionInscripcionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inscripcion;

    public function __construct($inscripcion)
    {
        $this->inscripcion = $inscripcion;
    }

    public function handle()
    {
        $alumno = Alumno::findOrFail($this->inscripcion->alumno_id);
        Notification::send($alumno, new ActualizacionInscripcionNotification($this->inscripcion));
    }
}
