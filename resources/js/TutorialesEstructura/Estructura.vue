<template>
<div>
    <div class="h-auto bg-blue-50 py-2">
        <nav class="bg-blue-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 my-2">
                    <div class="space-x-8 sm:my-5 sm:ml-10 sm:flex">
                        <inertia-link target="_blank" :href="route('inicio')" class="text-lg text-indigo-800 font-bold hover:underline">Inicio</inertia-link>
                        <inertia-link :href="route('suscripciones.detalles')" class="text-lg text-indigo-800 font-bold hover:underline">Servicios</inertia-link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex flex-wrap w-full h-auto bg-blue-50">
            <div class="w-3/12 bg-blue-50 rounded p-3 shadow-md">
                <div class="flex items-center space-x-4 p-2 mb-5">
                    <h4 class="font-semibold text-lg text-gray-700 capitalize font-poppins tracking-wide">Lista</h4>
                </div>
                <ul class="space-y-2 text-sm">
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.como_empezar')">
                            ¿Cómo empezar?
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.nuevo_ciclo_lectivo')">
                            ¿Está por comenzar un ciclo lectivo nuevo? Sigue estos pasos
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.soporte')">
                            Soporte
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.institucion')">
                            Institución
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.ciclo_lectivo')">
                            Ciclos lectivos
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.forma_evaluacion')">
                            Formas de evaluación
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.estructura')">
                            Estructuras
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.asignatura')">
                            Asignaturas
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.usuario')">
                            Perfil de usuario
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.directivo')">
                            Directivos
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.docente')">
                            Docentes
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.alumno')">
                            Alumnos
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.padre')">
                            Padres
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.evaluacion')">
                            Evaluaciones
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.mesa')">
                            Mesas/Rendir y asignaturas adeudadas
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.calendario')">
                            Calendario
                        </inertia-link>
                    </li>
                    <!-- <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.correccion')">
                            Correcciones
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.entrega')">
                            Entregas
                        </inertia-link>
                    </li> -->
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.material')">
                            Materiales
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.muro')">
                            Muro
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.libreta')">
                            Libretas
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.estadistica')">
                            Estadísticas y números
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.repitente')">
                            Repitentes
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.exalumno')">
                            Ex alumnos
                        </inertia-link>
                    </li>
                    <li>
                        <inertia-link class="flex items-center space-x-3 text-gray-700 p-2 rounded-md font-medium hover:bg-gray-200 bg-gray-100 focus:shadow-outline" 
                            :href="route('tutoriales.pasar_de_anio')">
                            Pasar de año
                        </inertia-link>
                    </li>
                </ul>
            </div>

            <div class="w-9/12">
                <div class="p-4 text-gray-500">
                    <slot name=contenido></slot>
                </div>
            </div>
        </div>
    </div>
</div>
    
</template>

<script>
export default {

    data() {
        return {
            open: false,
        }
    },
    
    method: {
        click() {
            this.open = true;
        }
    }
}

    
</script>