<?php

namespace App\Jobs\Deudores;

use App\Models\Instituciones\Institucion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EliminarInstitucion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $institucion_id;

    public function __construct($institucion_id)
    {
        $this->institucion_id = $institucion_id;
    }

    public function handle()
    {
        Institucion::destroy($this->institucion_id);
    }
}
