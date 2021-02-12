<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.user.name }}</inertia-link> /
                Estadisticas
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
                                        Seleccione ciclo lectivo:
                                    </template>
                                </label-form>
                                
                                <select
                                @change="onChange()"
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.ciclo_lectivo_id">

                                    <option disabled selected value="">-</option>
                                    <option v-for="cicloLectivo in ciclosLectivos" :key="cicloLectivo.id" :value="cicloLectivo.id">
                                        {{ cicloLectivo.comienzo }} - {{ cicloLectivo.final }}
                                    </option>

                                </select>
                            </div>
                        </div>
                    </form>
                </template>
            </estructura-form>

            <div class="container mx-auto px-4 sm:px-8">
                <highcharts :options="chartOptions"></highcharts>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
        },

        props:{ 
            institucion_id: String,
            alumno: Object,
            ciclosLectivos: Array,
            ciclo_lectivo_id: String,
            promedios: Array,
            periodos: Array,
        },

        title: 'Alumno - Estadisticas',

        data() {
            return {
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id,
                },
                chartOptions: {
                    xAxis: {
                        categories: this.periodos
                    },
                    yAxis: {
                        title: {
                            text: 'Calificaciones'
                        },
                    },
                    series: [{
                        data: this.promedios,
                        dataLabels: {
                            enabled: true
                        }
                    }],
                    title: {
                        text: 'Promedios',
                    },
                }
            }
        },

        methods: {
            onChange() {
                this.$inertia.get(this.route('alumnos.mostrarEstadisticas', [this.institucion_id, this.alumno.id, this.form.ciclo_lectivo_id]))
            },
        }
    }
</script>
