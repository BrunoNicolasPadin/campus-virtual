<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-1/2">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                        Asignaturas adeudadas y ya aprobadas
                    </span>
                </div>
                <div class="w-1/2" v-if="tipo == 'Institucion' || tipo == 'Directivo' ">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('asignaturas-adeudadas.create', [institucion_id, alumno.id])">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
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
                                    Asignatura
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Ciclo lectivo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Aprobado
                                </template>
                            </table-head>

                            <table-head colspan="3">
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(deuda, index) in deudas.data" :key="deuda.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('mesas.index', [institucion_id, deuda.asignatura.division_id, deuda.asignatura_id])" class="hover:underline">
                                            {{ deuda.asignatura.nombre }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ deuda.comienzo }} - {{ deuda.final }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="deuda.aprobado">Si</span>
                                        <span v-else>No</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('asignaturas-adeudadas.show', [institucion_id, alumno.id, deuda.id])">
                                            Mesas anotadas
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-if="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <inertia-link :href="route('asignaturas-adeudadas.edit', [institucion_id, alumno.id, deuda.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-if="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <button @click="destroy(deuda.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <pagination :links="deudas.links" />
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
    import Eliminar from '@/Botones/Eliminar'
    import Pagination from '@/Pagination/Pagination.vue'
    import Editar from '@/Botones/Editar.vue'
    import Primary from '@/Botones/Primary.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Eliminar,
            Pagination,
            Editar,
            Primary,
        },

        props:{ 
            successMessage: String,
            institucion_id: String,
            tipo: String,
            deudas: Object,
            alumno: Object,
        },

        title: 'Asignaturas que debe',

        methods: {
            destroy(id) {
                if (confirm('Estas seguro de que desea eliminar esta asignatura que debe el alumno?')) {
                    this.$inertia.delete(this.route('asignaturas-adeudadas.destroy', [this.institucion_id, this.alumno.id, id]))
                }
            },
            
            cerrarAlerta() {
                this.successMessage = false;
            },
        }
    }
</script>
