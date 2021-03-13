<?php

namespace App\Observers\Muro;

use App\Jobs\Muro\NuevaPublicacionJob;
use App\Models\Muro\Muro;
use Illuminate\Support\Facades\Auth;

class MuroObserver
{
    public function created(Muro $muro)
    {
        $tipo = session('tipo');
        NuevaPublicacionJob::dispatch($muro, $tipo);
    }
}
