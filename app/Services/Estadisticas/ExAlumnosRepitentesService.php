<?php

namespace App\Services\Estadisticas;

use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Repitentes\Repitente;
use App\Models\Roles\ExAlumno;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFecha;

class ExAlumnosRepitentesService
{
    protected $formatoService;
    protected $divisionService;
    protected $estadisticasService;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        DivisionService $divisionService,
    )

    {
        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
    }

    public function realizarEstadistica($institucion_id, $tipo)
    {
        $ciclosLectivos = CicloLectivo::select('id', 'comienzo', 'final')->where('institucion_id', $institucion_id)->get();
        $divisiones = $this->divisionService->get($institucion_id);

        if ($tipo == 'Ex Alumnos') {
            $arreglo = ExAlumno::where('institucion_id', $institucion_id)->where('abandono', 1)->get();
        }
        else {
            $arreglo = Repitente::where('institucion_id', $institucion_id)->get();
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