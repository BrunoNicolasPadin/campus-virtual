<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-1/2">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        Estructura
                    </span>
                </div>
                <div class="w-1/2" v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('divisiones.create', institucion_id)">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
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

                            <table-head colspan="3">
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

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <inertia-link :href="route('divisiones.edit', [institucion_id, division.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <button @click="destroy(division.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <pagination :links="divisiones.links" />
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
    import Editar from '@/Botones/Editar'
    import Eliminar from '@/Botones/Eliminar'
    import Primary from '@/Botones/Primary.vue'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Editar,
            Eliminar,
            Primary,
            Pagination,
        },

        title: 'Estructura',

        props:{ 
            institucion_id: String,
            tipo: String,
            divisiones: Object,
        },

        methods: {
            destroy(id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta división?')) {
                    this.$inertia.delete(this.route('divisiones.destroy', [this.institucion_id, id]))
                }
            },
        }
    }
</script>
