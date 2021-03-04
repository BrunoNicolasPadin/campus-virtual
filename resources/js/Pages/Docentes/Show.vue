<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('docentes.index', institucion_id)">Docentes</inertia-link> /
                {{ docente.name }}
            </span>
        </template>

        <div class="py-6">
            <!-- <estructura-informacion>
                <template #cabecera-info>
                    Datos
                </template>

                <template #dl-contenido>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Nombre
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ docente.name }}<span v-show="docente.profile_photo_path">
                                - <img class="block m-auto p-auto h-20 w-20 object-cover" :src="'../../../../storage/' + docente.profile_photo_path "  alt="Foto de perfil" />
                            </span>
                        </dd>
                    </div>

                </template>
            </estructura-informacion> -->

            <div class="container mx-auto px-4 sm:px-8">
                <div class="flex">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Asignaturas y  divisiones</h2>
                    </div>
                    <div class="w-1/2">
                        <button @click="agregarAsignaturas()" type="button" class="float-right border border-blue-500 bg-blue-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 select-none hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
            
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
                                    Asignatura
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Nivel
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Orientación
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Curso
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    División
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(division, index) in divisiones.data" :key="division.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.nivel_nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="division.orientacion_nombre">{{ division.orientacion_nombre }}</span>
                                        <span v-else >-</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.curso_nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.division }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('divisiones.show', [institucion_id, division.id])" class="hover:underline">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <pagination :links="divisiones.links" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraInformacion from '@/Datos/EstructuraInformacion.vue'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Pagination,
        },

        props: {
            institucion_id: String,
            docente: Object,
            divisiones: Object,
        },

        created() {
            title: 'Perfil docente';
        },

        methods: {
            agregarAsignaturas() {
                this.$inertia.get(this.route('docentes.createAsignaturaDocente', [this.institucion_id, this.docente.id]))
            },
        }

    }
</script>
