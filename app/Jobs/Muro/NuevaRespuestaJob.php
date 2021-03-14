<?php

namespace App\Jobs\Muro;

use App\Models\Instituciones\Institucion;
use App\Models\Muro\MuroRespuesta;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use App\Notifications\Muro\NuevaRespuestaNotification;
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
        $muroRespuesta = MuroRespuesta::select('muro.user_id', 'users.name', 'muro_respuestas.muro_id', 'divisiones.institucion_id')
            ->join('muro', 'muro.id', 'muro_respuestas.muro_id')
            ->join('divisiones', 'divisiones.id', 'muro.division_id')
            ->join('users', 'users.id', 'muro_respuestas.user_id')
            ->findOrFail($this->respuesta->id);
        $usuarioTipo = '';

        if (!($muroRespuesta->user_id == $this->respuesta->user_id)) {
            if (Institucion::where('user_id', $muroRespuesta->user_id)->exists()) {
                $usuarioTipo = Institucion::where('id', $muroRespuesta->institucion_id)->where('user_id', $muroRespuesta->user_id)->first();
            }
    
            if (Directivo::where('user_id', $muroRespuesta->user_id)->exists()) {
                $usuarioTipo = Directivo::where('institucion_id', $muroRespuesta->institucion_id)->where('user_id', $muroRespuesta->user_id)->first();
            }
    
            if (Docente::where('user_id', $muroRespuesta->user_id)->exists()) {
                $usuarioTipo = Docente::where('institucion_id', $muroRespuesta->institucion_id)->where('user_id', $muroRespuesta->user_id)->first();
            }
    
            if (Alumno::where('user_id', $muroRespuesta->user_id)->exists()) {
                $usuarioTipo = Alumno::where('institucion_id', $muroRespuesta->institucion_id)->where('user_id', $muroRespuesta->user_id)->first();
            }
    
            if (Padre::where('user_id', $muroRespuesta->user_id)->exists()) {
                $usuarioTipo = Padre::where('institucion_id', $muroRespuesta->institucion_id)->where('user_id', $muroRespuesta->user_id)->first();
            }
            Notification::send($usuarioTipo, new NuevaRespuestaNotification($muroRespuesta));
        }
    }
}
