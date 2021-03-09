<?php

namespace App\Jobs\Eliminaciones;

use App\Models\Estructuras\Division;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EliminarDivision implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $division_id;

    public function __construct($division_id)
    {
        $this->division_id = $division_id;
    }

    public function handle()
    {
        Division::destroy($this->division_id);
    }
}
