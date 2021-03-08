<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StoreArchivo;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroArchivo;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MuroArchivoController extends Controller
{
    protected $formatoService;
    protected $obtenerFechaHoraService;
    protected $divisionRepository;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        ObtenerFechaHoraService $obtenerFechaHoraService,
        DivisionRepository $divisionRepository
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('verArchivosMuroCorrespondiente')->only('index', 'destroy');
        $this->middleware('publicacionCorrespondiente')->only('create', 'store');
        $this->middleware('archivoMuroCorrespondiente')->only('destroy');

        $this->formatoService = $formatoService;
        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->divisionRepository = $divisionRepository;
    }

    public function index($institucion_id, $division_id, $muro_id)
    {
        $muro = Muro::with('user')->findOrFail($muro_id);

        return Inertia::render('Muro/Archivos/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'publicacion' => [
                'id' => $muro->id,
                'publicacion' => $muro->publicacion,
                'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($muro->updated_at),
                'user' => $muro->user->only('id', 'name'),
            ],
            'archivos' => MuroArchivo::where('muro_id', $muro_id)->orderBy('created_at', 'DESC')->get(),
        ]);
    }

    public function create($institucion_id, $division_id, $muro_id)
    {
        return Inertia::render('Muro/Archivos/Create', [
            'institucion_id' => $institucion_id,
            'division' => $this->divisionRepository->find($division_id),
            'publicacion' => Muro::select('id')->findOrFail($muro_id),
        ]);
    }

    public function store(StoreArchivo $request, $institucion_id, $division_id, $muro_id)
    {
        if ($request->hasFile('archivos')) {
            $archivos = $request->file('archivos');

            for ($i=0; $i < count($archivos); $i++) { 
                $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
                $unique = substr(base64_encode(mt_rand()), 0, 15);
                $nombre = $fechaHora . '-' . $unique . '-' . $archivos[$i]->getClientOriginalName();
                $archivos[$i]->storeAs('public/Muro', $nombre);

                $archivo = new MuroArchivo();
                $archivo->archivo = $nombre;
                $archivo->muro()->associate($muro_id);
                $archivo->save();
            }

            return redirect(route('muro-archivos.index', [$institucion_id, $division_id, $muro_id]))
                ->with(['successMessage' => 'Archivos subbidos con éxito!']);
        }

        return back()->withErrors('No hay ningún archivo seleccionado');
    }

    public function destroy($institucion_id, $division_id, $muro_id, $id)
    {
        $muroArchivo = MuroArchivo::findOrFail($id);
        Storage::delete('public/Muro/' . $muroArchivo->archivo);

        MuroArchivo::destroy($id);
        return back()->with(['successMessage' => 'Archivo eliminado con éxito!']);
    }
}
