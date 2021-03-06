<?php

namespace App\Observers\Repitentes;

use App\Jobs\Libretas\CrearLibretaRepitenteJob;
use App\Models\Repitentes\Repitente;

class RepitenteObserver
{
    public function created(Repitente $repitente)
    {
        CrearLibretaRepitenteJob::dispatch($repitente);
    }

    public function updated(Repitente $repitente)
    {
        if ($repitente->isDirty('division_id')) {
            CrearLibretaRepitenteJob::dispatch($repitente);
        }
    }
}
