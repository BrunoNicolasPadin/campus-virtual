<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                            <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                            <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                        </inertia-link> / Evaluaciones
                    </span>
                </div>
                <div class="w-4/12" v-show="tipo == 'Docente' || tipo == 'Directivo' || tipo == 'Institucion'">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('evaluaciones.create', [institucion_id, division.id])">Agregar</inertia-link>
                        </template>
                    </primary>
                </div>
            </div>
            
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form method="get">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccionar asignatura:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.asignatura_id">

                                    <option selected value="">Todas</option>
                                    <option v-for="asignatura in asignaturas" :key="asignatura.id" :value="asignatura.id">
                                        {{ asignatura.nombre }}
                                    </option>

                                </select>
                            </div>
                        </div>
                    </form>
                </template>
            </estructura-form>

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
                                    Título
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Asignatura
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Tipo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Realización
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Finalización
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(evaluacion, index) in evaluaciones.data" :key="evaluacion.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('evaluaciones.show', [institucion_id, division.id, evaluacion.id])">
                                            {{ evaluacion.titulo }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ evaluacion.asignatura.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ evaluacion.tipo }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ evaluacion.fechaHoraRealizacion }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ evaluacion.fechaHoraFinalizacion }}
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <pagination :links="evaluaciones.links" />
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
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'

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
            EstructuraForm,
            LabelForm,
        },

        props:{ 
            institucion_id: String,
            tipo: String,
            division: Object,
            evaluaciones: Object,
            asignatura_id_seleccionada: String,
            asignaturas: Array,
        },

        title: 'Evaluaciones',

        data() {
            return {
                form: {
                    asignatura_id: this.asignatura_id_seleccionada,
                },
            }
        },

        methods: {
            destroy(id) {
                if (confirm('Estas seguro de que desea eliminar esta evaluacion?')) {
                    this.$inertia.delete(this.route('evaluaciones.destroy', [this.institucion_id, this.division.id, id]))
                }
            },

            onChange() {
                if (this.form.asignatura_id == '') {
                    this.$inertia.get(this.route('evaluaciones.index', [this.institucion_id, this.division.id]))
                } else {
                    this.$inertia.get(this.route('evaluaciones.filtrarPorAsignatura', [this.institucion_id, this.division.id, this.form.asignatura_id]))
                }
                
            },
        }
    }
</script>
