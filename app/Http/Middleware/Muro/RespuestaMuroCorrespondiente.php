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

        if ($respuesta->muro->user_id == Auth::id()) {
            return $next($request);
        }

        abort(403, 'Esta respuesta no es tuyo.');
    }
}