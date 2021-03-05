<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('asignaturas.index', [institucion_id, division.id])">Asignaturas</inertia-link> /
                {{ asignatura.nombre }} / Estadísticas
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

            <div v-show="mostrar" class="container mx-auto px-4 sm:px-8">
                <highcharts :options="chartOptions"></highcharts>
                <hr class="my-6">
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
                                    Nombre
                                </template>
                            </table-head>

                            <table-head v-for="periodo in periodos" :key="periodo">
                                <template #th-titulo>
                                    {{ periodo }}
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(calificacionAlumno, index) in calificacionesAlumnos" :key="calificacionAlumno.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ calificacionAlumno.nombre }}
                                    </template>
                                </table-data>

                                <table-data v-for="calificacion in calificacionAlumno.calificaciones" :key="calificacion.id">
                                    <template #td>
                                        {{ calificacion }}
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

        props: {
            institucion_id: String,
            division: Object,
            asignatura: Object,
            ciclosLectivos: Array,
            ciclo_lectivo_id: String,
        },

        title: 'Asignatura - Estadistica',

        data() {
            return {
                promedios: [],
                periodos: [],
                calificacionesAlumnos: [],
                calificacionesPorPeriodos: [],
                opciones: [],
                mostrar: false,
                form: {
                    ciclo_lectivo_id: this.ciclo_lectivo_id,
                },
                chartOptions: [],
            }
        },

        methods: {
            onChange() {
                axios.get(this.route('asignaturas.mostrarPromedios', [this.institucion_id, this.division.id, this.asignatura.id, this.form.ciclo_lectivo_id]))
                .then(response => {
                    this.mostrar = true;

                    if (response.data[0] == 'No escrita') {
                        
                        this.promedios = response.data[1];
                        this.periodos = response.data[2];
                        this.calificacionesAlumnos = response.data[3];

                        this.chartOptions = {
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
                                text: 'Cantidad de veces que obtuvieron cada calificación por periodo'
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
