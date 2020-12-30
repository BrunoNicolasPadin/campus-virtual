<?php

namespace App\Http\Controllers\Muro;

use App\Http\Controllers\Controller;
use App\Models\Estructuras\Division;
use App\Models\Muro\Muro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MuroController extends Controller
{
    public function index($institucion_id, $division_id)
    {
        return Inertia::render('Muro/Index', [
            'institucion_id' => $institucion_id,
            'division' => Division::with(['nivel', 'orientacion', 'curso'])->find($division_id),
            'publicaciones' => Muro::where('division_id', $division_id)->with('user')->orderBy('created_at', 'DESC')->paginate(2),
        ]);
    }

    public function store(Request $request, $institucion_id, $division_id)
    {
        Muro::create([
            'division_id' => $division_id,
            'user_id' => Auth::id(),
            'publicacion' => $request->publicacion,
        ]);
        return back()->with(['successMessage' => 'Publicacion realizada con exito!']);
    }

    public function update(Request $request, $institucion_id, $division_id, $id)
    {
        Muro::where('id', $id)
            ->update([
                'publicacion' => $request->publicacion,
            ]);
        return back()->with(['successMessage' => 'Publicacion actualizada con exito!']);
    }

    public function destroy($institucion_id, $division_id, $id)
    {
        Muro::destroy($id);
        return back()->with(['successMessage' => 'Publicacion eliminada con exito!']);
    }
}
