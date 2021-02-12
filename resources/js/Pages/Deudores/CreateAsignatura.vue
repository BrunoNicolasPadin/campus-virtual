<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.user.name }}</inertia-link> /
                <inertia-link class="hover:underline" :href="route('asignaturas-adeudadas.index', [institucion_id, alumno.id])">
                    Asignatura adeudadas y/o ya rendidas
                </inertia-link> / Agregar asignaturas
            </span>
        </template>

        <div class="py-12">

            <!-- Errors Messages -->

            <transition name="fade">
                <div v-if="Object.keys(errors).length > 0 && mostrarErrores" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                    <div class="w-1/12">
                        <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                            <path fill="currentColor" d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="w-9/12">
                        <span class="text-red-800"> {{ errors[Object.keys(errors)[0]][0] }} </span>
                    </div>
                    <div class="w-2/12">
                        <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                    </div>
                </div>
            </transition>

            <estructura-form>
                <template #formulario>
                    <form method="post">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Division
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                @change="onChange()"
                                v-model="form.division_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="division in divisiones" :key="division.id" :value="division.id">
                                        <span v-if="division.orientacion">
                                            {{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}
                                        </span>

                                        <span v-else>
                                            {{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}
                                        </span>
                                    </option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Sino aparece seleccionada no se haga problema y continue ;).
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Ciclo lectivo
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.ciclo_lectivo_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio. Seleccione un ciclo lectivo.
                                    </template>
                                </info>
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
                                    Seleccionar
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(asignatura, index) in asignaturas" :key="asignatura.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ asignatura.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <input type="checkbox" :id="asignatura.nombre" :value="asignatura.id" v-model="form.asignatura_id">
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                    <form method="post" @submit.prevent="submit">
                        <guardar></guardar>
                    </form>
                </template>
            </estructura-tabla>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
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
            Info,
            Guardar,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
        },

        props: {
            errors: Object,
            institucion_id: String,
            alumno: Object,
            divisiones: Array,
            asignaturas: Array,
            ciclosLectivos: Array,
        },

        title: 'Adeudar asignaturas - Seleccionar asignaturas',

        data() {
            return {
                form: {
                    asignatura_id: [],
                    ciclo_lectivo_id: null,
                },
                mostrarErrores: true,
            }
        },

        methods: {
            cerrarAlerta() {
                this.mostrarErrores = false;
            },

            onChange() {
                this.$inertia.get(this.route('asignaturas-adeudadas.createAsignatura', [this.institucion_id, this.alumno.id, this.form.division_id]))
            },

            submit() {
                this.$inertia.post(this.route('asignaturas-adeudadas.store', [this.institucion_id, this.alumno.id]), this.form)
            },
        },
    }
</script>
