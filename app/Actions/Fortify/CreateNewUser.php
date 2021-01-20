<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input)
    {
        Validator::make($input, [
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_confirmation' => ['required', 'same:email'],
            'clave' => $this->passwordRules(),
            'tipo' => 'required',
        ])->validate();

        if ($input['tipo'] == 'Institucion') {
            session(['tipo' => 'Institucion']);
        }
        else {
            session(['tipo' => 'Persona']);
        }

        return User::create([
            'name' => $input['nombre'],
            'email' => $input['email'],
            'password' => Hash::make($input['clave']),
            'tipo' => $input['tipo'],
        ]);
    }
}
