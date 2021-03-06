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
                        </inertia-link> / 
                        Grupos de materiales
                    </span>
                </div>
                <div class="w-4/12" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                    <primary class="float-right">
                        <template #boton-primary>
                            <inertia-link :href="route('materiales.create', [institucion_id, division.id])">Agregar</inertia-link>
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
                                        Seleccionar asignatura de la cual desea ver sus grupos:
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
                                    Nombre
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Asignatura
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

                                <table-data>
                                    <template #td>
                                        {{ grupo.asignatura.nombre }}
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
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'
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
            Primary,
            Pagination,
            EstructuraForm,
            LabelForm,
        },

        props:{ 
            institucion_id: String,
            tipo: String,
            division: Object,
            asignaturas: Array,
            grupos: Object,
            asignatura_id_index: String,
        },

        title: 'Grupos',

        data() {
            return {
                form: {
                    asignatura_id: this.asignatura_id_index,
                },
            }
        },

        methods: {
            onChange() {
                this.$inertia.replace(this.route('materiales.index', {institucion_id: this.institucion_id, division_id: this.division.id, asignatura_id: this.form.asignatura_id}))
            },
        }
    }
</script>
