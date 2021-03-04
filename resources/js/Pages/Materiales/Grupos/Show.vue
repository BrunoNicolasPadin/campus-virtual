<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                            <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                            <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                        </inertia-link> / 
                        <inertia-link class="hover:underline" :href="route('materiales.index', [institucion_id, division.id])">Grupos de materiales</inertia-link> / 
                        {{ grupo.nombre }}
                    </span>
                </div>
                <div class="w-4/12" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('materiales-archivos.create', [institucion_id, division.id, grupo.id])">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
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
                            {{ grupo.nombre }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Asignatura
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ grupo.asignatura.nombre }}
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Cantidad de archivos
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ cantidad }}
                        </dd>
                    </div>

                    <div v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' "  class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Acciones
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link :href="route('materiales.edit', [institucion_id, division.id, grupo.id])">
                                <editar></editar>
                            </inertia-link>

                            <form method="post" @submit.prevent="destroy(grupo.id)">
                                <eliminar></eliminar>
                            </form>
                        </dd>
                    </div>
                </template>
            </estructura-informacion>

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">Archivos</h2>
                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">
                    <li v-for="archivo in archivos" :key="archivo.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                <a 
                                v-if="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' " 
                                :href="'/storage/materiales/' + archivo.archivo" 
                                target="_blank" 
                                class="text-blue-500 hover:underline"
                                rel="noopener noreferrer">
                                    <span v-if="archivo.visibilidad">
                                        Es visible |  
                                    </span>
                                    <span v-else>
                                        No es visible |
                                    </span>
                                    {{ archivo.nombre }}
                                    
                                </a>
                                <span v-else class="text-gray-500">
                                    <a 
                                    v-if="archivo.visibilidad" 
                                    :href="'/storage/materiales/' + archivo.archivo" 
                                    target="_blank" 
                                    class="text-blue-500 hover:underline"
                                    rel="noopener noreferrer">
                                        {{ archivo.nombre }}
                                    </a>
                                </span>
                            </span>
                        </div>

                        <div class="ml-4 flex-shrink-0" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                            <inertia-link
                            :href="route('materiales-archivos.edit', [institucion_id, division.id, grupo.id, archivo.id])"
                            class="font-medium text-indigo-600 hover:text-indigo-500">
                                Editar
                            </inertia-link>
                            -
                            <span 
                            @click="destroyArchivo(archivo.id)" 
                            class="font-medium text-red-600 hover:text-red-500 cursor-pointer"
                            type="submit">
                                Eliminar
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Primary from '@/Botones/Primary.vue'
    import EstructuraInformacion from '@/Datos/EstructuraInformacion.vue'
    import Eliminar from '@/Botones/Eliminar.vue'
    import Editar from '@/Botones/Editar.vue'

    export default {
        components: {
            AppLayout,
            Primary,
            EstructuraInformacion,
            Eliminar,
            Editar,
        },

        props:{ 
            institucion_id: String,
            tipo: String,
            division: Object,
            grupo: Object,
            archivos: Array,
            cantidad: Number,
        },

        title: 'Grupo',

        methods: {
            destroy(id) {
                if (confirm('Estas seguro de que desea eliminar este grupo?')) {
                    this.$inertia.delete(this.route('materiales.destroy', [this.institucion_id, this.division.id, id]))
                }
            },

            destroyArchivo(id) {
                if (confirm('Estas seguro de que desea eliminar este archivo?')) {
                    this.$inertia.delete(this.route('materiales-archivos.destroy', [this.institucion_id, this.division.id, this.grupo.id, id]))
                }
            },
        }
    }
</script>
