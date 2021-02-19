<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Http\Requests\Muro\StorePublicacion;
use App\Models\Estructuras\Division;
use App\Models\Muro\Muro;
use App\Models\Muro\MuroArchivo;
use App\Services\FechaHora\CambiarFormatoFechaHora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MuroController extends Controller
{
    public function __construct(CambiarFormatoFechaHora $formatoService)
    {
        $this->middleware('auth');
        $this->middleware('institucionCorrespondiente');
        $this->middleware('divisionCorrespondiente');
        $this->middleware('publicacionCorrespondiente')->only('update', 'destroy');

        $this->formatoService = $formatoService;
    }

    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Muro/Index', [
            'institucion_id' => $institucion_id,
            'user_id' => Auth::id(),
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
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
        Muro::create([
            'division_id' => $division_id,
            'user_id' => Auth::id(),
            'publicacion' => $request->publicacion,
        ]);
        return back()->with(['successMessage' => 'Publicación agregada con éxito!']);
    }

    public function update(StorePublicacion $request, $institucion_id, $division_id, $id)
    {
        Muro::where('id', $id)
            ->update([
                'publicacion' => $request->publicacion,
            ]);
        return back()->with(['successMessage' => 'Publicación actualizada con éxito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        $archivos = MuroArchivo::where('muro_id', $id)->get();
        foreach ($archivos as $archivo) {
            Storage::delete('public/Muro/' . $archivo->archivo);
        }
        Muro::destroy($id);
        return back()->with(['successMessage' => 'Publicación eliminada con éxito!']);
    }
}
