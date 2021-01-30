<?php

namespace App\Http\Controllers\Deudores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deudores\StoreMesaArchivo;
use App\Models\Asignaturas\Asignatura;
use App\Models\Deudores\Mesa;
use App\Models\Deudores\MesaArchivo;
use App\Models\Estructuras\Division;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MesaArchivoController extends Controller
{
    protected $formatoService;

    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        /* $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('asignaturaAdeudadaCorrespondiente');
        $this->middleware('soloInstitucionesDirectivosDocentes')->except('show');
        $this->middleware('divisionCorrespondiente')->except('show');
        $this->middleware('mesaCorrespondiente')->except('create', 'store'); */

        $this->formatoService = $formatoService;
    }

    public function create($institucion_id, $division_id, $asignatura_id, $mesa_id)
    {
        $mesa = Mesa::with('asignatura')->findOrFail($mesa_id);

        return Inertia::render('Deudores/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division_id' => $division_id,
            'asignatura_id' => $asignatura_id,
            'mesa' => [
                'id' => $mesa->id,
                'asignatura' => $mesa->asignatura,
                'fechaHora' => $this->formatoService->cambiarFormatoParaMostrar($mesa->fechaHora),
                'comentario'  => $mesa->comentario,
            ],
        ]);
    }

    public function store(StoreMesaArchivo $request, $institucion_id, $division_id, $asignatura_id, $mesa_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');
            $i = 0;

            foreach ($archivos as $archivo) {
                $fecha = date_create();
                $nombre = date_timestamp_get($fecha) . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Mesas/Archivos', $nombre);

                MesaArchivo::create([
                    'mesa_id' => $mesa_id,
                    'archivo' => $nombre,
                    'visibilidad'  => $request['visibilidad'][$i],
                ]);
                $i++;
            }

            return redirect(route('mesas.show', [$institucion_id, $division_id, $asignatura_id, $mesa_id]))
                ->with(['successMessage' => 'Archivos cargados con exito!']);
        }
        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
