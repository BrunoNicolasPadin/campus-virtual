<?php

namespace App\Http\Controllers\Repitentes;

use App\Http\Controllers\Controller;
use App\Services\Estadisticas\ExAlumnosRepitentesService;
use Inertia\Inertia;

class RepitenteEstadisticaController extends Controller
{
    protected $estadisticasService;

    public function __construct(
        ExAlumnosRepitentesService $estadisticasService
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');

        $this->estadisticasService = $estadisticasService;
    }

    public function mostrarEstadisticas($institucion_id)
    {
        $ciclos = null;
        $ciclosCategorias = null;
        $divArray = null;
        $divisionCategorias = null;
        $tipo = 'Repitentes';
        
        $arregloTemporal = $this->estadisticasService->realizarEstadistica($institucion_id, $tipo);

        return Inertia::render('Repitentes/Estadisticas', [
            'institucion_id' => $institucion_id,
            'ciclos' => $arregloTemporal[0],
            'ciclosCategorias' => $arregloTemporal[1],
            'divisiones' => $arregloTemporal[2],
            'divisionCategorias' => $arregloTemporal[3],
        ]);
    }
}
