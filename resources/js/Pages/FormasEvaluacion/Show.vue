<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-1/2">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('instituciones.show', institucion_id)">Perfil institucional</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('formas-evaluacion.index', institucion_id)">Formas de evaluación</inertia-link> / 
                        {{ formaEvaluacion.nombre }}
                    </span>
                </div>
                <div class="w-1/2">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('formas-descripcion.create', [institucion_id, formaEvaluacion.id])">Agregar</inertia-link>
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
                                    Opcion
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Aprobado
                                </template>
                            </table-head>

                            <table-head colspan="2">
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(formaDescripcion, index) in formasDescripcion" :key="formaDescripcion.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ formaDescripcion.opcion }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="formaDescripcion.aprobado">
                                            Si
                                        </span>

                                        <span v-else>
                                            No
                                        </span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('formas-descripcion.edit', [institucion_id, formaEvaluacion.id, formaDescripcion.id])">
                                            <editar></editar>
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <button @click="destroy(formaDescripcion.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
            Primary,
        },

        props:{ 
            institucion_id: String,
            formaEvaluacion: Object,
            formasDescripcion: Array,
        },

        title: 'Descripción de las formas de evaluación',

        methods: {
            destroy(id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta forma de descripción?')) {
                    this.$inertia.delete(this.route('formas-descripcion.destroy', [this.institucion_id, this.formaEvaluacion.id, id]))
                }
            },
        }
    }
</script>
