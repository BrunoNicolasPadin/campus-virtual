<?php

namespace App\Jobs\Deudores;

use App\Models\Roles\Alumno;
use App\Notifications\Deudores\NuevaAsignaturaAdeudadaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NuevaAsignaturaAdeudadaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $alumnoDeudor;

    public function __construct($alumnoDeudor)
    {
        $this->alumnoDeudor = $alumnoDeudor;
    }

    public function handle()
    {
        $alumno = Alumno::select('id')->findOrFail($this->alumnoDeudor->alumno_id);
        Notification::send($alumno, new NuevaAsignaturaAdeudadaNotification($this->alumnoDeudor));
    }
}
