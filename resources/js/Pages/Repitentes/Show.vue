<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('repitentes.index', institucion_id)">Repitentes</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                Repeticiones
            </span>
        </template>

        <div class="py-6">
            <estructura-tabla>
                <template #tabla>

                    <table-head-estructura>
                        <template #th>

                            <table-head>
                                <template #th-titulo>
                                    #
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    División
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Ciclo lectivo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Comentario
                                </template>
                            </table-head>

                            <table-head colspan="2" v-show="tipo == 'Institucion' || tipo == 'Directivo'">
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(repeticion, index) in repeticiones" :key="repeticion.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="repeticion.division.orientacion_id !== null">
                                            <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, repeticion.division_id])">
                                                {{ repeticion.division.nivel.nombre }} - {{ repeticion.division.orientacion.nombre }} - 
                                                {{ repeticion.division.curso.nombre }} - {{ repeticion.division.division }}
                                            </inertia-link>
                                        </span>

                                        <span v-else>
                                            <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, repeticion.division_id])">
                                                {{ repeticion.division.nivel.nombre }} - 
                                                {{ repeticion.division.curso.nombre }} - {{ repeticion.division.division }}
                                            </inertia-link>
                                        </span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ repeticion.comienzo }} - {{ repeticion.final }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ repeticion.comentario }}
                                    </template>
                                </table-data>


                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo'">
                                    <template #td>
                                        <inertia-link :href="route('repitentes.edit', [institucion_id, repeticion.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo'">
                                    <template #td>
                                        <button @click="destroy(repeticion.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                            Eliminar
                                        </button>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'
    import Eliminar from '@/Botones/Eliminar'
    import Editar from '@/Botones/Editar.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Eliminar,
            Editar,
        },

        props:{ 
            institucion_id: String,
            alumno: Object,
            repeticiones: Array,
            tipo: String,
        },

        title: 'Repeticiones de un alumno',

        methods: {
            destroy(id) {
                if (confirm('Estas seguro de que desea eliminar a este repitente?')) {
                    this.$inertia.delete(this.route('repitentes.destroy', [this.institucion_id, id]))
                }
            },
        }
    }
</script>
