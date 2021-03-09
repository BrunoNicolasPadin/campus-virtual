<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('roles.index', institucion_id)">Roles</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('repitentes.index', institucion_id)">Repitentes</inertia-link> /
                Números
            </span>
        </template>

        <div class="py-6">
            <div class="container mx-auto px-4 sm:px-8 my-2">
                <highcharts :options="cicloChartOptions"></highcharts>
            </div>


            <div class="container mx-auto px-4 sm:px-8 my-2">
                <hr class="my-6">
                <highcharts :options="divisionChartOptions"></highcharts>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        props:{ 
            institucion_id: String,
            ciclos: Array,
            ciclosCategorias: Array,
            divisiones: Array,
            divisionCategorias: Array,
        },

        title: 'Repitentes - Estadisticas',

        data() {
            return {
                cicloChartOptions: {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Repitentes por ciclo'
                    },
                    xAxis: {
                        categories: this.ciclosCategorias
                    },
                    yAxis: {
                        title: {
                            text: 'Cantidad'
                        }
                    },
                    series: [{
                        dataLabels: {
                            enabled: true
                        },
                        name: 'Ciclo',
                        data: this.ciclos
                    }]
                },

                divisionChartOptions: {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Repitentes por división'
                    },
                    xAxis: {
                        categories: this.divisionCategorias
                    },
                    yAxis: {
                        title: {
                            text: 'Cantidad'
                        }
                    },
                    series: [{
                        dataLabels: {
                            enabled: true
                        },
                        name: 'División',
                        data: this.divisiones
                    }]
                }
            }
        },
    }
</script>
