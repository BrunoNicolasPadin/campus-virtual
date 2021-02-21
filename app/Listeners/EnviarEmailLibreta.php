<?php

namespace App\Listeners;

use App\Events\LibretaActualizada;
use App\Mail\ActualizacionLibreta;
use App\Models\Libretas\Libreta;
use App\Models\Roles\Alumno;
use Illuminate\Support\Facades\Mail;

class EnviarEmailLibreta
{
    public function __construct()
    {
        //
    }

    public function handle(LibretaActualizada $event)
    {
        $libreta = Libreta::with(['alumno', 'alumno.user', 'alumno.padres', 'alumno.padres.user', 'asignatura'])->find($event->libreta->libreta_id);
        $to_email = $libreta->alumno->user->email;

        $detalles = [
            'titulo' => 'Nueva actualización en tu libreta',
            'email' => 'gescolcontacto@gmail.com',
            'mensaje' => 'En '. $libreta->asignatura->nombre .' para el '. $event->libreta->periodo .' la calificacion es: ' . $event->libreta->calificacion,
            'asunto' => 'Actualización en la libreta',
        ];
        
        Mail::to($to_email)->send(new ActualizacionLibreta($detalles));
        foreach ($libreta->alumno->padres as $padre) {

            $to_email = $padre->user->email;
            $detalles = [
                'titulo' => 'Nueva actualización en la libreta de tu hijo/a '. $libreta->alumno->user->name,
                'email' => 'gescolcontacto@gmail.com',
                'mensaje' => 'En '. $libreta->asignatura->nombre .' para el '. $event->libreta->periodo .' la calificacion es: ' . $event->libreta->calificacion,
                'asunto' => 'Actualización en la libreta',
            ];
            
            Mail::to($to_email)->send(new ActualizacionLibreta($detalles));
        }
    }
}
