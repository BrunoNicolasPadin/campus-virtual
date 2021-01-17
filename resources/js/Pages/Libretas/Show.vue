<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.user.name }}</inertia-link>
                 > Libreta
            </h2>
        </template>

        <div class="py-12">

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
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

                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
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
                                    Asignatura
                                </template>
                            </table-head>

                            <table-head v-for="periodo in periodos" :key="periodo">
                                <template #th-titulo>
                                    {{ periodo }}
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

                                <table-data>
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
            successMessage: String,
            institucion_id: String,
            alumno: Object,
            ciclosLectivos: Array,
            periodos: Array,
            ciclo_lectivo_id: String,
            libretas: Array,
        },

        title: 'Ver libreta',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id,
                },
            }
        },

        methods: {
            onChange() {
                this.$inertia.get(this.route('libretas.show', [this.institucion_id, this.alumno.id, this.form.ciclo_lectivo_id]))
            }
        }
    }
</script>
