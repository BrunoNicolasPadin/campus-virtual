<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estructuras\LimpiezaValidation;
use App\Jobs\Estructuras\LimpiarDivisionesJob;
use App\Models\Estructuras\Division;
use Inertia\Inertia;

class LimpiarDivisionController extends Controller
{
    public function __construct()

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('soloInstitucionesDirectivos');
    }

    public function mostrarDivisiones($institucion_id)
    {
        $divisiones = Division::select('divisiones.id', 'divisiones.division', 'niveles.nombre AS nivel_nombre', 
            'orientaciones.nombre AS orientacion_nombre', 'cursos.nombre AS curso_nombre')
            ->where('institucion_id', $institucion_id)
            ->join('niveles', 'niveles.id', 'divisiones.nivel_id')
            ->leftjoin('orientaciones', 'orientaciones.id', 'divisiones.orientacion_id')
            ->join('cursos', 'cursos.id', 'divisiones.curso_id')
            ->orderBy('divisiones.nivel_id')
            ->orderBy('divisiones.curso_id')
            ->orderBy('divisiones.division')
            ->orderBy('divisiones.orientacion_id')
            ->get();

        return Inertia::render('Estructuras/LimpiarDivisiones', [
            'institucion_id' => $institucion_id,
            'divisiones' => $divisiones,
        ]);
    }

    public function limpiarDivisiones($institucion_id, LimpiezaValidation $request)
    {
        for ($i=0; $i < count($request['division_id']); $i++) { 
            LimpiarDivisionesJob::dispatch($request['division_id'][$i]);
        }
        
        return back()->with(['successMessage' => 'Divisiones limpiadas con éxito!']);
    }
}
