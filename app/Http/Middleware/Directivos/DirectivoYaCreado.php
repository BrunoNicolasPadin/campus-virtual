<?php

namespace App\Http\Middleware\Directivos;

use App\Models\Roles\Directivo;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DirectivoYaCreado
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        if (Directivo::where('user_id', Auth::id())
            ->where('institucion_id', $link[4])
            ->exists()) {
            return $next($request);
        }
        abort(403, 'Ya estas registrado como directivo para esta institucion.');
    }
}
