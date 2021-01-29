<?php

namespace App\Http\Middleware\Deudores;

use App\Models\Deudores\RendirComentario;
use App\Services\Ruta\RutaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendirComentarioCorrespondiente
{
    protected $ruta;

    public function __construct(RutaService $ruta)
    {
        $this->ruta = $ruta;
    }

    public function handle(Request $request, Closure $next)
    {
        $link = $this->ruta->obtenerRoute();

        $comentario = RendirComentario::find($link[14]);

        if ($comentario->user_id == Auth::id()) {
            return $next($request);
        }

        abort(403, 'Este comentario no es tuyo.');
    }
}
