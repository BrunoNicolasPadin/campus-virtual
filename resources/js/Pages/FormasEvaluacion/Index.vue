<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-1/2">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('instituciones.show', institucion_id)">Perfil institucional</inertia-link> /
                        Formas de evaluación
                    </span>
                </div>
                <div class="w-1/2">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('formas-evaluacion.create', institucion_id)">Agregar</inertia-link>
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
                                    Nombre
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Tipo
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
                            
                            <tr v-for="(formaEvaluacion, index) in formasEvaluacion" :key="formaEvaluacion.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ formaEvaluacion.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ formaEvaluacion.tipo }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link v-if="formaEvaluacion.tipo == 'Escrita'" :href="route('formas-evaluacion.show', [institucion_id, formaEvaluacion.id])" class="hover:underline">
                                            Ingresar
                                        </inertia-link>
                                        <span v-else>-</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('formas-evaluacion.edit', [institucion_id, formaEvaluacion.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <button @click="destroy(formaEvaluacion.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
            formasEvaluacion: Array,
        },

        title: 'Formas de evaluación',

        methods: {
            destroy(id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta forma de evaluación?')) {
                    this.$inertia.delete(this.route('formas-evaluacion.destroy', [this.institucion_id, id]))
                }
            },
        }
    }
</script>
