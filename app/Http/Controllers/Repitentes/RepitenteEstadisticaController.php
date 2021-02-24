<?php

namespace App\Http\Controllers\Repitentes;

use App\Http\Controllers\Controller;
use App\Models\CiclosLectivos\CicloLectivo;
use App\Models\Repitentes\Repitente;
use App\Services\Division\DivisionService;
use App\Services\FechaHora\CambiarFormatoFecha;
use Inertia\Inertia;

class RepitenteEstadisticaController extends Controller
{
    protected $formatoService;
    protected $divisionService;

    public function __construct(
        CambiarFormatoFecha $formatoService,
        DivisionService $divisionService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');

        $this->formatoService = $formatoService;
        $this->divisionService = $divisionService;
    }

    public function mostrarEstadisticas($institucion_id)
    {
        $ciclosLectivos = CicloLectivo::where('institucion_id', $institucion_id)->get();
        $divisiones = $this->divisionService->get($institucion_id);

        $repitentes = Repitente::where('institucion_id', $institucion_id)
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

        foreach ($repitentes as $repitente) {
        
            $ciclos[$repitente->ciclo_lectivo_id]++;
            $divArray[$repitente->division_id]++;
        }

        $ciclos = array_values($ciclos);
        $divArray = array_values($divArray);

        return Inertia::render('Repitentes/Estadisticas', [
            'institucion_id' => $institucion_id,
            'ciclos' => $ciclos,
            'ciclosCategorias' => $ciclosCategorias,
            'divisiones' => $divArray,
            'divisionCategorias' => $divisionCategorias,
        ]);
    }
}
