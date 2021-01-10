<?php

namespace App\Http\Middleware\Muro;

use App\Models\Muro\MuroArchivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArchivoMuroCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $archivo = MuroArchivo::find($link[10]);

        if ($archivo->muro->user_id == Auth::id()) {
            return $next($request);
        }

        abort(403, 'Este archivo no es tuyo.');
    }
}
