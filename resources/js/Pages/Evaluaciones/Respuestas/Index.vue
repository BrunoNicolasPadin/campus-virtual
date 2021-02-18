<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('evaluaciones.index', [institucion_id, division.id])">Evaluaciones</inertia-link> / 
                <inertia-link class="hover:underline" :href="route('evaluaciones.show', [institucion_id, division.id, evaluacion.id])">{{ evaluacion.titulo }}</inertia-link> / 
                Respuestas
            </span>
        </template>

        <!-- Errors Messages -->

        <transition name="fade">
            <div v-if="Object.keys(errors).length > 0 && mostrarErrores" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                <div class="w-1/12">
                    <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                        <path fill="currentColor" d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z"
                        ></path>
                    </svg>
                </div>
                <div class="w-9/12">
                    <span class="text-red-800"> {{ errors[Object.keys(errors)[0]][0] }} </span>
                </div>
                <div class="w-2/12">
                    <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                </div>
            </div>
        </transition>

        <!-- Success Message -->

        <transition name="fade">
            <div v-if="successMessage" class="bg-green-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                <div class="w-1/12">
                    <svg viewBox="0 0 24 24" class="text-green-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                        <path fill="currentColor" d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">

                        </path>
                    </svg>
                </div>
                <div class="w-9/12">
                    <span class="text-green-800 float-left">{{ successMessage }} </span>
                </div>
                <div class="w-2/12">
                    <span class="text-black font-bold float-right text-2xl cursor-pointer" @click="cerrarAlerta()">&times;</span> 
                </div>
            </div>
        </transition>

        <div class="py-4">

            <div class="container mx-auto px-4 sm:px-8 my-6">

                <h2 class="text-2xl font-semibold leading-tight">Comentario</h2>

                <div class="bg-white rounded shadow-sm p-8 my-2">
                    <div class="flex justify-between mb-1">
                        <p class="text-grey-darkest leading-normal text-lg whitespace-pre-wrap">{{ comentario.comentario }}</p>
                    </div>
                    <div class="text-grey-dark leading-normal text-sm">
                        <p>
                            {{ comentario.user.name }} <span class="mx-1 text-xs">&bull;</span> 
                            {{ comentario.updated_at }}
                        </p>
                    </div>
                </div>

                <div class="my-6" v-show="state === 'default'">
                    <h2 class="text-2xl font-semibold leading-tight">Respuestas</h2>
                    <div class="bg-white rounded shadow-sm p-8 mb-4 my-4">
                        <form method="post" @submit.prevent="submit">
                            <textarea
                                v-model="form.respuesta"
                                placeholder="Escriba aqui su respuesta"
                                class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3">
                            </textarea>
                            <div class="mt-3">
                                <guardar></guardar>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="my-6" v-show="state === 'editing'">
                    <h2 class="text-2xl font-semibold leading-tight">Actualizar respuesta</h2>

                    <div class="bg-white rounded shadow-sm p-8 mb-4 my-4">
                        <form method="post" @submit.prevent="updateRespuesta">
                            <textarea
                                v-model="updateForm.respuesta"
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
                                    <form method="post" @submit.prevent="destroyRespuesta(updateForm.id)">
                                        <eliminar></eliminar>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="bg-white rounded shadow-sm p-8 my-2" v-for="respuesta in respuestas.data" :key="respuesta.id">
                    <div class="flex justify-between mb-1">
                        <p class="text-grey-darkest leading-normal text-lg whitespace-pre-wrap">{{ respuesta.respuesta }}</p>
                        <button 
                            v-show="respuesta.user.id == user_id || tipo == 'Institucion' || tipo == 'Directivo' "
                            class="ml-2 mt-1 mb-auto text-blue hover:underline text-sm" 
                            @click="editar(respuesta)">
                                Editar
                        </button>
                    </div>
                    <div class="text-grey-dark leading-normal text-sm">
                        <p>
                            {{ respuesta.user.name }} <span class="mx-1 text-xs">&bull;</span> {{ respuesta.updated_at }}
                        </p>
                    </div>
                </div>

                <pagination :links="respuestas.links" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Primary from '@/Botones/Primary.vue'
    import Eliminar from '@/Botones/Eliminar.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import Pagination from '@/Pagination/Pagination.vue'

    export default {
        components: {
            AppLayout,
            Primary,
            Eliminar,
            Guardar,
            Pagination,
        },

        props: {
            errors: Object,
            successMessage: String,
            institucion_id: String,
            user_id: Number,
            division: Object,
            evaluacion: Object,
            comentario: Object,
            respuestas: Object,
            tipo: String,
        },

        title: 'Respuestas',

        data() {
            return {
                form: {
                    respuesta: null,
                },
                updateForm: {
                    id: null,
                    respuesta: null,
                },
                state: 'default',
                mostrarErrores: true,
            }
        },

        methods: {

            submit() {
                this.$inertia.post(this.route('evaluaciones-respuestas.store', [this.institucion_id, this.division.id, this.evaluacion.id, this.comentario.id]), this.form)
            },

            editar(respuesta) {
                this.state = 'editing';
                this.updateForm.id = respuesta.id;
                this.updateForm.respuesta = respuesta.respuesta;
            },

            updateRespuesta() {
                this.cancelarEdicion();
                var evaluaciones_respuesta = this.updateForm.id;
                this.$inertia.put(this.route('evaluaciones-respuestas.update', [this.institucion_id, this.division.id, this.evaluacion.id, , this.comentario.id, evaluaciones_respuesta]), this.updateForm)
            },

            cancelarEdicion() {
                this.state = 'default';
            },

            destroyRespuesta(respuesta_id) {
                if (confirm('Estas seguro de que desea eliminar esta respuesta?')) {
                    this.cancelarEdicion();
                    this.$inertia.delete(this.route('evaluaciones-respuestas.destroy', [this.institucion_id, this.division.id, this.evaluacion.id, , this.comentario.id, respuesta_id]))
                }
            },

            cerrarAlerta() {
                this.successMessage = false;
                this.mostrarErrores = false;
            }
        },
    }
</script>
