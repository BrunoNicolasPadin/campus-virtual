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
                Mesa {{ mesa.fechaHoraRealizacion }} - {{ mesa.fechaHoraFinalizacion }}
            </span>
        </template>

        <div class="py-6">
            <estructura-informacion>
                <template #cabecera-info>
                    Datos
                </template>

                <template #dl-contenido>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Asignatura
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ mesa.asignatura.nombre }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha y hora
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ mesa.fechaHoraRealizacion }} - {{ mesa.fechaHoraFinalizacion }}
                        </dd>
                    </div>


                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Comentario/Temas
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ mesa.comentario }}</dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Estadísticas
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link class="hover:underline" :href="route('mesas.estadisticas', [institucion_id, division.id, asignatura.id, mesa.id])">
                                Ver
                            </inertia-link>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Acciones
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link :href="route('mesas.edit', [institucion_id, division.id, asignatura.id, mesa.id])">
                                <editar></editar>
                            </inertia-link>

                            <form method="post" @submit.prevent="destroyMesa(mesa.id)">
                                <eliminar></eliminar>
                            </form>
                        </dd>
                    </div>
                </template>
            </estructura-informacion>

            <div class="container mx-auto px-4 sm:px-8 my-6" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                <div class="flex">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Archivos</h2>
                    </div>
                    <div class="w-1/2">
                        <primary class="float-right">
                            <template #boton-primary>
                                <inertia-link :href="route('mesas-archivos.create', [institucion_id, division.id, asignatura.id, mesa.id])">Agregar</inertia-link>
                            </template>
                        </primary>
                    </div>
                </div>

                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">

                    <li v-for="archivo in archivos" :key="archivo.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                <a
                                :href="'https://gescol.s3-sa-east-1.amazonaws.com/Mesas/Archivos/' + archivo.archivo" 
                                target="_blank" 
                                class="text-blue-500 hover:underline"
                                rel="noopener noreferrer">
                                    {{ archivo.archivo }} | <span v-if="archivo.visibilidad">Visible</span> <span v-else>No visible</span>
                                </a>
                            </span>
                        </div>

                        <div class="ml-4 flex-shrink-0">
                            <inertia-link
                            :href="route('mesas-archivos.edit', [institucion_id, division.id, asignatura.id, mesa.id, archivo.id])"
                            class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline">
                                Editar
                            </inertia-link>
                            -
                            <span 
                            @click="destroyArchivo(archivo.id)" 
                            class="font-medium text-red-600 hover:text-red-500 hover:underline cursor-pointer"
                            type="submit">
                                Eliminar
                            </span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="container mx-auto px-4 sm:px-8">
                <div class="flex">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Inscripciones</h2>
                    </div>
                    <div class="w-1/2" v-show="tipo == 'Alumno' && puedeAnotarse == true ">
                        <span @click="submit()">
                            <primary class="float-right">
                                <template #boton-primary>
                                    inscribirse
                                </template>
                            </primary>
                        </span>
                    </div>
                    <div class="w-1/2" v-show="tipo == 'Alumno' && puedeAnotarse == false ">
                        <span @click="desinscribirse()">
                            <primary class="float-right">
                                <template #boton-primary>
                                    Desinscribirse
                                </template>
                            </primary>
                        </span>
                    </div>
                </div>
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

                            <table-head v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                                <template #th-titulo>
                                    Calificación
                                </template>
                            </table-head>

                            <table-head colspan="2">
                                <template #th-titulo>
                                    Acciones
                                </template>
                            </table-head>

                        </template>
                    </table-head-estructura>

                    <table-body>
                        <template #tr>
                            
                            <tr v-for="(inscripcion, index) in inscripciones.data" :key="inscripcion.id">
                                <table-data>
                                    <template #td>
                                        {{ index + 1 }}
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        {{ inscripcion.alumno.user.name }}
                                    </template>
                                </table-data>

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                                    <template #td>
                                        <span v-if="inscripcion.calificacion">{{ inscripcion.calificacion }}</span>
                                        <span v-else>Sin  calificar</span>
                                    </template>
                                </table-data>

                                <table-data>
                                    <template #td>
                                        <inertia-link class="hover:underline" :href="route('inscripciones.show', [institucion_id, division.id, asignatura.id, mesa.id, inscripcion.id])">
                                            Ingresar
                                        </inertia-link>
                                    </template>
                                </table-data>

                                <table-data v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                                    <template #td>
                                        <button @click="destroy(inscripcion.id)" type="submit" class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                            Eliminar
                                        </button>
                                    </template>
                                </table-data>
                            </tr>
                        </template>
                    </table-body>
                </template>
            </estructura-tabla>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <pagination :links="inscripciones.links" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Primary from '@/Botones/Primary.vue'
    import Editar from '@/Botones/Editar.vue'
    import Eliminar from '@/Botones/Eliminar.vue'
    import EstructuraInformacion from '@/Datos/EstructuraInformacion.vue'
    import EstructuraTabla from '@/Tabla/EstructuraTabla'
    import TableHeadEstructura from '@/Tabla/TableHeadEstructura'
    import TableHead from '@/Tabla/TableHead'
    import TableBody from '@/Tabla/TableBody'
    import TableData from '@/Tabla/TableData'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            Primary,
            Editar,
            Eliminar,
            EstructuraInformacion,
            EstructuraTabla,
            TableHeadEstructura,
            TableHead,
            TableBody,
            TableData,
            Pagination,
        },

        props: {
            institucion_id: String,
            tipo: String,
            division: Object,
            asignatura: Object,
            mesa: Object,
            inscripciones: Object,
            archivos: Array,
            puedeAnotarse: Boolean,
            inscripcion_id: Number,
        },

        title: 'Mesa de examen',

        methods: {
            destroyMesa(mesa_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta mesa de examen?')) {
                    this.$inertia.delete(this.route('mesas.destroy', [this.institucion_id, this.division.id, this.asignatura.id, mesa_id]))
                }
            },
    
            destroy(inscripcion_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta inscripción?')) {
                    this.$inertia.delete(this.route('inscripciones.destroy', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, inscripcion_id]))
                }
            },

            submit() {
                if (confirm('¿Estás seguro de que desea inscribirse en esta mesa de examen?')) {
                    this.$inertia.post(this.route('inscripciones.store', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id]))
                }
            },

            desinscribirse() {
                if (confirm('¿Estás seguro de que deseas desinscribirte de esta mesa de examen?')) {
                    this.$inertia.delete(this.route('inscripciones.destroy', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.inscripcion_id]))
                }
            },

            destroyArchivo(archivo_id) {
                if (confirm('¿Estás seguro de que deseas eliminar este archivo?')) {
                    this.$inertia.delete(this.route('mesas-archivos.destroy', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, archivo_id]))
                }
            },
        },
    }
</script>
