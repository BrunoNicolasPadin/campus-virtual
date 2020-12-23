<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Roles\Docente;
use App\Services\ClaveDeAcceso\VerificarInstitucion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
    protected $claveDeAccesoService;

    public function __construct(VerificarInstitucion $claveDeAccesoService)
    {
        $this->claveDeAccesoService = $claveDeAccesoService;
    }

    public function index($institucion_id)
    {
        //
    }

    public function create($institucion_id)
    {
        //
    }

    public function store(Request $request, $institucion_id)
    {
        if ($this->claveDeAccesoService->verificarClaveDeAcceso($request->claveDeAcceso, $institucion_id)) {
            Docente::create([
                'user_id' => Auth::id(),
                'institucion_id' => $institucion_id,
            ]);
            return redirect('/dashboard');
        }
        return redirect(route('roles.index', $institucion_id))->withErrors('Clave de acceso incorrecta.');
    }

    public function show($institucion_id, $id)
    {
        //
    }

    public function edit($institucion_id, $id)
    {
        //
    }

    public function update(Request $request, $institucion_id, $id)
    {
        //
    }

    public function destroy($institucion_id, $id)
    {
        //
    }
}
