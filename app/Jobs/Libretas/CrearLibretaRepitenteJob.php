<?php

namespace App\Jobs\Libretas;

use App\Models\Asignaturas\Asignatura;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Libretas\Calificacion;
use App\Models\Libretas\Libreta;
use App\Repositories\Libretas\LibretaRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrearLibretaRepitenteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $repitente;

    public function __construct($repitente)
    {
        $this->repitente = $repitente;
    }

    public function handle()
    {
        $libretaRepository = new LibretaRepository();

        $cicloLectivo = CicloLectivo::where('institucion_id', $this->repitente->institucion_id)->where('activado', '1')->first();
        $this->eliminarLibretas($cicloLectivo->id, $this->repitente->alumno_id);

        $asignaturas = Asignatura::where('division_id', $this->repitente->division_id)->get();
        $division = Division::find($this->repitente->division_id);
        $periodos = [];
        $periodos = $libretaRepository->obtenerPeriodos($division);

        foreach ($asignaturas as $asignatura) {

            $libreta = new Libreta();
            $libreta->alumno()->associate($this->repitente->alumno_id);
            $libreta->cicloLectivo()->associate($cicloLectivo->id);
            $libreta->division()->associate($division->id);
            $libreta->asignatura()->associate($asignatura->id);
            $libreta->periodo()->associate($division->periodo_id);
            $libreta->save();

            for ($k=0; $k < count($periodos); $k++) { 
                $calificacion = new Calificacion();
                $calificacion->libreta()->associate($libreta);
                $calificacion->periodo = $periodos[$k];
                $calificacion->save();
            }
        }
    }

    public function eliminarLibretas($ciclo_lectivo_id, $alumno_id)
    {
        $libretas = Libreta::where('alumno_id', $alumno_id)->where('ciclo_lectivo_id', $ciclo_lectivo_id)->get();
        
        foreach ($libretas as $libreta) {
            Libreta::destroy($libreta->id);
        }
    }
}
