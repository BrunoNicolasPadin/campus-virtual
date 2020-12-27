<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <inertia-link :href="route('divisiones.index', institucion_id)">Estructura</inertia-link>
                     > 
                    <inertia-link :href="route('divisiones.show', [institucion_id, division.id])">
                        <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                        <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                    </inertia-link>
                     > 
                    <inertia-link :href="route('evaluaciones.index', [institucion_id, division.id])">Evaluaciones</inertia-link>
                     > 
                    <inertia-link :href="route('evaluaciones.show', [institucion_id, division.id, evaluacion.id])">{{ evaluacion.titulo }}</inertia-link>
                     > 
                    <inertia-link :href="route('entregas.index', [institucion_id, division.id, evaluacion.id])">Entregas</inertia-link>
                     > 
                    {{ entrega.alumno.user.name }}
                </h2>
            </h2>
        </template>

        <!-- Success Message -->

            <div v-if="successMessage" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                    <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z"
                        ></path>
                </svg>
                <span class="text-green-800">{{ successMessage }} </span>
            </div>

        <div class="py-12">
            <estructura-informacion>
                <template #cabecera-info>
                    Datos
                </template>

                <template #dl-contenido>
                    
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Alumno
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            {{ entrega.alumno.user.name }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Calificacion
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-if="entrega.calificacion">{{ entrega.calificacion }}</span>
                            <span v-else>Sin  calificar</span>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Fecha y hora de entrega
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-if="entrega.fechaHoraEntrega">{{ entrega.fechaHoraEntrega }}</span>
                            <span v-else>Sin entregar</span>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Comentario
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-if="entrega.comentario">{{ entrega.comentario }}</span>
                            <span v-else>Sin  comentarios</span>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Calificar y comentar
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link :href="route('entregas.edit', [institucion_id, division.id, evaluacion.id, entrega.id])">
                                <editar></editar>
                            </inertia-link>
                        </dd>
                    </div>
                </template>
            </estructura-informacion>

            <div class="container mx-auto px-4 sm:px-8">
                <div class="flex">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Archivos entregados</h2>
                    </div>
                    <div class="w-1/2">
                        <primary class="float-right">
                            <template #boton-primary>
                                <inertia-link :href="route('entregas-archivos.create', [institucion_id, division.id, evaluacion.id, entrega.id])">
                                    Agregar
                                </inertia-link>
                            </template>
                        </primary>
                    </div>
                </div>

                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">

                    <li v-for="archivo in archivos" :key="archivo.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                <a :href="'/storage/evaluaciones/entregas/' + archivo.archivo" target="_blank" class="text-blue-500" rel="noopener noreferrer">
                                    {{ archivo.archivo }}
                                </a>
                            </span>
                        </div>

                        <div class="ml-4 flex-shrink-0">
                            <span @click="destroyArchivo(archivo.id)" class="font-medium text-red-600 hover:text-red-500 cursor-pointer" type="submit">
                                Eliminar
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraInformacion from '@/Datos/EstructuraInformacion.vue'
    import Primary from '@/Botones/Primary.vue'
    import Editar from '@/Botones/Editar.vue'
    import Eliminar from '@/Botones/Eliminar.vue'

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
            Primary,
            Editar,
            Eliminar,
        },

        props: {
            successMessage: String,
            institucion_id: String,
            division: Object,
            evaluacion: Object,
            entrega: Object,
            archivos: Array,
        },

        methods: {
            destroyArchivo(archivo_id) {
                if (confirm('Estas seguro de que desea eliminar este archivo?')) {
                    this.$inertia.delete(this.route('entregas-archivos.destroy', [this.institucion_id, this.division.id, this.evaluacion.id, this.entrega.id, archivo_id]))
                }
            },
        },
    }
</script>
