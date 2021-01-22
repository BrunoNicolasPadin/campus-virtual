<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Estructuras\Division;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroArchivo;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MuroArchivoController extends Controller
{
    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('verArchivosMuroCorrespondiente')->only('index', 'destroy');
        $this->middleware('publicacionCorrespondiente')->only('create', 'store');
        $this->middleware('archivoMuroCorrespondiente')->only('destroy');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $division_id, $muro_id)
    {
        $muro = Muro::with('user')->findOrFail($muro_id);

        return Inertia::render('Muro/Archivos/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'publicacion' => [
                'id' => $muro->id,
                'publicacion' => $muro->publicacion,
                'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($muro->updated_at),
                'user' => $muro->user,
            ],
            'archivos' => MuroArchivo::where('muro_id', $muro_id)->orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function create($institucion_id, $division_id, $muro_id)
    {
        return Inertia::render('Muro/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'publicacion' => Muro::find($muro_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $muro_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            foreach ($archivos as $archivo) {
                $fecha = date_create();
                $nombre = date_timestamp_get($fecha) . '-' . $archivo->getClientOriginalName();
                $archivo->storeAs('public/Muro', $nombre);

                MuroArchivo::create([
                    'muro_id' => $muro_id,
                    'archivo' => $nombre,
                ]);
            }

            return redirect(route('muro-archivos.index', [$institucion_id, $division_id, $muro_id]))
                ->with(['successMessage' => 'Archivos cargados con exito!']);
        }

        return back()->withErrors('No hay ningun archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $muro_id, $id)
    {
        $muroArchivo = MuroArchivo::findOrFail($id);
        Storage::delete('public/Muro/' . $muroArchivo->archivo);

        MuroArchivo::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con exito!']);
    }
}
