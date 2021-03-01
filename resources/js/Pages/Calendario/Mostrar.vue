<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Calendario
            </span>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione año:
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.year">

                                    <option v-for="anio in anios" :key="anio.id" :value="anio">
                                        {{ anio }}
                                    </option>

                                </select>
                            </div>
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione mes:
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.mes">

                                    <option v-for="mes in mesesParaBuscar" :key="mes.id" :value="mes.Numero">
                                        {{ mes.Nombre }}
                                    </option>

                                </select>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <button type="submit" class="border border-indigo-500 bg-indigo-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline">
                                    Mostrar
                                </button>
                            </div>
                        </div>
                    </form>
                </template>
            </estructura-form>


            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="font-semibold leading-tight">{{ mesSeleccionado }}</h2>
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
                                    Titulo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Tipo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Dia y hora
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Division
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Asignatura
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body v-for="evaluacion in evasMesas" :key="evaluacion.id">
                        <template #tr>
                            <tr v-for="(eva, index) in evaluacion" :key="eva.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="eva.tipo == 'Mesa de examen' ">
                                            <inertia-link class="hover:underline" 
                                            :href="route('mesas.show', [eva.institucion_id, eva.division_id, eva.asignatura.id, eva.id])">
                                                Ingresar a la mesa
                                            </inertia-link>
                                        </span>

                                        <span v-else>
                                            <inertia-link class="hover:underline" 
                                            :href="route('evaluaciones.show', [eva.institucion_id, eva.division_id, eva.id])">
                                                {{ eva.titulo }}
                                            </inertia-link>
                                        </span>
                                        
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ eva.tipo }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ eva.fechaHora }}<span v-show="eva.fechaHoraFinalizacion !== '' "> - {{ eva.fechaHoraFinalizacion }}</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="eva.division.orientacion">
                                            <inertia-link class="hover:underline" 
                                            :href="route('divisiones.show', [eva.institucion_id, eva.division_id])">
                                                {{ eva.division.nivel.nombre }} - {{ eva.division.orientacion.nombre }} - 
                                                {{ eva.division.curso.nombre }} - {{ eva.division.division }}
                                            </inertia-link>
                                        </span>

                                        <span v-else>
                                            <inertia-link class="hover:underline" 
                                            :href="route('divisiones.show', [eva.institucion_id, eva.division_id])">
                                                {{ eva.division.nivel.nombre }} - 
                                                {{ eva.division.curso.nombre }} - {{ eva.division.division }}
                                            </inertia-link>
                                        </span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ eva.asignatura.nombre }}
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
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
        },

        props:{ 
            institucion_id: String,
            meses: Array,
            evasMesas: Array,
            anios: Array,
            mesesParaBuscar: Array,
            tipo: String,
            mesSeleccionado: String,
            anioSeleccionado: String,
        },

        title: 'Calendario',

        data() {
            return {
                form: {
                    year: this.anioSeleccionado,
                    mes: this.mesSeleccionado,
                },
            }
        },

        methods: {
            submit() {
                if (this.tipo == 'Institucion' || this.tipo == 'Directivo') {
                    this.$inertia.get(this.route('calendario-instituciones.mostrar', [this.institucion_id, this.form.year, this.form.mes]));
                }
                if (this.tipo == 'Alumno' || this.tipo == 'Padre') {
                    this.$inertia.get(this.route('calendario-alumnos.mostrar', [this.institucion_id, this.form.year, this.form.mes]));
                }
                if (this.tipo == 'Docente') {
                    this.$inertia.get(this.route('calendario-docentes.mostrar', [this.institucion_id, this.form.year, this.form.mes]));
                }
            },
        }
    }
</script>
