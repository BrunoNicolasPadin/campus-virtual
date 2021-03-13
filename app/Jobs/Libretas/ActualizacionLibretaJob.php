<?php

namespace App\Jobs\Libretas;

use App\Models\Libretas\Libreta;
use App\Notifications\Libretas\ActualizacionLibretaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class ActualizacionLibretaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $calificacion;

    public function __construct($calificacion)
    {
        $this->calificacion = $calificacion;
    }

    public function handle()
    {
        $libreta = Libreta::with(['alumno', 'asignatura'])->find($this->calificacion->libreta_id);
        Notification::send($libreta->alumno, new ActualizacionLibretaNotification($this->calificacion));
    }
}
