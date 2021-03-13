<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Roles\Alumno;
use App\Notifications\Evaluaciones\EvaluacionNuevaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NuevaEvaluacionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $evaluacion;

    public function __construct($evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }

    public function handle()
    {
        $alumnos = Alumno::where('division_id', $this->evaluacion->division_id)->get();
        Notification::send($alumnos, new EvaluacionNuevaNotification($this->evaluacion));
    }
}
