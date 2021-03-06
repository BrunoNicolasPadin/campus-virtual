<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="nombre" value="{{ __('Nombre') }}" />
                <x-jet-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="nombre" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Repetir email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email_confirmation" :value="old('email_confirmation')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="clave" value="{{ __('Contraseña') }}" />
                <x-jet-input id="clave" class="block mt-1 w-full" type="password" name="clave" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="clave_confirmation" value="{{ __('Confirmar contraseña') }}" />
                <x-jet-input id="clave_confirmation" class="block mt-1 w-full" type="password" name="clave_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="tipo" value="{{ __('Tipo de cuenta') }}" />
                <select required name="tipo" class="form-select mt-1 block w-full">
                    <option value="" disabled>-</option>
                    <option value="Institucion">Institución</option>
                    <option value="Persona">Persona</option>
              </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Ya estás registrado?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Registrar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
