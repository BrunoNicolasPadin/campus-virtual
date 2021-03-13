<?php

namespace App\Jobs\Deudores;

use App\Models\Deudores\Inscripcion;
use App\Models\Roles\Alumno;
use App\Notifications\Deudores\ActualizacionMesaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ActualizacionMesaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mesa;

    public function __construct($mesa)
    {
        $this->mesa = $mesa;
    }

    public function handle()
    {
        $inscripciones = Inscripcion::where('mesa_id', $this->mesa->id)->get();
        foreach ($inscripciones as $inscripcion) {
            $alumno = Alumno::select('id')->findOrFail($inscripcion->alumno_id);
            Notification::send($alumno, new ActualizacionMesaNotification($this->mesa));
        }
    }
}
