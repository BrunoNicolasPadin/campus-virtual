<?php

namespace App\Providers;

use App\Models\Deudores\AlumnoDeudor;
use App\Models\Deudores\Inscripcion;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\RendirComentario;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\EntregaComentario;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Evaluaciones\EvaluacionComentario;
use App\Models\Evaluaciones\EvaluacionRespuesta;
use App\Models\Libretas\Calificacion;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroRespuesta;
use App\Models\Repitentes\Repitente;
use App\Models\Roles\Alumno;
use App\Observers\Alumnos\AlumnoObserver;
use App\Observers\Deudores\AlumnoDeudorObserver;
use App\Observers\Deudores\ComentarioObserver;
use App\Observers\Deudores\InscripcionObserver;
use App\Observers\Deudores\MesaObserver;
use App\Observers\Evaluaciones\EntregaComentarioObserver;
use App\Observers\Evaluaciones\EntregaObserver;
use App\Observers\Evaluaciones\EvaluacionComentarioObserver;
use App\Observers\Evaluaciones\EvaluacionObserver;
use App\Observers\Evaluaciones\EvaluacionRespuestaObserver;
use App\Observers\Libretas\LibretaObserver;
use App\Observers\Muro\MuroObserver;
use App\Observers\Muro\MuroRespuestaObserver;
use App\Observers\Repitentes\RepitenteObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Alumno::observe(AlumnoObserver::class);
        AlumnoDeudor::observe(AlumnoDeudorObserver::class);
        RendirComentario::observe(ComentarioObserver::class);
        Inscripcion::observe(InscripcionObserver::class);
        Mesa::observe(MesaObserver::class);
        EntregaComentario::observe(EntregaComentarioObserver::class);
        EvaluacionComentario::observe(EvaluacionComentarioObserver::class);
        Entrega::observe(EntregaObserver::class);
        Evaluacion::observe(EvaluacionObserver::class);
        EvaluacionRespuesta::observe(EvaluacionRespuestaObserver::class);
        Calificacion::observe(LibretaObserver::class);
        MuroRespuesta::observe(MuroRespuestaObserver::class);
        Muro::observe(MuroObserver::class);
        Repitente::observe(RepitenteObserver::class);
    }
}
