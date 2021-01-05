<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function mostrarDashboard()
    {
        $institucion_id = 1;
        return redirect(route('divisiones.index', $institucion_id));
    }
}
