<?php

namespace App\Jobs\Evaluaciones;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Evaluaciones\EntregaComentario;
use App\Models\Roles\Alumno;
use App\Models\Roles\Docente;
use App\Notifications\Evaluaciones\NuevoComentarioEntregaNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class NuevoEntregaComentarioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $comentario;
    protected $tipo;

    public function __construct($comentario, $tipo)
    {
        $this->comentario = $comentario;
        $this->tipo = $tipo;
    }

    public function handle()
    {
        $entregaComentario = EntregaComentario::select('evaluaciones.asignatura_id', 'asignaturas.nombre', 'users.name', 
            'entregas.alumno_id', 'evaluaciones.titulo')
            ->with(['entrega', 'entrega.evaluacion', 'entrega.evaluacion.asignatura', 'user'])
            ->join('entregas', 'entregas.id', 'entregas_comentarios.entrega_id')
            ->join('evaluaciones', 'evaluaciones.id', 'entregas.evaluacion_id')
            ->join('asignaturas', 'asignaturas.id', 'evaluaciones.asignatura_id')
            ->join('users', 'users.id', 'entregas_comentarios.user_id')
            ->findOrFail($this->comentario->id);


        if ($this->tipo == 'Alumno') {
            $docentes = AsignaturaDocente::select('docente_id')->where('asignatura_id', $entregaComentario->asignatura_id)->get();
            foreach ($docentes as $docente) {
                $docente = Docente::select('id')->findOrFail($docente->docente_id);
                Notification::send($docente, new NuevoComentarioEntregaNotification($entregaComentario));
            }
        }
        if ($this->tipo == 'Docente') {
            $alumno = Alumno::select('id')->findOrFail($entregaComentario->alumno_id);
            Notification::send($alumno, new NuevoComentarioEntregaNotification($entregaComentario));
        }
    }
}
