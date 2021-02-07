<?php

namespace App\Http\Controllers\Repetidores;

use App\Http\Controllers\Controller;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Estructuras\Division;
use App\Models\Repetidores\Repetidor;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class RepetidorEstadisticaController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFecha $formatoService)
    {
        $this->formatoService = $formatoService;
    }

    public function mostrarEstadisticas($institucion_id)
    {
        $ciclosLectivos = CicloLectivo::where('institucion_id', $institucion_id)->get();
        $divisiones = Division::where('institucion_id', $institucion_id)->get();

        $repetidores = Repetidor::where('institucion_id', $institucion_id)
        ->with(['ciclo_lectivo', 'division', 'division.nivel', 'division.orientacion', 'division.curso'])
        ->get();
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
            if ($division->orientacion) {
                $divisionCategorias[$k] = $division->nivel->nombre .' - '. $division->orientacion->nombre .' - '. 
                $division->curso->nombre .' - '. $division->division;
            }
            else {
                $divisionCategorias[$k] = $division->nivel->nombre .' - '. $division->curso->nombre .' - '. $division->division;
            }
            $divArray[$division->id] = 0;
            $k++;
        }

        foreach ($repetidores as $repetidor) {
        
            $ciclos[$repetidor->ciclo_lectivo_id]++;
            $divArray[$repetidor->division_id]++;
        }

        $ciclos = array_values($ciclos);
        $divArray = array_values($divArray);

        return Inertia::render('Repetidores/Estadisticas', [
            'institucion_id' => $institucion_id,
            'ciclos' => $ciclos,
            'ciclosCategorias' => $ciclosCategorias,
            'divisiones' => $divArray,
            'divisionCategorias' => $divisionCategorias,
        ]);
    }
}