<?php

namespace App\Jobs\Deudores;

use App\Models\Asignaturas\AsignaturaDocente;
use App\Models\Deudores\RendirComentario;
use App\Models\Roles\Alumno;
use App\Models\Roles\Docente;
use App\Notifications\Deudores\NuevoComentarioNotification;
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
    protected $tipo;

    public function __construct($comentario, $tipo)
    {
        $this->comentario = $comentario;
        $this->tipo = $tipo;
    }

    public function handle()
    {
        $comentarioInscripcion = RendirComentario::select('mesas.asignatura_id', 'asignaturas.nombre', 'users.name', 'inscripciones.alumno_id', 
            'mesas.fechaHoraRealizacion')
            ->join('inscripciones', 'inscripciones.id', 'rendir_comentarios.inscripcion_id')
            ->join('mesas', 'mesas.id', 'inscripciones.mesa_id')
            ->join('asignaturas', 'asignaturas.id', 'mesas.asignatura_id')
            ->join('users', 'users.id', 'rendir_comentarios.user_id')
            ->findOrFail($this->comentario->id);

        if ($this->tipo == 'Alumno') {
            $docentes = AsignaturaDocente::select('docente_id')->where('asignatura_id', $comentarioInscripcion->asignatura_id)->get();
            foreach ($docentes as $docente) {
                $docente = Docente::select('id')->findOrFail($docente->docente_id);
                Notification::send($docente, new NuevoComentarioNotification($comentarioInscripcion));
            }
        }
        if ($this->tipo == 'Docente') {
            $alumno = Alumno::select('id')->findOrFail($comentarioInscripcion->alumno_id);
            Notification::send($alumno, new NuevoComentarioNotification($comentarioInscripcion));
        }
    }
}
