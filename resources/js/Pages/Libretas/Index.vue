<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <div class="w-8/12">
                    <span class="font-semibold text-md text-gray-800 leading-tight">
                        <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                        <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                        Libreta
                    </span>
                </div>
                <div v-show="mostrar" class="w-4/12">
                    <button type="button" class="float-right border border-indigo-500 bg-indigo-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline">
                        <a :href="route('libretas.exportarUna', [institucion_id, alumno.id, ciclo_lectivo_id])" target="_blank" rel="noopener noreferrer">Exportar</a>
                    </button>
                </div>
            </div>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione un ciclo lectivo:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.ciclo_lectivo_id">

                                    <option selected disabled value="">-</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>
                            </div>
                        </div>
                    </form>
                </template>
            </estructura-form>
                    
            <div v-if="libreta !== null " class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">
                    <span v-if="libreta.orientacion_nombre">{{ libreta.nivel_nombre }} - {{ libreta.orientacion_nombre }} - 
                        {{ libreta.curso_nombre }} - {{ libreta.division }}</span>

                    <span v-else>{{ libreta.nivel_nombre }} - {{ libreta.curso_nombre }} - {{ libreta.division }}</span>
                </h2>
            </div>

            <estructura-tabla v-show="mostrar">
                <template #tabla>

                    <table-head-estructura>
                        <template #th>
                            <table-head>
                                <template #th-titulo>
                                    Asignatura
                                </template>
                            </table-head>

                            <table-head v-for="periodo in periodos" :key="periodo">
                                <template #th-titulo>
                                    {{ periodo }}
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
                            <tr v-for="libreta in libretas" :key="libreta.id">
                                <table-data>
                                    <template #td>
                                        {{ libreta.asignatura.nombre }}
                                    </template>
                                </table-data>

                                <table-data v-for="calificacion in libreta.calificaciones" :key="calificacion.id">
                                    <template #td>
                                        {{ calificacion.calificacion }}
                                    </template>
                                </table-data>

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo' ">
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('libretas.edit', [institucion_id, alumno.id, libreta.id])">
                                            Calificar
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8" v-show="mostrar">
                <h2 class="text-2xl font-semibold leading-tight">Asignaturas adeudadas</h2>
            </div>

            <estructura-tabla v-show="mostrar">
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
                                    Aprobado
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(deuda, index) in deudas" :key="deuda.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('asignaturas.show', [institucion_id, deuda.asignatura.division_id, deuda.asignatura_id])" class="hover:underline">
                                            {{ deuda.asignatura.nombre }}
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="deuda.aprobado">Si</span>
                                        <span v-else>No</span>
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
    import Eliminar from '@/Botones/Eliminar'
    import axios from 'axios'

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
            Eliminar,
        },

        props:{ 
            institucion_id: String,
            tipo: String,
            alumno: Object,
            ciclosLectivos: Array,
        },

        title: 'Ver libreta',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id,
                },
                mostrar: false,
                libreta: null,
                periodos: [],
                libretas: [],
                deudas: [],
                ciclo_lectivo_id: 0,
            }
        },

        methods: {
            onChange() {
                axios.get(this.route('libretas.show', [this.institucion_id, this.alumno.id, this.form.ciclo_lectivo_id]))
                .then(response => {
                    this.mostrar = true;
                    this.libreta = response.data[0];
                    this.periodos = response.data[1];
                    this.libretas = response.data[2];
                    this.deudas = response.data[3];
                    this.ciclo_lectivo_id = response.data[4];
                })
                .catch(e => {
                    // Podemos mostrar los errores en la consola
                    console.log(e);
                })
            },
        }
    }
</script>
