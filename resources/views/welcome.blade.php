<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>

    </head>
    <body class="antialiased bg-blue-100 container mx-auto px-4 sm:px-8 ">
        <nav class="bg-blue-100 border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 my-2">
                    @if (Route::has('login'))
                    <div class="space-x-8 sm:my-5 sm:ml-10 sm:flex">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-800 font-bold hover:underline">Campus</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-indigo-800 font-bold hover:underline">Ingresar</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-indigo-800 font-bold hover:underline">Registrarse</a>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    
        <div class="w-full mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-full lg:w-full lg:pb-28 xl:pb-10">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-5 sm:px-6 md:mt-5 lg:mt-5 lg:px-8 xl:mt-5">
                    <div class="text-center">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Moderniza tu colegio</span>
                            <span class="block text-indigo-600 xl:inline">con Gescol</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl">
                            Conecta a tus directivos, docentes, alumnos, padres y madres en un solo lugar y permiti que accedan a la informacion relacionada a 
                            los examenes, tareas y trabajos practicos cuando deseen.
                        </p>
                    </div>
                </main>
            </div>
        </div>

        <div class="py-5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Servicios
                    </p>
                </div>
          
                <div class="mt-10">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <!-- Heroicon name: globe-alt -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-bold text-indigo-600">
                                    Evaluaciones
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Los docentes podran crear examenes, tareas y trabajos practicos y los alumnos realizar entregas que seran corregidas y calificadas.
                                </dd>
                            </div>
                        </div>
          
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: scale -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-bold text-indigo-600">
                                    Faltas
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Podra tomar asistencia dia a dia a sus alumnos, directivos y docentes.
                                </dd>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <!-- Heroicon name: globe-alt -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-bold text-indigo-600">
                                    Libretas
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Podra subir las notas de la libreta para cada periodo (bimestre, tri, cuatri) junto con la nota final.
                                </dd>
                            </div>
                        </div>
          
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: scale -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-bold text-indigo-600">
                                    Estadisticas
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Tendra acceso a estadisticas por ciclo lectivo dentro de cada division y separarlo por asignatura y/o alumno.
                                </dd>
                            </div>
                        </div>

                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <!-- Heroicon name: globe-alt -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-bold text-indigo-600">
                                    Materiales
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Podra subir archivos pdf, imagenes, videos, etc... para que los alumnos lo descarguen o lo vean de forma online.
                                </dd>
                            </div>
                        </div>
          
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                    <!-- Heroicon name: scale -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <dt class="text-lg leading-6 font-bold text-indigo-600">
                                    Padres
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Los padres podran vincular su cuenta a la de su/s hijo/s y ver lo mismo que ellos sin ningun problema.
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="lg:text-center">
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Contacto
                </p>
            </div>
            <div class="pt-6 pb-8 px-4 sm:px-8 my-2 mb-4">
                <form action="" method="post">
                    <label class="block uppercase tracking-wide text-indigo-500 text-md font-bold mb-2">Email</label>
                    <input class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3" name="email" type="email">
                    <label class="block uppercase tracking-wide text-indigo-500 text-md font-bold mb-2">Asunto</label>
                    <input class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3" name="asunto" type="text">
                    <label class="block uppercase tracking-wide text-indigo-500 text-md font-bold mb-2">Mensaje</label>
                    <textarea class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3"></textarea>
                    <button type="submit" class="border border-green-700 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </body>
</html>
