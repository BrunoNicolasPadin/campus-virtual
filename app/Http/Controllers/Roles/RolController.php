<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class RolController extends Controller
{
    public function index($institucion_id)
    {
        return Inertia::render('Roles/Index', [
            'institucion_id' => $institucion_id,
        ]);
    }
}
