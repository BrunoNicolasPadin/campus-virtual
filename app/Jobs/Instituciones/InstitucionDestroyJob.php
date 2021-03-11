<?php

namespace App\Jobs\Instituciones;

use App\Jobs\Deudores\EliminarInstitucion;
use App\Jobs\Estructuras\DivisionDestroyJob;
use App\Models\Estructuras\Division;
use App\Models\Instituciones\Institucion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InstitucionDestroyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $institucion_id;

    public function __construct($institucion_id)
    {
        $this->institucion_id = $institucion_id;
    }

    public function handle()
    {
        $divisiones = Division::where('institucion_id', $this->institucion_id)->get();
        foreach ($divisiones as $division) {
            $this->dispatch(new DivisionDestroyJob($division->id));
        }
        $institucion = Institucion::findOrFail($this->institucion_id);
        Storage::delete('public/PlanesDeEstudio/' . $institucion->planDeEstudio);

        EliminarInstitucion::dispatch($this->institucion_id);
    }
}
