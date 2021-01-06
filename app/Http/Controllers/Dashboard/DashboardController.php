<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function mostrarDashboard()
    {
        $institucion_id = 0;

        if (session()->has('institucion_id')) {
            $institucion_id = session('institucion_id');
        }
        return redirect(route('divisiones.index', $institucion_id));
    }
}
