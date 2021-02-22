<?php

namespace App\Http\Controllers\Libretas;

use App\Http\Controllers\Controller;
use App\Exports\LibretasExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportarLibretaController extends Controller
{
    public function exportarLibreta($institucion_id, $alumno_id, $ciclo_lectivo_id)
    {
        return Excel::download(new LibretasExport($ciclo_lectivo_id, $alumno_id), 'libreta.xlsx');
    }
}
