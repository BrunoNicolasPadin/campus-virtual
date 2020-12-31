<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
        </template>

        <!-- Errors Messages -->

        <div v-if="Object.keys(errors).length > 0" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
            <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                <path fill="currentColor" d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z"
                ></path>
            </svg>
            <span class="text-red-800"> {{ errors[Object.keys(errors)[0]][0] }} </span>
        </div>

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
                                    Seleccionar
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            <tr>
                                <table-data>
                                    <template #td>
                                        1
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        Directivo
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <input @change="aparecerClaveDeAcceso()" type="radio" value="Directivo" v-model="form.tipo" />
                                    </template>
                                </table-data>
                            </tr>

                            <tr>
                                <table-data>
                                    <template #td>
                                        2
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        Docente
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <input @change="aparecerClaveDeAcceso()" type="radio" value="Docente" v-model="form.tipo" />
                                    </template>
                                </table-data>
                            </tr>

                            <tr>
                                <table-data>
                                    <template #td>
                                        3
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        Alumno
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <input @change="desaparecerClaveDeAcceso()" type="radio" value="Alumno" v-model="form.tipo" />
                                    </template>
                                </table-data>
                            </tr>

                            <tr>
                                <table-data>
                                    <template #td>
                                        4
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        Padre, madre o tutor
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <input @change="aparecerClaveDeAcceso()" type="radio" value="Padre" v-model="form.tipo" />
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <estructura-form v-if="mostrar">
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Clave de acceso
                                    </template>
                                </label-form>
                                
                                <input-form required type="password" v-model="form.claveDeAcceso" />
                                
                                <info>
                                    <template #info>
                                        Ingrese la clave de acceso que el instituto le dio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <guardar></guardar>
                    </form>
                </template>
            </estructura-form>

            <estructura-form v-else>
                <template #formulario>
                    <button type="button" class="border border-yellow-200 bg-yellow-200 text-black rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-yellow-400 focus:outline-none focus:shadow-outline">
                        <inertia-link :href="route('alumnos.create', institucion_id)">Registrarse como alumno</inertia-link>
                    </button>
                </template>
            </estructura-form>
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
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import InputForm from '@/Formulario/InputForm.vue'
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import Primary from '@/Botones/Primary.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            Primary,
        },

        props:{ 
            errors: Object,
            institucion_id: String,
        },

        data() {
            return {
                form: {
                    tipo: false,
                    claveDeAcceso: null,
                },
                mostrar: true,
            }
        },

        methods: {
            desaparecerClaveDeAcceso() {
                if (this.form.tipo == 'Alumno') {
                    this.mostrar = false;
                }
            },

            aparecerClaveDeAcceso() {
                if (this.form.tipo != 'Alumno') {
                    this.mostrar = true;
                }
            },

            submit() {
                if (this.form.tipo == 'Directivo') {
                    this.$inertia.post(this.route('directivos.store', this.institucion_id), this.form)
                }
                if (this.form.tipo == 'Docente') {
                    this.$inertia.post(this.route('docentes.store', this.institucion_id), this.form)
                }
                if (this.form.tipo == 'Alumno') {
                    this.$inertia.post(this.route('alumnos.create', this.institucion_id), this.form)
                }
                if (this.form.tipo == 'Padre') {
                    alert('Padre');
                }
            },
        },
    }
</script>
