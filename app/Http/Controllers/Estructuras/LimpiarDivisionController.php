<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Estructuras\LimpiezaValidation;
use App\Jobs\Estructuras\LimpiarDivisiones;
use App\Models\Estructuras\Division;
use App\Services\Archivos\EliminarEntregasCorrecciones;
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
        /* for ($i=0; $i < count($request->division_id); $i++) { 
            $this->limpiarMuro($request->division_id[$i]);
            $this->limpiarEvaluaciones($request->division_id[$i]);
        } */

        LimpiarDivisiones::dispatch($institucion_id, $request->all());
        return back()->with(['successMessage' => 'Divisiones limpiadas con éxito!']);
    }

    /* public function limpiarMuro($division_id)
    {
        $publicaciones = Muro::where('division_id', $division_id)->get();
        foreach ($publicaciones as $publicacion) {

            $archivos = MuroArchivo::where('muro_id', $publicacion->id)->get();
            foreach ($archivos as $archivo) {
                
                Storage::delete('public/Muro/' . $archivo->archivo);
            }

            Muro::destroy($publicacion->id);
        }
    }

    public function limpiarEvaluaciones($division_id)
    {
        $evaluaciones = Evaluacion::where('division_id', $division_id)->get();

        foreach ($evaluaciones as $evaluacion) {

            $this->archivosEvaServices->eliminarEntregasCorrecciones($evaluacion->id);
            Evaluacion::destroy($evaluacion->id);
        }
    } */
}
