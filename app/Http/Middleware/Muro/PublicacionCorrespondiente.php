<?php

namespace App\Http\Middleware\Muro;

use App\Models\Muro\Muro;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicacionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $publicacion = Muro::find($link[8]);

        if ($publicacion->user_id == Auth::id()) {
            return $next($request);
        }

        abort(403, 'Esta publicación no es tuya.');
    }
}
