<?php

namespace App\Http\Middleware\Evaluaciones;

use App\Models\Evaluaciones\EntregaComentario;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntregaComentarioCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $comentario = EntregaComentario::find($link[12]);

        if ($comentario->user_id == Auth::id()) {
            return $next($request);
        }

        if (session('tipo') == 'Institucion' || session('tipo') == 'Directivo') {
            if ($comentario->entrega->evaluacion->institucion_id == session('institucion_id')) {
                return $next($request);
            }
            abort(403, 'Estos comentarios no forma parte de tu institucion');
        }

        abort(403, 'Este comentario no es tuyo.');
    }
}
