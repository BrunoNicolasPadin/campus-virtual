<?php

namespace App\Http\Controllers\ExAlumnos;

use App\Http\Controllers\Controller;
use App\Services\Estadisticas\ExAlumnosRepitentesService;
use Inertia\Inertia;

class ExAlumnoEstadisticaController extends Controller
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
        $tipo = 'Ex Alumnos';
        
        $arregloTemporal = $this->estadisticasService->realizarEstadistica($institucion_id, $tipo);

        return Inertia::render('ExAlumnos/Estadisticas', [
            'institucion_id' => $institucion_id,
            'ciclos' => $arregloTemporal[0],
            'ciclosCategorias' => $arregloTemporal[1],
            'divisiones' => $arregloTemporal[2],
            'divisionCategorias' => $arregloTemporal[3],
        ]);
        
    }
}
