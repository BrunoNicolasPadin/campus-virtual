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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email_confirmation' => ['required', 'same:email'],
            'password' => $this->passwordRules(),
            'tipo' => 'required',
        ])->validate();

        if ($input['tipo'] == 'Institucion') {
            session(['tipo' => 'Institucion']);
        }
        else {
            session(['tipo' => 'Persona']);
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'tipo' => $input['tipo'],
        ]);
    }
}
