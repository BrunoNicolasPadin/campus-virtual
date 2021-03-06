<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.index', institucion_id)">Alumnos</inertia-link> /
                <inertia-link class="hover:underline" :href="route('alumnos.show', [institucion_id, alumno.id])">{{ alumno.name }}</inertia-link> /
                Estadísticas
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

            <div v-if="division !== null " class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">
                    {{ division }}
                </h2>
            </div>

            <div v-show="mostrar" class="container mx-auto px-4 sm:px-8">
                <highcharts :options="chartOptions"></highcharts>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import axios from 'axios'

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
        },

        title: 'Alumno - Estadisticas',

        data() {
            return {
                promedios: [],
                periodos: [],
                calificacionesPorPeriodos: [],
                opciones: [],
                division: null,
                mostrar: false,
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id,
                },
                chartOptions: [],
            }
        },

        methods: {
            onChange() {
                axios.get(this.route('alumnos.mostrarEstadisticas', [this.institucion_id, this.alumno.id, this.form.ciclo_lectivo_id]))
                .then(response => {
                    this.mostrar = true;
                    if (response.data[0] == 'No escrita') {

                        this.promedios = response.data[1];
                        this.periodos = response.data[2];
                        this.division = response.data[3];

                        this.chartOptions = {
                            chart: {
                                type: 'column'
                            },
                            xAxis: {
                                categories: this.periodos
                            },
                            yAxis: {
                                title: {
                                    text: 'Calificaciones'
                                }
                            },
                            series: [{
                                data: this.promedios,
                                dataLabels: {
                                    enabled: true
                                }
                            }],
                            title: {
                                text: 'Promedios'
                            }
                        }
                    }
                    else {
                        this.periodos = response.data[1];
                        this.opciones = response.data[2];
                        this.calificacionesPorPeriodos = response.data[3];
                        this.calificacionesAlumnos = response.data[4];
                            
                        this.chartOptions = {
                            chart: {
                                type: 'bar'
                            },
                            xAxis: {
                                categories: this.opciones,
                                title: {
                                    text: null
                                }
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    align: 'high'
                                },
                                labels: {
                                    overflow: 'justify'
                                }
                            },
                            series: this.generateSeries(this.opciones, this.periodos, this.calificacionesPorPeriodos),
                            title: {
                                text: 'Cantidad de veces que el alumno obtuvo cada calificación por periodo'
                            }
                        }
                    }
                })
                .catch(e => {
                    // Podemos mostrar los errores en la consola
                    console.log(e);
                })
            },

            generateSeries(opciones, periodos, calificacionesPorPeriodos) {
                var series = [];
                var k = 0;

                for (let index = 0; index < periodos.length; index++) {
                        
                    series.push({
                        name: periodos[index],
                        data: this.generateData(opciones, periodos[index], calificacionesPorPeriodos),
                    })
                }
                return series;
            },

            generateData(opciones, periodo, calificacionesPorPeriodos)
            {
                var data = [];

                for (let index = 0; index < opciones.length; index++) {
                    
                    data.push(calificacionesPorPeriodos[periodo][opciones[index]]);
                }
                return data;
            }
        }
    }
</script>
