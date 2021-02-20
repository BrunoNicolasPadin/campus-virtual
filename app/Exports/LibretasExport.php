<?php

namespace App\Exports;

use App\Models\Deudores\AlumnoDeudor;
use App\Models\Libretas\Libreta;
use Maatwebsite\Excel\Concerns\FromCollection;

class LibretasExport implements FromCollection
{
    private $ciclo_lectivo_id;
    private $alumno_id;

    public function __construct(int $ciclo_lectivo_id, int $alumno_id)
    {
        $this->ciclo_lectivo_id = $ciclo_lectivo_id;
        $this->alumno_id = $alumno_id;
    }
    public function collection()
    {
        $lib = Libreta::where('alumno_id', $this->alumno_id)
            ->where('ciclo_lectivo_id', $this->ciclo_lectivo_id)
            ->with(['division', 'division.nivel', 'division.orientacion', 'division.curso', 'cicloLectivo'])
            ->first();

        if ($lib->periodo_id == 1) {
            $periodos[] = ['Asignatura', '1er bimestre', '2do bimestre', '3er bimestre', '4to bimestre', 'Nota final'];
        }

        if ($lib->periodo_id == 2) {
            $periodos[] = ['Asignatura', '1er trimestre', '2do trimestre', '3er trimestre', 'Nota final'];
        }

        if ($lib->periodo_id == 3) {
            $periodos[] = ['Asignatura', '1er cuatrimestre', '2do cuatrimestre', 'Nota final'];
        }

        $libretas = Libreta::where('alumno_id', $this->alumno_id)
            ->where('ciclo_lectivo_id', $this->ciclo_lectivo_id)
            ->with(['calificaciones', 'asignatura'])
            ->get();

        $notas = array();

        foreach ($libretas as $libreta) {

            foreach ($libreta->calificaciones as $calificacion) {
                array_push($notas, $calificacion->calificacion);
            }

            if ($lib->periodo_id == 1) {
                $periodos[] = $this->armarTablaParaBimestre($notas, $libreta);
            }

            if ($lib->periodo_id == 2) {
                $periodos[] = $this->armarTablaParaTrimestre($notas, $libreta);
            }

            if ($lib->periodo_id == 3) {
                $periodos[] = $this->armarTablaParaCuatrimestre($notas, $libreta);
            }

            $notas = [];
        }

        $deudasCabecera [] = ['Asignatura', 'Condicion'];
        $deudas = AlumnoDeudor::where('alumno_id', $this->alumno_id)
            ->where('ciclo_lectivo_id', $this->ciclo_lectivo_id)
            ->with('asignatura')
            ->get();

        

        foreach ($deudas as $deuda) {
            $deudasCabecera[] = array(
                'Asignatura' => $deuda->asignatura->nombre,
                'Condicion' => $deuda->aprobado = 'Si' ?? 'No',
            );
        }

        $arreglos = [$periodos, $deudasCabecera];

        $output = [];

        foreach ($arreglos as $array) {
            // get headers for current dataset
            $output[] = array_keys($array[0]);
            // store values for each row
            foreach ($array as $row) {
                $output[] = array_values($row);
            }
            // add an empty row before the next dataset
            $output[] = [''];
        }

        return collect($output);
    }

    public function armarTablaParaCuatrimestre($notas, $libreta)
    {
        return array(
            'Asignatura' => $libreta['asignatura']['nombre'],
            '1er cuatrimestre' => $notas[0],
            '2do cuatrimestre' => $notas[1],
            'Nota final' => $notas[2],
        );
    }

    public function armarTablaParaTrimestre($notas, $libreta)
    {
        return array(
            'Asignatura' => $libreta['asignatura']['nombre'],
            '1er trimestre' => $notas[0],
            '2do trimestre' => $notas[1],
            '3er trimestre' => $notas[2],
            'Nota final' => $notas[3],
        );
    }

    public function armarTablaParaBimestre($notas, $libreta)
    {
        return array(
            'Asignatura' => $libreta['asignatura']['nombre'],
            '1er bimestre' => $notas[0],
            '2do bimestre' => $notas[1],
            '3er bimestre' => $notas[2],
            '4to biimestre' => $notas[3],
            'Nota final' => $notas[4],
        );
    }
}
