<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                            <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                            <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                        </inertia-link> / 
                        <inertia-link class="hover:underline" :href="route('materiales.index', [institucion_id, division.id])">Grupos de materiales</inertia-link> / 
                        {{ grupo.nombre }}
                    </span>
                </div>
                <div class="w-4/12" v-show="tipo == 'Docente' ">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('materiales-archivos.create', [institucion_id, division.id, grupo.id])">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
        </template>

        <div class="py-6">

            <!-- Success Message -->

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

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">Archivos</h2>
                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">
                    <li v-for="archivo in archivos" :key="archivo.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                <a 
                                v-if="archivo.visibilidad || tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' " 
                                :href="'/storage/materiales/' + archivo.archivo" 
                                target="_blank" 
                                class="text-blue-500 hover:underline"
                                rel="noopener noreferrer">
                                    <span v-if="archivo.visibilidad">
                                        (Es visible) - 
                                    </span>
                                    <span v-else>
                                        (No es visible) - 
                                    </span>
                                    {{ archivo.nombre }}
                                    
                                </a>
                                <span v-else class="text-gray-500">
                                    {{ archivo.nombre }} 
                                </span>
                            </span>
                        </div>

                        <div class="ml-4 flex-shrink-0" v-show="tipo == 'Docente' ">
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

    export default {
        components: {
            AppLayout,
            Primary,
        },

        props:{ 
            successMessage: String,
            institucion_id: String,
            tipo: String,
            division: Object,
            grupo: Object,
            archivos: Array,
        },

        title: 'Grupo',

        methods: {
            destroyArchivo(id) {
                if (confirm('Estas seguro de que desea eliminar este archivo?')) {
                    this.$inertia.delete(this.route('materiales-archivos.destroy', [this.institucion_id, this.division.id, this.grupo.id, id]))
                }
            },

            cerrarAlerta() {
                this.successMessage = false;
            }
        }
    }
</script>
