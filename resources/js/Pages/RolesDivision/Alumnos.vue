<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                > 
                <inertia-link :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                </inertia-link>
                > 
                Alumnos
            </h2>
        </template>

        <div class="py-12">
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
                                    Foto de perfil
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Nombre
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
                            
                            <tr v-for="(alumno, index) in alumnos.data" :key="alumno.index">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <a class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">
                                            {{ alumno.user.name }}
                                        </a>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <button @click="destroy(alumno.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                            Eliminar
                                        </button>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>
            <div class="container mx-auto px-4 sm:px-8 my-6">
                <pagination :links="alumnos.links" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraTabla from '@/Tabla/EstructuraTabla.vue'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura.vue'
    import TableHead from '@/Tabla/TableHead.vue'
    import TableBody from '@/Tabla/TableBody.vue'
    import TableData from '@/Tabla/TableData.vue'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Pagination,
        },

        props: {
            successMessage: String,
            institucion_id: String,
            division: Object,
            alumnos: Object,
        },

        methods: {
            destroy(alumno_id) {
                if (confirm('Estas seguro de que desea sacar de la division a este alumno?')) {
                    this.$inertia.get(this.route('alumnosDivision.sacarlo', [this.institucion_id, this.division.id, alumno_id]))
                }
            },
        },
    }
</script>
