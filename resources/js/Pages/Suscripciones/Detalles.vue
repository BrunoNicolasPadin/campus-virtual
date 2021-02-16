<template>
    <div class="min-h-screen bg-blue-50">
        <nav class="bg-blue-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 my-2">
                    <div class="space-x-8 sm:my-5 sm:ml-10 sm:flex">
                        <inertia-link target="_blank" :href="route('inicio')" class="text-sm text-indigo-800 font-bold hover:underline">Inicio</inertia-link>
                        <inertia-link target="_blank" :href="route('tutoriales')" class="text-sm text-indigo-800 font-bold hover:underline">Tutoriales</inertia-link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-1">
            
            <div class="container mx-auto px-4 sm:px-8 text-left">

                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="text-indigo-600">Detalles de los servicios</span>
                </h1>
                <span class="text-md tracking-tight font-bold text-gray-700">
                    <ul>
                        <li><a href="#ciclos-lectivos">1) Ciclos lectivos</a></li>
                        <li><a href="#estructura">2) Estructura</a></li>
                        <li><a href="#evaluaciones-entregas-numeros">3) Evaluaciones, entregas y numeros</a></li>
                        <li><a href="#materiales">4) Materiales</a></li>
                        <li><a href="#libreta">5) Libreta</a></li>
                        <li><a href="#estadisticas">6) Estadisticas</a></li>
                        <li><a href="#calendario">7) Calendario</a></li>
                        <li><a href="#asignaturas">8) Asignaturas y mesas</a></li>
                        <li><a href="#muro">9) Muro</a></li>
                    </ul>
                </span>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="ciclos-lectivos">Ciclos lectivos:</span>
                </h1>

                <a :href="'storage/detalles/cicloLectivo.png'" target="_blank">
                    <img :src="'storage/detalles/CicloLectivo.png'" class="border" alt="Ciclo lectivo" title="Ciclo lectivo" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="estructura">Estructura:</span>
                </h1>

                <a :href="'storage/detalles/Estructura.png'" target="_blank">
                    <img :src="'storage/detalles/Estructura.png'" class="border" alt="Estructura" title="Estructura" />
                </a>

                <a :href="'storage/detalles/EstructuraShow.png'" target="_blank">
                    <img :src="'storage/detalles/EstructuraShow.png'" class="border" alt="Estructura" title="Estructura" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span id="evaluaciones-entregas-numeros">Evaluaciones, entregas y numeros:</span>
                </h1>

                <a :href="'storage/detalles/Evaluaciones.png'" target="_blank">
                    <img :src="'storage/detalles/Evaluaciones.png'" class="border" alt="Evaluaciones" title="Evaluaciones" />
                </a>

                <a :href="'storage/detalles/EvaluacionesShow.png'" target="_blank">
                    <img :src="'storage/detalles/EvaluacionesShow.png'" class="border" alt="Evaluaciones" title="Evaluaciones" />
                </a>

                <a :href="'storage/detalles/Entregas.png'" target="_blank">
                    <img :src="'storage/detalles/Entregas.png'" class="border" alt="Entregas" title="Entregas" />
                </a>

                <a :href="'storage/detalles/EntregasShow.png'" target="_blank">
                    <img :src="'storage/detalles/EntregasShow.png'" class="border" alt="Entregas" title="Entregas" />
                </a>

                <a :href="'storage/detalles/Numeros1.png'" target="_blank">
                    <img :src="'storage/detalles/Numeros1.png'" class="border" alt="Numeros" title="Numeros" />
                </a>

                <a :href="'storage/detalles/Numeros2.png'" target="_blank">
                    <img :src="'storage/detalles/Numeros2.png'" class="border" alt="Numeros" title="Numeros" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="materiales">Materiales:</span>
                </h1>

                <a :href="'storage/detalles/Grupos.png'" target="_blank">
                    <img :src="'storage/detalles/Grupos.png'" class="border" alt="Grupos" title="Grupos" />
                </a>

                <a :href="'storage/detalles/GruposShow.png'" target="_blank">
                    <img :src="'storage/detalles/GruposShow.png'" class="border" alt="Grupos" title="Grupos" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="libreta">Libreta:</span>
                </h1>

                <a :href="'storage/detalles/Libreta.png'" target="_blank">
                    <img :src="'storage/detalles/Libreta.png'" class="border" alt="Libreta" title="Libreta" />
                </a>
                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="estadisticas">Estadisticas division, asignatura, alumno, abandonos y repeticiones:</span>
                </h1>

                <a :href="'storage/detalles/EstadisticasDivision.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasDivision.png'" class="border" alt="Estadisticas Division" title="Estadisticas Division" />
                </a>

                <a :href="'storage/detalles/EstadisticasAsignatura.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasAsignatura.png'" class="border" alt="Estadisticas Asignatura" title="Estadisticas Asignatura" />
                </a>

                <a :href="'storage/detalles/EstadisticasAlumno.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasAlumno.png'" class="border" alt="Estadisticas Alumno" title="Estadisticas Alumno" />
                </a>

                <a :href="'storage/detalles/EstadisticasAbandonos.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasAbandonos.png'" class="border" alt="Estadisticas Abandonos" title="Estadisticas Abandonos" />
                </a>

                <a :href="'storage/detalles/EstadisticasRepetidores.png'" target="_blank">
                    <img :src="'storage/detalles/EstadisticasRepetidores.png'" class="border" alt="Estadisticas Repetidores" title="Estadisticas Repetidores" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="calendario">Calendario:</span>
                </h1>

                <a :href="'storage/detalles/Calendario.png'" target="_blank">
                    <img :src="'storage/detalles/Calendario.png'" class="border" alt="Calendario" title="Calendario" />
                </a>
                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="asignaturas">Asignaturas y mesas para rendir:</span>
                </h1>

                <a :href="'storage/detalles/Asignaturas.png'" target="_blank">
                    <img :src="'storage/detalles/Asignaturas.png'" class="border" alt="Asignaturas" title="Asignaturas" />
                </a>

                <a :href="'storage/detalles/Mesas.png'" target="_blank">
                    <img :src="'storage/detalles/Mesas.png'" class="border" alt="Mesas" title="Mesas" />
                </a>

                <a :href="'storage/detalles/MesasShow.png'" target="_blank">
                    <img :src="'storage/detalles/MesasShow.png'" class="border" alt="Mesas" title="Mesas" />
                </a>

                <hr class="my-5">
            </div>

            <div class="my-2 container mx-auto px-4 sm:px-8 text-left">
                <h1 class="text-2xl tracking-tight font-bold text-gray-900">
                    <span class="text-black" id="muro">Muro de la division, respuestas y archivos:</span>
                </h1>

                <a :href="'storage/detalles/Muro.png'" target="_blank">
                    <img :src="'storage/detalles/Muro.png'" class="border" alt="Muro" title="Muro" />
                </a>

                <a :href="'storage/detalles/MuroArchivos.png'" target="_blank">
                    <img :src="'storage/detalles/MuroArchivos.png'" class="border" alt="Muro Archivos" title="Muro Archivos" />
                </a>

                <a :href="'storage/detalles/MesasShow.png'" target="_blank">
                    <img :src="'storage/detalles/MuroRespuestas.png'" class="border" alt="Muro Respuestas" title="Muro Respuestas" />
                </a>

                <hr class="my-5">
            </div>
        </div>
    </div>
</template>
