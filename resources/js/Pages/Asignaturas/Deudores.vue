<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('asignaturas.index', [institucion_id, division.id])">Asignaturas</inertia-link> /
                Alumnos que se llevaron {{ asignatura.nombre }}
            </span>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form>
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione ciclo lectivo:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.ciclo_lectivo_id">

                                    <option selected value="">Todos</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>
                            </div>

                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione condición:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.aprobado">

                                    <option value="" selected>Todos</option>
                                    <option value="0">No aprobado</option>
                                    <option value="1">Aprobado</option>

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
                                    Ciclo lectivo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Aprobado
                                </template>
                            </table-head>

                            <table-head v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(deudor, index) in deudores.data" :key="deudor.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('alumnos.show', [institucion_id, deudor.alumno_id])" class="hover:underline">
                                            {{ deudor.alumno.user.name }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ deudor.comienzo }} - {{ deudor.final }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="deudor.aprobado">Si</span>
                                        <span v-else>No</span>
                                    </template>
                                </table-data>

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <button @click="destroy(deudor.alumno_id, deudor.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
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
                <pagination :links="deudores.links" />
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
            Eliminar,
            Pagination,
            EstructuraForm,
            LabelForm,
        },

        props:{ 
            institucion_id: String,
            tipo: String,
            division: Object,
            asignatura: Object,
            ciclosLectivos: Array,
            deudores: Object,
            ciclo_lectivo_id_index: String,
            aprobado_index: String,
        },

        title: 'Alumnos que se llevaron la asignatura',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id_index,
                    aprobado: this.aprobado_index,
                },
            }
        },

        methods: {
            destroy(alumno_id, id) {
                if (confirm('¿Estás seguro de que deseas eliminar a este alumno de la lista de deudores de la asignatura?')) {
                    this.$inertia.delete(this.route('asignaturas-adeudadas.destroy', [this.institucion_id, alumno_id, id]))
                }
            },

            onChange() {
                this.$inertia.replace(this.route('asignaturas.deudores', {institucion_id: this.institucion_id, division_id: this.division.id, asignatura_id: this.asignatura.id, ciclo_lectivo_id: this.form.ciclo_lectivo_id, aprobado: this.form.aprobado}))
            },
        }
    }
</script>
