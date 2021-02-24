<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('alumnosDivision.mostrar', [institucion_id, division.id])">Alumnos</inertia-link> /
                Hacerlos pasar de año
            </span>
        </template>

        <div class="py-6">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione la división a la que pasarán:
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.division_id">

                                    <option selected value="">Todas</option>
                                    <option v-for="division in divisiones" :key="division.id" :value="division.id">
                                        <span v-if="division.orientacion_nombre">
                                            {{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>

                                        <span v-else>
                                            {{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}
                                        </span>
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
                                    Foto de perfil
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Nombre
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(alumno, index) in alumnos" :key="alumno.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <a class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">
                                            {{ alumno.user.name }}
                                        </a>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <input type="checkbox" :id="alumno.id" :value="alumno.id" v-model="form.alumno_id">
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
    import EstructuraTabla from '@/Tabla/EstructuraTabla.vue'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura.vue'
    import TableHead from '@/Tabla/TableHead.vue'
    import TableBody from '@/Tabla/TableBody.vue'
    import TableData from '@/Tabla/TableData.vue'
    import Guardar from '@/Botones/Guardar.vue'
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
            Guardar,
            EstructuraForm,
            LabelForm,
        },

        props: {
            institucion_id: String,
            user_id: Number,
            division: Object,
            divisiones: Array,
            alumnos: Array,
        },

        title: 'Hacerlos pasar de año',

        data() {
            return {
                form: {
                    alumno_id: [],
                    division_id: null,
                },
                mostrarErrores: true,
            }
        },

        methods: {
            cerrarAlerta() {
                this.mostrarErrores = false;
            },

            submit() {
                this.$inertia.post(this.route('alumnosDivision.cambiarCurso', [this.institucion_id, this.division.id]), this.form)
            },
        },
    }
</script>
