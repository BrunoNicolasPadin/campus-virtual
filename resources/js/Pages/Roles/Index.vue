<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
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
                                        <input type="radio" value="Directivo" v-model="form.tipo" />
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
                                        <input type="radio" value="Docente" v-model="form.tipo" />
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
                                        <input type="radio" value="Alumno" v-model="form.tipo" />
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
                                        <input type="radio" value="Padre" v-model="form.tipo" />
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <estructura-form>
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
        },

        props:{ 
            institucion_id: String,
        },

        data() {
            return {
                form: {
                    tipo: false,
                    claveDeAcceso: null,
                },
            }
        },

        methods: {
            submit() {
                if (this.form.tipo == 'Directivo') {
                    alert('Directivo');
                }
                if (this.form.tipo == 'Docente') {
                    this.$inertia.post(this.route('docentes.store', this.institucion_id), this.form)
                }
                if (this.form.tipo == 'Alumno') {
                    alert('Alumno');
                }
                if (this.form.tipo == 'Padre') {
                    alert('Padre');
                }
            },
        },
    }
</script>
