<?php

namespace App\Providers;

use App\Models\Deudores\Anotado;
use App\Models\Evaluaciones\Entrega;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Libretas\Calificacion;
use App\Models\Repitentes\Repitente;
use App\Models\Roles\Alumno;
use App\Observers\AlumnoObserver;
use App\Observers\EntregaObserver;
use App\Observers\EvaluacionObserver;
use App\Observers\InscripcionObserver;
use App\Observers\LibretaObserver;
use App\Observers\RepitenteObserver;
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
        \App\Events\EntregaActualizada::class => [
            \App\Listeners\EnviarEmailEntrega::class,
        ],
        \App\Events\LibretaActualizada::class => [
            \App\Listeners\EnviarEmailLibreta::class,
        ],
        \App\Events\InscripcionActualizada::class => [
            \App\Listeners\EnviarEmailInscripcion::class,
        ],
        \App\Events\EvaluacionCreada::class => [
            \App\Listeners\EnviarEmailEvaluacionCreada::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Evaluacion::observe(EvaluacionObserver::class);
        Alumno::observe(AlumnoObserver::class);
        Repitente::observe(RepitenteObserver::class);
        Entrega::observe(EntregaObserver::class);
        Calificacion::observe(LibretaObserver::class);
        Anotado::observe(InscripcionObserver::class);
    }
}
