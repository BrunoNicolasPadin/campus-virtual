<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                > 
                <inertia-link :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                </inertia-link>
                > 
                Horarios
            </h2>
        </template>

        <div class="py-12">
            <estructura-tabla>
                <template #tabla>
                    <table-head-estructura>
                        <template #th>
                            <table-head>
                                <template #th-titulo>
                                    Horas
                                </template>
                            </table-head>

                            <table-head v-for="dia in dias" :key="dia.index">
                                <template #th-titulo>
                                    {{ dia }}
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="semana in semanas" :key="semana.index">
                                <table-data>
                                    <template #td>
                                        {{ semana.horaDesde }} - {{ semana.horaHasta }}
                                    </template>
                                </table-data>

                                <table-data v-for="dia in dias" :key="dia.index">
                                    <template #td>
                                        {{ semana.asignatura }}
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
    import EstructuraTabla from '@/Tabla/EstructuraTabla.vue'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura.vue'
    import TableHead from '@/Tabla/TableHead.vue'
    import TableBody from '@/Tabla/TableBody.vue'
    import TableData from '@/Tabla/TableData.vue'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
        },

        props: {
            successMessage: String,
            institucion_id: String,
            division: Object,
            semanas: Object,
            dias: Array,
        },
    }
</script>
