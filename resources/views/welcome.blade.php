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
    <body class="antialiased bg-blue-50 container mx-auto px-4 sm:px-8 ">
        <nav class="bg-blue-50 border-b border-gray-100">
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
                            Conecta a tus directivos, docentes, alumnos, padres y madres en un solo lugar y permite que accedan a la información relacionada a 
                            los exámenes, tareas, trabajos prácticos, libretas de calificaciones, estadísticas y mas cuando lo deseen.
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
                                    Los docentes podrán crear exámenes, tareas y trabajos prácticos; los alumnos realizar entregas, 
                                    que serán corregidas y calificadas por los docentes, subiendo la entrega corregida si así desean. 
                                    También los alumnos tendrán la posibilidad de resolver sus dudas con los docentes en los comentarios.
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
                                    Materiales
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Los docente podrán subir archivos PDFs, WORDs, PowerPoint, imágenes, videos, etc... 
                                    para que los alumnos puedan descargarlos y los tengan en un solo lugar. 
                                    Los podrán dejar allí para que los nuevos alumnos también accedan a ellos y así evitar que el docente 
                                    los tenga que volver a subir.
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
                                    Cada alumno contará con una libreta en la que los directivos subirán las notas de la libreta 
                                    para cada periodo (bimestre, trimestre, cuatrimestre) junto con la nota final en cada materia.
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
                                    Los padres vincularan su cuenta a la de su/s hijo/s y verán lo mismo que ellos así no se les escapa nada.
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
                                    Calendario
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Poseerá un calendario con las fechas de los exámenes, trabajos prácticos, tareas y mesas para rendir.
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
                                    Estadísticas
                                </dt>
                                <dd class="mt-2 text-base text-gray-500">
                                    Accederá a estadísticas por ciclo lectivo dentro de cada división, asignatura y alumno por bimestre/trimestre/cuatrimestre. 
                                    Cantidad de alumnos que repiten o abandonan, dividido por ciclo lectivo y división.
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div class="my-2 container mx-auto px-4 sm:px-8 text-center">
            <button type="button" class="border border-indigo-500 bg-indigo-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline">
                <a href="{{ route('suscripciones.detalles') }}">Ver con mas detalle</a>
            </button>
            <button type="button" class="border border-green-500 bg-green-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-green-700 focus:outline-none focus:shadow-outline">
                <a href="{{ route('tutoriales') }}">Tutoriales</a>
            </button>

            <hr class="my-5">
        </div>

        <div class="py-5">
            <div class="lg:text-center">
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Contacto
                </p>
            </div>
            <div class="pt-6 pb-8 px-4 sm:px-8 my-2 mb-4">
                <form action="{{ route('contacto.enviarEmail') }}" method="post">
                    @csrf
                    <label class="block uppercase tracking-wide text-indigo-500 text-md font-bold mb-2">Email</label>
                    <input required class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3" name="email" type="email">
                    <label class="block uppercase tracking-wide text-indigo-500 text-md font-bold mb-2">Asunto</label>
                    <select class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3" required name="asunto">
                        <option disabled value="">-</option>
                        <option value="Queja">Queja</option>
                        <option value="Error">Reportar error</option>
                        <option value="Nueva idea">Nueva idea</option>
                        <option value="Adquirir servicio">Adquirir servicio</option>
                        <option value="Otro motivo">Otro motivo</option>
                    </select>
                    <label class="block uppercase tracking-wide text-indigo-500 text-md font-bold mb-2">Mensaje</label>
                    <textarea required name="mensaje" class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3"></textarea>
                    <button type="submit" class="border border-green-700 bg-green-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Enviar
                    </button>
                    <span class="text-black text-md">
                        o enviar un mensaje a <span class="underline">3413154714</span>.
                    </span>
                </form>

                <hr class="my-5">
            </div>
        </div>

        <div class="py-5">
            <div class="lg:text-center">
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Nosotros
                </p>
            </div>
            <div class="pt-6 pb-8 px-4 sm:px-8 my-2 mb-4">
                <p class="mt-3 text-gray-900 leading-loose">
                    Gescol surge de mi interés por la educación y de que esta mejore, ya que es muy importante para el progreso de un país. 
                    También surge de mi experiencia en el colegio y en la universidad. <br>

                    Cuando iba a la escuela no teníamos ninguna página de internet donde enterarnos de las fechas de las evaluaciones, 
                    enviar nuestros trabajos prácticos, recibir las correcciones, hacer preguntas al profesor, descargar material y 
                    demás cosas que hubiesen hecho mas fácil y organizada nuestra vida en el colegio, algo que seguramente todos deseamos para 
                    nosotros, nuestros alumnos, amigos, hijos, docentes y etc… <br>

                    Luego en la universidad había un “campus virtual” pero tenía (tiene) un diseño espantoso, se caía cuando nos queríamos inscribir 
                    en alguna materia, demasiados tramites y procesos no estaban digitalizados, sumado a que pocos docentes lo utilizaban y tiene todo lo que, 
                    en la misma universidad te enseñan, un sistema NO debe tener. <br>
                    
                    Teniendo todo esto en mente pensaba en los bien que le haría a los colegios y sus miembros al tener un servicio como Gescol, 
                    un sitio web en el cual podrán ir digitalizando poco a poco los procesos que hoy en día hacen en papel o en tablas Excel y 
                    facilitarle la vida a todas las personas que forman una institución educativa.
                </p>

                <hr class="my-5">
            </div>
        </div>
    </body>
</html>
