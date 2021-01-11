<?php

namespace App\Http\Responses;

use App\Models\Instituciones\Institucion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{        
    public function toResponse($request)
    {
        if (session('tipo') == 'Institucion' && ! Institucion::where('user_id', Auth::id())->exists()) {

            return $request->wantsJson() ? new JsonResponse('', 201) : redirect(route('instituciones.create'));
        }

        if (session('tipo') == 'Institucion' && Institucion::where('user_id', Auth::id())->exists()) {

            return $request->wantsJson() ? new JsonResponse('', 201) : redirect(route('dashboard'));
        }
        
        return $request->wantsJson() ? new JsonResponse('', 201) : redirect(route('dashboard'));
    }
}