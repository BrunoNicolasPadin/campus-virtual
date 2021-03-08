<?php

namespace App\Services\Estadisticas;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\FechaHora\CambiarFormatoFecha;
use Illuminate\Support\Facades\DB;

class ExAlumnosRepitentesService
{
    protected $formatoService;
    protected $divisionRepository;
    protected $estadisticasService;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        DivisionRepository $divisionRepository,
    )

    {
        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
    }

    public function realizarEstadistica($institucion_id, $tipo)
    {
        $ciclosLectivos = CicloLectivo::select('id', 'comienzo', 'final')->where('institucion_id', $institucion_id)->get();
        $divisiones = $this->divisionRepository->get($institucion_id);

        if ($tipo == 'Ex Alumnos') {
            $arreglo = DB::table('ex_alumnos')->where('institucion_id', $institucion_id)->where('abandono', 1)->get();
        }
        else {
            $arreglo = DB::table('repitentes')->where('institucion_id', $institucion_id)->get();
        }
        $ciclos = [];
        $ciclosCategorias = [];
        
        $k = 0;
        foreach ($ciclosLectivos as $cicloLectivo) {
            $ciclosCategorias[$k] = $this->formatoService->cambiarFormatoParaMostrar($cicloLectivo->comienzo) . ' - ' . 
            $this->formatoService->cambiarFormatoParaMostrar($cicloLectivo->final);

            $ciclos[$cicloLectivo->id] = 0;
            $k++;
        }

        $divArray = [];
        $divisionCategorias = [];
        $k = 0;
        foreach ($divisiones as $division) {
            if ($division->orientacion_nombre) {
                $divisionCategorias[$k] = $division->nivel_nombre .' - ' . $division->orientacion_nombre .' - '. 
                $division->curso_nombre .' - '. $division->division;
            }
            else {
                $divisionCategorias[$k] = $division->nivel_nombre .' - ' . $division->curso_nombre .' - '. $division->division;
            }
            $divArray[$division->id] = 0;
            $k++;
        }

        foreach ($arreglo as $arr) {
        
            $ciclos[$arr->ciclo_lectivo_id]++;
            $divArray[$arr->division_id]++;
        }

        $ciclos = array_values($ciclos);
        $divArray = array_values($divArray);

        return [$ciclos, $ciclosCategorias, $divArray, $divisionCategorias];
    }
}