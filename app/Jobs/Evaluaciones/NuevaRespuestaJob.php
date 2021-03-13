<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Evaluaciones\EvaluacionRespuesta;
use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use App\Notifications\Evaluaciones\NuevaRespuestaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NuevaRespuestaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $respuesta;
    protected $tipo;

    public function __construct($respuesta, $tipo)
    {
        $this->respuesta = $respuesta;
        $this->tipo = $tipo;
    }

    public function handle()
    {
        $evaluacionRespuesta = EvaluacionRespuesta::select('asignaturas.nombre', 'users.name', 'evaluaciones.titulo', 
            'evaluaciones_comentarios.user_id')
            ->join('evaluaciones_comentarios', 'evaluaciones_comentarios.id', 'evaluaciones_respuestas.comentario_id')
            ->join('evaluaciones', 'evaluaciones.id', 'evaluaciones_comentarios.evaluacion_id')
            ->join('asignaturas', 'asignaturas.id', 'evaluaciones.asignatura_id')
            ->join('users', 'users.id', 'evaluaciones_respuestas.user_id')
            ->findOrFail($this->respuesta->id);

        if (!($evaluacionRespuesta->user_id == $this->respuesta->user_id)) {
            if (Institucion::where('user_id', $evaluacionRespuesta->user_id)->exists()) {
                $usuarioTipo = Institucion::where('user_id', $evaluacionRespuesta->user_id)->first();
            }

            if (Directivo::where('user_id', $evaluacionRespuesta->user_id)->exists()) {
                $usuarioTipo = Directivo::where('user_id', $evaluacionRespuesta->user_id)->first();
            }

            if (Docente::where('user_id', $evaluacionRespuesta->user_id)->exists()) {
                $usuarioTipo = Docente::where('user_id', $evaluacionRespuesta->user_id)->first();
            }

            if (Alumno::where('user_id', $evaluacionRespuesta->user_id)->exists()) {
                $usuarioTipo = Alumno::where('user_id', $evaluacionRespuesta->user_id)->first();
            }

            if (Padre::where('user_id', $evaluacionRespuesta->user_id)->exists()) {
                $usuarioTipo = Padre::where('user_id', $evaluacionRespuesta->user_id)->first();
            }
            Notification::send($usuarioTipo, new NuevaRespuestaNotification($evaluacionRespuesta));
        }
        //Faltaria avisarles a todos los que estan en las respuestas que no son ni el de la respuesta ni el del comentario pero que se jodan por metidos.
    }
}
