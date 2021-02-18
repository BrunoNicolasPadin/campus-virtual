<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Roles
            </span>
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
                                        <inertia-link :href="route('directivos.index', institucion_id)" class="hover:underline">Directivos</inertia-link>
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
                                        <inertia-link :href="route('docentes.index', institucion_id)" class="hover:underline">Docentes</inertia-link>
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
                                        <inertia-link :href="route('alumnos.index', institucion_id)" class="hover:underline">Alumnos</inertia-link>
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
                                        <inertia-link :href="route('exalumnos.index', institucion_id)" class="hover:underline">Ex Alumnos</inertia-link>
                                    </template>
                                </table-data>
                            </tr>

                            <tr>
                                <table-data>
                                    <template #td>
                                        5
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link :href="route('repitentes.index', institucion_id)" class="hover:underline">Repitentes</inertia-link>
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
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'

    export default {
        components: {
            AppLayout,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
        },

        props:{ 
            institucion_id: String,
        },

        title: 'Roles',
    }
</script>
