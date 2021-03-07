<?php

namespace App\Jobs\Deudores;

use App\Mail\ActualizacionInscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Roles\Alumno;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarEmailActualizacionInscripcionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inscripcion;

    public function __construct($inscripcion)
    {
        $this->inscripcion = $inscripcion;
    }

    public function handle()
    {
        $alumno = Alumno::with('padres', 'padres.user')->find($this->inscripcion->alumno_id);
        $to_email = $alumno->user->email;
        $mesa = Mesa::with('asignatura')->findOrFail($this->inscripcion->mesa_id);

        $email = 'gescolcontacto@gmail.com';
        $mensaje = 'Tu calificacion: ' . $this->inscripcion->calificacion . ' | Comentario: ' . $this->inscripcion->comentario;
        $asunto = 'Actualización en la entraga de la asignatura ' . $mesa->asignatura->nombre .' que adeudada.';

        $detalles = [
            'titulo' => 'Nueva actualización en tu entrega en la asignatura que adeudas ' . $mesa->asignatura->nombre,
            'email' => $email,
            'mensaje' => $mensaje,
            'asunto' => $asunto,
        ];

        Mail::to($to_email)->send(new ActualizacionInscripcion($detalles));

        foreach ($alumno->padres as $padre) {

            $to_email = $padre->user->email;
            $detalles = [
                'titulo' => 'Nueva actualización en la entrega de '. $alumno->user->name.  'en la asignatura ' . $mesa->asignatura->nombre .' que adeudada.',
                'email' => $email,
                'mensaje' => $mensaje,
                'asunto' => $asunto,
            ];
            
            Mail::to($to_email)->send(new ActualizacionInscripcion($detalles));
        }
    }
}
