<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StorePublicacion;
use App\Jobs\Muro\PublicacionDestroyJob;
use App\Models\Muro\Muro;
use App\Repositories\Estructuras\DivisionRepository;
use App\Services\Archivos\ObtenerFechaHoraService;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MuroController extends Controller
{
    protected $formatoService;
    protected $divisionRepository;
    protected $obtenerFechaHoraService;

    public function __construct(
        CambiarFormatoFechaHora $formatoService,
        DivisionRepository $divisionRepository,
        ObtenerFechaHoraService $obtenerFechaHoraService,
    )

    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('publicacionCorrespondiente')->only('update', 'destroy');

        $this->obtenerFechaHoraService = $obtenerFechaHoraService;
        $this->formatoService = $formatoService;
        $this->divisionRepository = $divisionRepository;
    }

    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Muro/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'tipo' => session('tipo'),
            'division' => $this->divisionRepository->find($division_id),
            'publicaciones' => Muro::where('division_id', $division_id)
                ->with('user')
                ->orderBy('updated_at', 'DESC')
                ->paginate(10)
                ->transform(function ($muro) {
                    return [
                        'id' => $muro->id,
                        'division_id' => $muro->division_id,
                        'publicacion' => $muro->publicacion,
                        'updated_at' => $this->formatoService->cambiarFormatoParaMostrar($muro->updated_at),
                        'user' => $muro->user->only('id', 'name'),
                    ];
                }),
        ]);
    }

    public function store(StorePublicacion $request, $institucion_id, $division_id)
    {
        $muro = new Muro();
        $muro->publicacion = $request->publicacion;
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();
        $muro->created_at = $this->formatoService->cambiarFormatoParaGuardar($fechaHora);
        $muro->updated_at = $this->formatoService->cambiarFormatoParaGuardar($fechaHora);
        $muro->division()->associate($division_id);
        $muro->user()->associate(Auth::id());
        $muro->save();

        return back()->with(['successMessage' => 'Publicación agregada con éxito!']);
    }

    public function update(StorePublicacion $request, $institucion_id, $division_id, $id)
    {
        $fechaHora = $this->obtenerFechaHoraService->obtenerFechaHora();

        Muro::where('id', $id)
            ->update([
                'publicacion' => $request->publicacion,
                'updated_at' => $this->formatoService->cambiarFormatoParaGuardar($fechaHora),
            ]);
        return back()->with(['successMessage' => 'Publicación actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        PublicacionDestroyJob::dispatch($id);

        return back()->with(['successMessage' => 'Publicación eliminada con éxito!']);
    }
}
