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
                <inertia-link class="hover:underline" :href="route('mesas.index', [institucion_id, division.id, asignatura.id])">Mesas de {{ asignatura.nombre }}</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('mesas.show', [institucion_id, division.id, asignatura.id, mesa.id])">Mesa {{ mesa.fechaHoraRealizacion }} - {{ mesa.fechaHoraFinalizacion }}</inertia-link> / 
                Estadísticas
            </span>
        </template>

        <div class="py-6">
            <estructura-informacion>
                <template #cabecera-info>
                    Números
                </template>

                <template #dl-contenido>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Aprobados
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.aprobados }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Desaprobados
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.desaprobados }}
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Sin calificar
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.sinCalificar }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Entregas
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.entregados }}
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Entregados a tiempo
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.entregadosTiempo }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Entregados a destiempo
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.entregasDestiempo }}
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            No entregados
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.noEntregados }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Con correcciones
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.conCorreccion }}
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Sin correcciones
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.sinCorreccion }}
                        </dd>
                    </div>

                    <div v-show="tipoEvaluacion !== 'Escrita' " class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Mejor nota
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ numeros.mejorNota }}
                        </dd>
                    </div>
                </template>
            </estructura-informacion>

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">Aprobados</h2>
            </div>

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
                                    Calificación
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Entrega
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            <tr v-for="(aprobado, index) in numerosArray.aprobados" :key="aprobado.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ aprobado.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ aprobado.calificacion }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, division.id, asignatura.id, mesa.id, aprobado.id])">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">Desaprobados</h2>
            </div>

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
                                    Calificación
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Entrega
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            <tr v-for="(desaprobado, index) in numerosArray.desaprobados" :key="desaprobado.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ desaprobado.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ desaprobado.calificacion }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, division.id, asignatura.id, mesa.id, desaprobado.id])">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">Sin calificar</h2>
            </div>

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
                                    Entrega
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            <tr v-for="(sinCalificar, index) in numerosArray.sinCalificar" :key="sinCalificar.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ sinCalificar.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, division.id, asignatura.id, mesa.id, sinCalificar.id])">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">Entregados</h2>
            </div>

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
                                    A tiempo
                                </template>
                            </table-head>

                            <table-head>
                                <template #th-titulo>
                                    Entrega
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            <tr v-for="(entregado, index) in numerosArray.entregados" :key="entregado.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ entregado.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <span v-if="entregado.tiempo">Si</span>
                                        <span v-else>No</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, division.id, asignatura.id, mesa.id, entregado.id])">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8">
                <h2 class="text-2xl font-semibold leading-tight">No entregados</h2>
            </div>

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
                                    Entrega
                                </template>
                            </table-head>
                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            <tr v-for="(noEntregado, index) in numerosArray.noEntregados" :key="noEntregado.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ noEntregado.nombre }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, division.id, asignatura.id, mesa.id, noEntregado.id])">
                                            Ingresar
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
    import EstructuraInformacion from '@/Datos/EstructuraInformacion.vue'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
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
            asignatura: Object,
            mesa: Object,
            numerosArray: Object,
            numeros: Object,
            tipoEvaluacion: String,
        },

        title: 'Mesa - Estadisticas',
    }
</script>
