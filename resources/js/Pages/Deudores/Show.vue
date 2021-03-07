<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                <inertia-link class="hover:underline" :href="route('asignaturas-adeudadas.index', [institucion_id, alumno.id])">
                    Asignatura adeudadas y/o ya rendidas
                </inertia-link> / Mesas inscriptas en {{ asignatura.nombre }}
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
                                    Fecha y hora
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Calificación
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
                            
                            <tr v-for="(mesa, index) in mesas.data" :key="mesa.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ mesa.fechaHoraRealizacion }} - {{ mesa.fechaHoraFinalizacion }}
                                    </template>
                                </table-data>

                                <table-data v-for="inscripcion in mesa.inscripcion" :key="inscripcion.id">
                                    <template #td>
                                        <span v-if="inscripcion.calificacion">{{ inscripcion.calificacion }}</span>
                                        <span v-else>Sin calificar</span>
                                    </template>
                                </table-data>

                                <table-data v-for="inscripcion in mesa.inscripcion" :key="inscripcion.id">
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, mesa.asignatura.division_id, mesa.asignatura_id, mesa.id, inscripcion.id])">
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
                <pagination :links="mesas.links" />
            </div>
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

        props:{ 
            institucion_id: String,
            mesas: Object,
            alumno: Object,
            asignatura: Object,
        },

        title: 'Inscripciones a las mesas de una asignatura',
    }
</script>
