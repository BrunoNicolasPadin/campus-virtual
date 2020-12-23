<?php

namespace App\Http\Middleware\Instituciones;

use App\Models\Instituciones\Institucion;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstitucionCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if (Institucion::where('user_id', Auth::id())
            ->where('id', $link[4])
            ->exists()) {
            return $next($request);
        }
        abort(403, 'No es tu institucion.');
    }
}
