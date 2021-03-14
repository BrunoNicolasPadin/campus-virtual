<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                <inertia-link class="hover:underline" :href="route('asignaturas-adeudadas.index', [institucion_id, alumno.id])">
                    Asignatura adeudadas y/o ya rendidas
                </inertia-link> / Agregar asignaturas
            </span>
        </template>

        <div class="py-6">
            <estructura-form>
                <template #formulario>
                    <form method="post">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        División
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                @change="onChange()"
                                v-model="form.division_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="division in divisiones" :key="division.id" :value="division.id">
                                        <span v-if="division.orientacion_nombre">
                                            {{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>

                                        <span v-else>
                                            {{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>
                                    </option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Seleccionar ciclo lectivo
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
                                        Es obligatorio.
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

                            <!-- <table-head>
                                <template #th-titulo>
                                    #
                                </template>
                            </table-head> -->

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
                            
                            <tr v-for="asignatura in asignaturas" :key="asignatura.id">
                                <!-- <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data> -->

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
            institucion_id: String,
            alumno: Object,
            division_id_seleccionada: String,
            divisiones: Array,
            asignaturas: Array,
            ciclosLectivos: Array,
        },

        title: 'Adeudar asignaturas - Seleccionar asignaturas',

        data() {
            return {
                form: {
                    asignatura_id: [],
                    division_id: this.division_id_seleccionada,
                    ciclo_lectivo_id: null,
                },
            }
        },

        methods: {
            onChange() {
                this.$inertia.get(this.route('asignaturas_adeudadas.create_asignatura', [this.institucion_id, this.alumno.id, this.form.division_id]))
            },

            submit() {
                this.$inertia.post(this.route('asignaturas-adeudadas.store', [this.institucion_id, this.alumno.id]), this.form)
            },
        },
    }
</script>
