<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Perfil institucional {{ institucion.user.name }}
            </span>
        </template>

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
                            {{ institucion.user.name }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Número
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ institucion.numero }}
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Fundación
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ institucion.fundacion }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Historia
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ institucion.historia }}</dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Plan de estudio
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <a 
                            :href="'/storage/planesDeEstudio/' + institucion.planDeEstudio" 
                            target="_blank" 
                            class="hover:underline hover:text-blue-500"
                            rel="noopener noreferrer">
                                Ver
                            </a>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Formas de evaluación
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link :href="route('formas-evaluacion.index', institucion.id)" class="hover:underline hover:text-blue-500">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>

                    <div v-show="tipo == 'Institucion' || tipo == 'Directivo' " class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Limpiar divisiones
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <button type="button" class="border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                                <inertia-link :href="route('mostrar_divisiones', institucion.id)">
                                    Procesar
                                </inertia-link>
                            </button>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Acciones
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link :href="route('instituciones.edit', institucion.id)">
                                <editar></editar>
                            </inertia-link>
                            <button @click="destroy()" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                Eliminar
                            </button>
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

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
            Editar,
        },

        props: {
            institucion: Object,
            successMessage: String,
            tipo: String,
        },

        title: 'Perfil institucional',

        methods: {
            destroy() {
                if (confirm('¿Estás seguro de que deseas eliminar esta institución?')) {
                    this.$inertia.delete(this.route('instituciones.destroy', this.institucion.id))
                }
            },
        }
    }
</script>
