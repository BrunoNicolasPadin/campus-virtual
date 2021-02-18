<?php

namespace App\Http\Controllers\Estructuras;

use App\Http\Controllers\Controller;
use App\Models\Evaluaciones\Evaluacion;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroArchivo;
use App\Services\Archivos\EliminarEntregasCorrecciones;
use Illuminate\Support\Facades\Storage;

class LimpiarDivisionController extends Controller
{
    protected $archivosEvaServices;

    public function __construct(EliminarEntregasCorrecciones $archivosEvaServices)
    {
        $this->archivosEvaServices = $archivosEvaServices;
    }

    public function limpiarDivision($institucion_id, $division_id)
    {
        $this->limpiarMuro($division_id);
        $this->limpiarEvaluaciones($division_id);

        return back()->with(['successMessage' => 'Division limpiada con exito!']);
    }

    public function limpiarMuro($division_id)
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
    }
}
