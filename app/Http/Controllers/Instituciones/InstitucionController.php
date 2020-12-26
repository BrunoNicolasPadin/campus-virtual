<?php

namespace App\Http\Controllers\Instituciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instituciones\StoreInstitucion;
use App\Http\Requests\Instituciones\UpdateInstitucion;
use App\Models\Instituciones\Institucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    public function __construct()
    {
        /* $this->middleware('auth');
        $this->middleware('institucionYaCreada')->only('create', 'store');
        $this->middleware('institucionCorrespondiente')->only('edit', 'update', 'destroy'); */
    }

    public function create()
    {
        return Inertia::render('Instituciones/Create');
    }

    public function store(StoreInstitucion $request)
    {
        Institucion::create([
            'user_id' => Auth::id(),
            'numero' => $request->numero,
            'fundacion' => $request->fundacion,
            'historia' => $request->historia,
            'claveDeAcceso' => Hash::make($request->claveDeAcceso),
        ]);

        return redirect(route('ciclos-lectivos.index'))->with(['successMessage' => 'Institucion cargada con exito!']);
    }

    public function edit($id)
    {
        return Inertia::render('Instituciones/Edit', [
            'institucion' => Institucion::find($id),
        ]);
    }

    public function update(UpdateInstitucion $request, $id)
    {
        Institucion::where('id', $id)
            ->update([
                'numero' => $request->numero,
                'fundacion' => $request->fundacion,
                'historia' => $request->historia,
            ]);
        return back()->with(['successMessage' => 'Institucion actualizada con exito!']);
    }

    public function destroy($id)
    {
        Institucion::destroy($id);
        return back();
    }
}
