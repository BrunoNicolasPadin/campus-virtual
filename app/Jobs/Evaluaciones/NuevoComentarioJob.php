<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Models\Roles\Docente;
use App\Notifications\Evaluaciones\NuevoComentarioNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NuevoComentarioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comentario;

    public function __construct($comentario)
    {
        $this->comentario = $comentario;
    }

    public function handle()
    {
        $evaluacionComentario = EvaluacionComentario::select('evaluaciones.asignatura_id', 'asignaturas.nombre', 
            'users.name', 'evaluaciones.titulo')
            ->join('evaluaciones', 'evaluaciones.id', 'evaluaciones_comentarios.evaluacion_id')
            ->join('asignaturas', 'asignaturas.id', 'evaluaciones.asignatura_id')
            ->join('users', 'users.id', 'evaluaciones_comentarios.user_id')
            ->findOrFail($this->comentario->id);

        $docentes = AsignaturaDocente::select('docente_id')->where('asignatura_id', $evaluacionComentario->asignatura_id)->get();
        foreach ($docentes as $docente) {
            $docente = Docente::select('id', 'user_id')->findOrFail($docente->docente_id);
            if (!($docente->user_id == $this->comentario->user_id)) {
                Notification::send($docente, new NuevoComentarioNotification($evaluacionComentario));
            }
        }
    }
}
