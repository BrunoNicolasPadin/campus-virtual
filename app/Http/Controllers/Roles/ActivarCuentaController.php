<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use Illuminate\Support\Facades\Auth;

class ActivarCuentaController extends Controller
{
    public function activarDocente($id)
    {
        $user_id = Auth::id();

        $this->desactivarDocentes($user_id);
        $this->desactivarDirectivos($user_id);
        $this->desactivarPadres($user_id);

        $docente = Docente::find($id);
        $docente->activado = 1;
        $docente->save();

        session(['tipo' => 'Docente']);
        session(['tipo_id' => $docente->id]);
        session(['institucion_id' => $docente->institucion_id]);

        return back()->with(['successMessage' => 'Docente activado']);
    }

    public function activarDirectivo($id)
    {
        $user_id = Auth::id();

        $this->desactivarDocentes($user_id);
        $this->desactivarDirectivos($user_id);
        $this->desactivarPadres($user_id);

        $directivo = Directivo::find($id);
        $directivo->activado = 1;
        $directivo->save();

        session(['tipo' => 'Directivo']);
        session(['tipo_id' => $directivo->id]);
        session(['institucion_id' => $directivo->institucion_id]);
    
        return back()->with(['successMessage' => 'Directivo activado']);
    }

    public function activarPadre($id)
    {
        $user_id = Auth::id();

        $this->desactivarDocentes($user_id);
        $this->desactivarDirectivos($user_id);
        $this->desactivarPadres($user_id);

        $padre = Padre::find($id);
        $padre->activado = 1;
        $padre->save();

        session(['tipo' => 'Padre']);
        session(['tipo_id' => $padre->id]);
        session(['institucion_id' => $padre->hijos->institucion_id]);
        session(['division_id' => $padre->hijos->division_id]);
        session(['alumno_id' => $padre->alumno_id]);

        return back()->with(['successMessage' => 'Padre activado']);
    }

    public function desactivarDocentes($user_id)
    {
        Docente::where('user_id', $user_id)
            ->update([
                'activado' => 0,
            ]);
    }

    public function desactivarDirectivos($user_id)
    {
        Directivo::where('user_id', $user_id)
            ->update([
                'activado' => 0,
            ]);
    }

    public function desactivarPadres($user_id)
    {
        Padre::where('user_id', $user_id)
            ->update([
                'activado' => 0,
            ]);
    }
}
