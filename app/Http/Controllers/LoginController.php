<?php

namespace App\Http\Controllers;

use App\Models\Instituciones\Institucion;
use App\Models\Roles\Alumno;
use App\Models\Roles\Directivo;
use App\Models\Roles\Docente;
use App\Models\Roles\Padre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->sessiones($request);
        }

        return back()->withErrors([
            'email' => 'Email incorrecto.',
        ]);
    }

    public function sessiones($request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user['tipo'] == 'Institucion') {
            session(['tipo' => 'Institucion']);

            if (Institucion::where('user_id', $user['id'])->exists()) {
                $institucion = Institucion::where('user_id', $user['id'])->first();
                session(['tipo_id' => $institucion['id']]);
                return redirect(route('divisiones.index', $institucion['id']));
            }
            return redirect(route('instituciones.create'));
        }

        if (Alumno::where('user_id', $user['id'])->exists()) {
            return $this->sessionesAlumnos($user);
        }
        return $this->desactivarCuentas($user);
    }

    public function sessionesAlumnos($user)
    {
        $alumno = Alumno::where('user_id', $user['id'])->first();
        session(['tipo' => 'Alumno']);
        session(['tipo_id' => $alumno['id']]);
        session(['institucion_id' => $alumno['institucion_id']]);
        session(['division_id' => $alumno['division_id']]);
        return redirect(route('divisiones.show', [$alumno['institucion_id'], $alumno['division_id']]));
    }

    public function desactivarCuentas($user)
    {
        Directivo::where('user_id', $user['id'])
        ->update([
            'activado' => 0,
        ]);

        Docente::where('user_id', $user['id'])
        ->update([
            'activado' => 0,
        ]);

        Padre::where('user_id', $user['id'])
        ->update([
            'activado' => 0,
        ]);

        return redirect(route('roles.mostrarCuentas')); 
    }
}