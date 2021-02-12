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
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccione año:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.year">

                                    <option disabled selected value="">-</option>
                                    <option v-for="anio in anios" :key="anio.id" :value="anio">
                                        {{ anio }}
                                    </option>

                                </select>
                            </div>
                        </div>
                    </form>
                </template>
            </estructura-form>

            <div v-for="(mes, mindex) in meses" :key="mes.mindex">

                <div class="container mx-auto px-4 sm:px-8">
                    <h2 class="font-semibold leading-tight">{{ mes }}</h2>
                </div>

                <estructura-tabla>
                    <template #tabla>
                        <table-head-estructura>
                            <template #th>
                                <table-head>
                                    <template #th-titulo>
                                        Info
                                    </template>
                                </table-head>
                            </template>
                        </table-head-estructura>

                        <table-body v-for="(evaluacion, evaindex) in evasMesas" :key="evaluacion.id">
                            <template #tr>
                                <span v-if="evaindex == mindex">
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
                                                        Ingresar
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
                                                {{ eva.fechaHora }} - {{ eva.fechaHoraFinalizacion }}
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
                                </span>
                            </template>
                        </table-body>
                    </template>
                </estructura-tabla>
            </div>
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
        },

        title: 'Calendario',

        data() {
            return {
                form: {
                    year: null,
                },
            }
        },

        methods: {
            onChange() {
                this.$inertia.get(this.route('calendario.mostrar', [this.institucion_id, this.form.year]))
            },
        }
    }
</script>
