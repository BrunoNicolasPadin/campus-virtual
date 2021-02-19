<?php

namespace App\Http\Middleware\Muro;

use App\Models\Muro\MuroRespuesta;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RespuestaMuroCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $respuesta = MuroRespuesta::find($link[10]);

        if ($respuesta->user_id == Auth::id()) {
            return $next($request);
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($respuesta->muro->division->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Esta respuesta no forma parte de tu institución.');
        }

        abort(403, 'Esta respuesta no es tuya.');
    }
}
