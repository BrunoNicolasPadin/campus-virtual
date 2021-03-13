<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Roles\Alumno;
use App\Notifications\Evaluaciones\ActualizacionEntregaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ActualizacionEntregaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entrega;

    public function __construct($entrega)
    {
        $this->entrega = $entrega;
    }

    public function handle()
    {
        $alumnos = Alumno::findOrFail($this->entrega->alumno_id);
        Notification::send($alumnos, new ActualizacionEntregaNotification($this->entrega));
    }
}
