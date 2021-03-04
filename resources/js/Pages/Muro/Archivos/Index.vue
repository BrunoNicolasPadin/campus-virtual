<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('muro.index', [institucion_id, division.id])">Muro</inertia-link> / 
                Archivos
            </span>
        </template>

        <div class="py-6">

            <div class="container mx-auto px-4 sm:px-8">

                <h2 class="text-2xl font-semibold leading-tight">Publicación</h2>

                <div class="bg-white rounded shadow-sm p-8 my-6">
                    <div class="flex justify-between mb-1">
                        <p class="text-grey-darkest leading-normal text-lg whitespace-pre-wrap">{{ publicacion.publicacion }}</p>
                    </div>
                    <div class="text-grey-dark leading-normal text-sm">
                        <p>
                            {{ publicacion.user.name }} <span class="mx-1 text-xs">&bull;</span> 
                            {{ publicacion.updated_at }}
                        </p>
                    </div>
                </div>

                <div class="flex my-2">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Archivos</h2>
                    </div>
                    <div class="w-1/2" v-show="publicacion.user.id == user_id ">
                        <primary class="float-right">
                            <template #boton-primary>
                                <inertia-link :href="route('muro-archivos.create', [institucion_id, division.id, publicacion.id])">Agregar</inertia-link>
                            </template>
                        </primary>
                    </div>
                </div>

                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">

                    <li v-for="archivo in archivos" :key="archivo.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                <a 
                                :href="'/storage/muro/' + archivo.archivo" 
                                target="_blank" 
                                class="text-blue-500 hover:underline"
                                rel="noopener noreferrer">
                                    {{ archivo.archivo }}
                                </a>
                            </span>
                        </div>

                        <div class="ml-4 flex-shrink-0" v-show="publicacion.user.id == user_id || tipo == 'Institucion' || tipo == 'Directivo' ">
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

    export default {
        components: {
            AppLayout,
            Primary,
        },

        props: {
            institucion_id: String,
            user_id: Number,
            division: Object,
            publicacion: Object,
            archivos: Array,
            tipo: String,
        },

        title: 'Archivos de la publicacion',

        methods: {
            destroyArchivo(archivo_id) {
                if (confirm('Estas seguro de que desea eliminar este archivo?')) {
                    this.$inertia.delete(this.route('muro-archivos.destroy', [this.institucion_id, this.division.id, this.publicacion.id, archivo_id]))
                }
            },
        },
    }
</script>
