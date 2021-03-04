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
                <inertia-link class="hover:underline" :href="route('mesas.show', [institucion_id, division.id, asignatura.id, mesa.id])">Mesa {{ mesa.fechaHora }}</inertia-link> / 
                Entrega de {{ anotado.alumno.user.name }}
            </span>
        </template>

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
                            {{ anotado.alumno.user.name }}
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Calificación
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-if="anotado.calificacion">{{ anotado.calificacion }}</span>
                            <span v-else>Sin  calificar</span>
                        </dd>
                    </div>

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Comentario
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <span v-if="anotado.comentario">{{ anotado.comentario }}</span>
                            <span v-else>Sin  comentarios</span>
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                        <dt class="text-sm font-medium text-gray-500">
                            Calificar y comentar
                        </dt>
                        <dd class="text-center mt-1 text-sm text-gray-500 sm:mt-0 sm:col-span-2">
                            <inertia-link :href="route('anotados.edit', [institucion_id, division.id, asignatura.id, mesa.id, anotado.id])">
                                <editar></editar>
                            </inertia-link>
                        </dd>
                    </div>
                </template>
            </estructura-informacion>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <div class="flex">
                    <div class="w-full">
                        <h2 class="text-2xl font-semibold leading-tight">Archivos de la mesa</h2>
                    </div>
                </div>

                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">
                    <li v-for="archivo in archivos" :key="archivo.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span v-if="archivo.visibilidad || tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' " class="ml-2 flex-1 w-0 truncate">
                                <a
                                :href="'/storage/mesas/archivos/' + archivo.archivo" 
                                target="_blank" 
                                class="text-blue-500 hover:underline"
                                rel="noopener noreferrer">
                                    {{ archivo.archivo }}
                                </a>
                            </span>
                            <span v-else class="ml-2 flex-1 w-0 truncate">
                                Archivo no visible por el momento.
                            </span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="container mx-auto px-4 sm:px-8">
                <div class="flex">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Archivos entregados</h2>
                    </div>
                    <div class="w-1/2" v-show="tipo == 'Alumno' ">
                        <primary class="float-right">
                            <template #boton-primary>
                                <inertia-link :href="route('rendir-entregas.create', [institucion_id, division.id, asignatura.id, mesa.id, anotado.id])">
                                    Agregar
                                </inertia-link>
                            </template>
                        </primary>
                    </div>
                </div>

                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">

                    <li v-for="entrega in entregas" :key="entrega.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                <a :href="'/storage/deudores/entregas/' + entrega.archivo" target="_blank" class="text-blue-500 hover:text-blue-700 hover:underline" rel="noopener noreferrer">
                                    {{ entrega.archivo }}
                                </a>
                            </span>
                        </div>

                        <div class="ml-4 flex-shrink-0" v-show="tipo == 'Alumno' ">
                            <span @click="destroyArchivo(entrega.id)" class="font-medium text-red-600 hover:text-red-500 cursor-pointer" type="submit">
                                Eliminar
                            </span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <div class="flex">
                    <div class="w-1/2">
                        <h2 class="text-2xl font-semibold leading-tight">Correcciones</h2>
                    </div>
                    <div class="w-1/2" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                        <primary class="float-right">
                            <template #boton-primary>
                                <inertia-link :href="route('rendir-correcciones.create', [institucion_id, division.id, asignatura.id, mesa.id, anotado.id])">
                                    Agregar
                                </inertia-link>
                            </template>
                        </primary>
                    </div>
                </div>

                <ul class="my-2 bg-white border border-blue-100 rounded-md divide-y divide-gray-200">

                    <li v-for="correccion in correcciones" :key="correccion.id" class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <span class="ml-2 flex-1 w-0 truncate">
                                <a :href="'/storage/deudores/correcciones/' + correccion.archivo" target="_blank" class="text-blue-500 hover:text-blue-700 hover:underline" rel="noopener noreferrer">
                                    {{ correccion.archivo }}
                                </a>
                            </span>
                        </div>

                        <div class="ml-4 flex-shrink-0" v-show="tipo == 'Institucion' || tipo == 'Directivo' || tipo == 'Docente' ">
                            <span @click="destroyCorreccion(correccion.id)" class="font-medium text-red-600 hover:text-red-500 cursor-pointer" type="submit">
                                Eliminar
                            </span>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="container mx-auto px-4 sm:px-8 my-6">
                <div v-show="state === 'default'">
                    <h2 class="text-2xl font-semibold leading-tight">Comentarios</h2>
                    <div class="bg-white rounded shadow-sm p-8 mb-4 my-4">
                        <form method="post" @submit.prevent="submit">
                            <textarea
                                v-model="form.comentario"
                                placeholder="Escriba aqui su comentario"
                                class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3">
                            </textarea>
                            <div class="mt-3">
                                <guardar></guardar>
                            </div>
                        </form>
                    </div>
                </div>

                <div v-show="state === 'editing'">
                    <h2 class="text-2xl font-semibold leading-tight">Actualizar comentario</h2>

                    <div class="bg-white rounded shadow-sm p-8 mb-4 my-4">
                        <form method="post" @submit.prevent="updateComentario">
                            <textarea
                                v-model="updateForm.comentario"
                                class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3">
                            </textarea>
                            <div class="mt-3">
                                <div class="flex flex-col md:flex-row items-center mt-2">
                                    <guardar></guardar>
                                    <button 
                                    type="button"
                                    @click="cancelarEdicion()"
                                    class="border border-indigo-500 bg-indigo-500 text-white rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-indigo-700 focus:outline-none focus:shadow-outline">
                                        Cancelar
                                    </button>
                                    <form method="post" @submit.prevent="destroyComentario(updateForm.id)">
                                        <eliminar></eliminar>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="bg-white rounded shadow-sm p-8 my-2" v-for="comentario in comentarios.data" :key="comentario.id">
                    <div class="flex justify-between mb-1">
                        <p class="text-grey-darkest leading-normal text-lg whitespace-pre-wrap">{{ comentario.comentario }}</p>
                        <button 
                             v-show="comentario.user_id == user_id || tipo == 'Institucion' || tipo == 'Directivo' "
                            class="ml-2 mt-1 mb-auto text-blue hover:underline text-sm" 
                            @click="editar(comentario)">
                                Editar
                        </button>
                    </div>
                    <div class="text-grey-dark leading-normal text-sm">
                        <p>
                            {{ comentario.user.name }} <span class="mx-1 text-xs">&bull;</span> 
                            {{ comentario.updated_at }}
                        </p>
                    </div>
                </div>

                 <pagination :links="comentarios.links" />
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
    import Guardar from '@/Botones/Guardar.vue'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            EstructuraInformacion,
            Primary,
            Editar,
            Eliminar,
            Guardar,
            Pagination,
        },

        props: {
            institucion_id: String,
            tipo: String,
            user_id: Number,
            division: Object,
            asignatura: Object,
            mesa: Object,
            anotado: Object,
            archivos: Array,
            entregas: Array,
            correcciones: Array,
            comentarios: Object,
        },

        title: 'Ver entrega',

        data() {
            return {
                form: {
                    comentario: null,
                },
                updateForm: {
                    id: null,
                    comentario: null,
                },
                state: 'default',
            }
        },

        methods: {
            
            destroyArchivo(archivo_id) {
                if (confirm('Estas seguro de que desea eliminar este archivo?')) {
                    this.$inertia.delete(this.route('rendir-entregas.destroy', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.anotado.id, archivo_id]))
                }
            },

            destroyCorreccion(archivo_id) {
                if (confirm('Estas seguro de que desea eliminar esta correccion?')) {
                    this.$inertia.delete(this.route('rendir-correcciones.destroy', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.anotado.id, archivo_id]))
                }
            },

            submit() {
                this.$inertia.post(this.route('rendir-comentarios.store', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.anotado.id]), this.form)
            },

            editar(comentario) {
                this.state = 'editing';
                this.updateForm.id = comentario.id;
                this.updateForm.comentario = comentario.comentario;
            },

            updateComentario() {
                this.cancelarEdicion();
                var entregas_comentario = this.updateForm.id;
                this.$inertia.put(this.route('rendir-comentarios.update', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.anotado.id, entregas_comentario]), this.updateForm)
            },

            cancelarEdicion() {
                this.state = 'default';
            },

            destroyComentario(comentario_id) {
                if (confirm('Estas seguro de que desea eliminar este comentario?')) {
                    this.cancelarEdicion();
                    this.$inertia.delete(this.route('rendir-comentarios.destroy', [this.institucion_id, this.division.id, this.asignatura.id, this.mesa.id, this.anotado.id, comentario_id]))
                }
            },
        },
    }
</script>
