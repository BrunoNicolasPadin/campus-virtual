<?php

namespace App\Jobs\Deudores;

use App\Models\Deudores\Mesa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EliminarMesa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mesa_id;

    public function __construct($mesa_id)
    {
        $this->mesa_id = $mesa_id;
    }

    public function handle()
    {
        Mesa::destroy($this->mesa_id);
    }
}
