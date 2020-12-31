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
                Doceentes
            </h2>
        </template>

        <div class="py-12">
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
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(docente, index) in docentes" :key="docente.index">
                                <table-data>
                                    <template #td>
                                        {{ index }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        -
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <a class="hover:underline" :href="route('docentes.show', [institucion_id, docente.id])">
                                            {{ docente.user.name }}
                                        </a>
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
            docentes: Array,
        },
    }
</script>
