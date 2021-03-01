<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                {{ alumno.name }}
            </span>
        </template>

        <transition name="fade">
            <div v-if="successMessage" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                <div class="w-1/12">
                    <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                        <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">

                        </path>
                    </svg>
                </div>
                <div class="w-9/12">
                    <span class="text-green-800 float-left">{{ successMessage }} </span>
                </div>
                <div class="w-2/12">
                    <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                </div>
            </div>
        </transition>

        <div class="py-6">
            <estructura-informacion>
                <template #cabecera-info>
                    Datos
                </template>

                <template #dl-contenido>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Nombre
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ alumno.name }} <span v-show="alumno.fotoDePerfil">
                                - <img class="block m-auto p-auto h-20 w-20 object-cover" :src="'../../../../storage/' + alumno.fotoDePerfil "  alt="Foto de perfil" />
                            </span>
                        </dd>
                    </div>

                    <div v-if="alumno.exAlumno == 0" class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            División
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2" v-if="alumno.division">
                            <span v-if="alumno.orientacion_nombre">
                                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, alumno.division_id])">
                                    {{ alumno.nivel_nombre }} - 
                                    {{ alumno.orientacion_nombre }} - 
                                    {{ alumno.curso_nombre }} - 
                                    {{ alumno.division }}
                                </inertia-link>
                            </span>
                            <span v-else>
                                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, alumno.division_id])">
                                    {{ alumno.nivel_nombre }} - 
                                    {{ alumno.curso_nombre }} - 
                                    {{ alumno.division }}
                                </inertia-link>
                            </span>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Acciones
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link v-if="alumno.exAlumno == 0" class="hover:underline" :href="route('alumnos.edit', [institucion_id, alumno.id])">
                                Cambiar de curso
                            </inertia-link>

                            <inertia-link v-else class="hover:underline" :href="route('alumnos.edit', [institucion_id, alumno.id])">
                                Volver a anotarse
                            </inertia-link>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Libreta
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('libretas.index', [institucion_id, alumno.id])">Ver</inertia-link>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Asignaturas que debe
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('asignaturas-adeudadas.index', [institucion_id, alumno.id])">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>
                    
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Estadísticas
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('alumnos.mostrarCiclosLectivos', [institucion_id, alumno.id])">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Veces que repitió el alumno
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('repitentes.show', [institucion_id, alumno.id])">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>

                    <div v-if="alumno.exAlumno == 0" class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion'||tipo == 'Directivo' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Repetir curso
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <primary>
                                <template #boton-primary>
                                    <inertia-link :href="route('repitentes.createRepitente', [institucion_id, alumno.id])">Procesar</inertia-link>
                                </template>
                            </primary>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion'|| tipo == 'Directivo' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Ex alumno
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <primary v-if="alumno.exAlumno == 0">
                                <template #boton-primary>
                                    <inertia-link :href="route('exalumnos.createExAlumno', [institucion_id, alumno.id])">Procesar</inertia-link>
                                </template>
                            </primary>

                            <span v-else>Ya lo es</span>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Padre/s
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-for="padre in padres" :key="padre.id">
                                <inertia-link class="hover:underline" :href="route('padres.show', [institucion_id, padre.id])">{{ padre.user.name }}</inertia-link><br>
                            </span>
                        </dd>
                    </div>

                </template>
            </estructura-informacion>
            
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraInformacion from '@/Datos/EstructuraInformacion.vue'
    import Editar from '@/Botones/Editar.vue'
    import Primary from '@/Botones/Primary.vue'

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
            Editar,
            Primary,
        },

        props: {
            successMessage: String,
            institucion_id: String,
            tipo: String,
            alumno: Object,
            padres: Array,
        },

        title: 'Perfil alumno',

        methods: {
            cerrarAlerta() {
                this.successMessage = false;
            },
        }
    }
</script>
