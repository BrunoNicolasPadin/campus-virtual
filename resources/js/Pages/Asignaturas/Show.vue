<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-full">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                        > 
                        <inertia-link :href="route('divisiones.show', [institucion_id, division.id])">
                            <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                            <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                        </inertia-link>
                        > 
                        <inertia-link :href="route('asignaturas.index', [institucion_id, division.id])">Asignaturas</inertia-link>
                         > 
                        {{ asignatura.nombre }}
                    </h2>
                </div>
            </div>
            
        </template>

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

        <div class="py-6">
            <div class="container mx-auto px-4 sm:px-8">
                <div class="flex">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Mesas</h2>
                    </div>
                    <div class="w-1/2" v-if="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                        <primary class="float-right">
                            <template #boton-primary>
                                <inertia-link :href="route('mesas.create', [institucion_id, division.id, asignatura.id])">Agregar</inertia-link>
                            </template>
                        </primary>
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
                                    Fecha y hora
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
                            
                            <tr v-for="(mesa, index) in mesas.data" :key="mesa.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ mesa.fechaHora }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('mesas.show', [institucion_id, division.id, asignatura.id, mesa.id])" class="hover:underline">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-if="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <inertia-link :href="route('mesas.edit', [institucion_id, division.id, asignatura.id, mesa.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-if="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <button @click="destroy(mesa.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <pagination :links="mesas.links" />
            </div>

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">Grupos de materiales</h2>
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
                                    Nombre
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(grupo, index) in grupos.data" :key="grupo.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('materiales.show', [institucion_id, division.id, grupo.id])">
                                            {{ grupo.nombre }}
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <pagination :links="grupos.links" />
            </div>
            
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Primary from '@/Botones/Primary.vue'
    import Editar from '@/Botones/Editar.vue'
    import Eliminar from '@/Botones/Eliminar.vue'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            Primary,
            Editar,
            Eliminar,
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
            tipo: String,
            division: Object,
            asignatura: Object,
            mesas: Object,
            grupos: Object,
        },

        title: 'Perfil de la asignatura',

        methods: {
            destroy(mesa_id) {
                if (confirm('Estas seguro de que desea eliminar esta mesa?')) {
                    this.$inertia.delete(this.route('mesas.destroy', [this.institucion_id, this.division.id, this.asignatura.id, mesa_id]))
                }
            },

            cerrarAlerta() {
                this.successMessage = false;
            },
        },
    }
</script>
