<?php

namespace App\Jobs;

use App\Mail\ActualizacionLibreta;
use App\Models\Libretas\Libreta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarEmailActualizacionLibretaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $calificacion;

    public function __construct($calificacion)
    {
        $this->calificacion = $calificacion;
    }

    public function handle()
    {
        $libreta = Libreta::with(['alumno', 'alumno.user', 'alumno.padres', 'alumno.padres.user', 'asignatura'])->find($this->calificacion->libreta_id);
        $to_email = $libreta->alumno->user->email;

        $email = 'gescolcontacto@gmail.com';
        $mensaje = 'En '. $libreta->asignatura->nombre .' para el '. $this->calificacion->periodo .' la calificacion es: ' . $this->calificacion->calificacion;
        $asunto = 'Actualización en la libreta';

        $detalles = [
            'titulo' => 'Nueva actualización en tu libreta',
            'email' => $email,
            'mensaje' => $mensaje,
            'asunto' => $asunto,
        ];
        
        Mail::to($to_email)->send(new ActualizacionLibreta($detalles));

        foreach ($libreta->alumno->padres as $padre) {

            $to_email = $padre->user->email;
            $detalles = [
                'titulo' => 'Nueva actualización en la libreta de tu hijo/a '. $libreta->alumno->user->name,
                'email' => $email,
                'mensaje' => $mensaje,
                'asunto' => $asunto,
            ];
            
            Mail::to($to_email)->send(new ActualizacionLibreta($detalles));
        }
    }
}
