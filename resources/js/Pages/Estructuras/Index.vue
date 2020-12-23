<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-1/2">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Estructura
                    </h2>
                </div>
                <div class="w-1/2">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('divisiones.create', institucion_id)">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
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
                                    Nivel
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Orientacion
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Curso
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Division
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
                            
                            <tr v-for="(division, index) in divisiones" :key="division.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.nivel.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="division.orientacion">{{ division.orientacion.nombre }}</span>
                                        <span v-else >-</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.curso.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ division.division }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('divisiones.show', [division.institucion_id, division.id])" class="hover:underline">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('divisiones.edit', [division.institucion_id, division.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
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
        },

        props:{ 
            institucion_id: String,
            divisiones: Array,
        },

        methods: {
            destroy(id) {
                if (confirm('Estas seguro de que dese eliminar esta division?')) {
                    this.$inertia.delete(this.route('divisiones.destroy', [this.institucion_id, id]))
                }
            },
        }
    }
</script>
