<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreDirectivo;
use App\Models\Roles\Directivo;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DirectivoController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->middleware('auth');

        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function index($institucion_id)
    {
        return Inertia::render('Directivos/Index', [
            'institucion_id' => $institucion_id,
            'directivos' => Directivo::where('institucion_id', $institucion_id)
                ->with('user')
                ->get(),
        ]);
    }

    public function store(StoreDirectivo $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {
            Directivo::create([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
                'activado' => 0,
            ]);
            return redirect('/dashboard');
        }
        return redirect(route('roles.anotarse', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        return Inertia::render('Directivos/Show', [
            'institucion_id' => $institucion_id,
            'directivo' => Directivo::with('user')->find($id),
        ]);
    }

    public function destroy($institucion_id, $id)
    {
        Directivo::destroy($id);
        return redirect(route('directivos.index', $institucion_id))->with(['successMessage' => 'Se ha eliminado el directivo con exito!']);
    }
}
