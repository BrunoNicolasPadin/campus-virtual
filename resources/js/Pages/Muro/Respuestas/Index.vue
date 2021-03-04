<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion_nombre">{{ division.nivel_nombre }} - {{ division.orientacion_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel_nombre }} - {{ division.curso_nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('muro.index', [institucion_id, division.id])">Muro</inertia-link> / 
                Respuestas
            </span>
        </template>

        <div class="py-6">

            <div class="container mx-auto px-4 sm:px-8 my-6">

                <h2 class="text-2xl font-semibold leading-tight">Publicación</h2>

                <div class="bg-white rounded shadow-sm p-8 my-2">
                    <div class="flex justify-between mb-1">
                        <p class="text-grey-darkest leading-normal text-lg whitespace-pre-wrap">{{ publicacion.publicacion }}</p>
                    </div>
                    <div class="text-grey-dark leading-normal text-sm">
                        <p>
                            {{ publicacion.user.name }} <span class="mx-1 text-xs">&bull;</span> 
                            {{ publicacion.updated_at }}
                        </p>
                    </div>
                </div>

                <div v-if="state === 'default'" class="bg-white rounded shadow-sm p-8 mb-4 my-4">
                    <form method="post" @submit.prevent="submit">
                        <textarea
                            v-model="form.respuesta"
                            placeholder="Escriba su respuesta aqui"
                            class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3">
                        </textarea>
                        <div class="mt-3">
                            <guardar></guardar>
                        </div>
                    </form>
                </div>

                <div v-show="state === 'editing'">
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
                            {{ respuesta.user.name }} <span class="mx-1 text-xs">&bull;</span> 
                            {{ respuesta.updated_at }}
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
            institucion_id: String,
            user_id: Number,
            division: Object,
            publicacion: Object,
            respuestas: Object,
            tipo: String,
        },

        title: 'Respuestas',

        data() {
            return {
                form: {
                    respuestas: null,
                },
                updateForm: {
                    id: null,
                    respuestas: null,
                },
                state: 'default',
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('muro-respuestas.store', [this.institucion_id, this.division.id, this.publicacion.id]), this.form)
            },

            editar(respuesta) {
                this.state = 'editing';
                this.updateForm.id = respuesta.id;
                this.updateForm.respuesta = respuesta.respuesta;
            },

            updateRespuesta() {
                this.cancelarEdicion();
                var respuesta_id = this.updateForm.id;
                this.$inertia.put(this.route('muro-respuestas.update', [this.institucion_id, this.division.id, this.publicacion.id, respuesta_id]), this.updateForm)
            },

            cancelarEdicion() {
                this.state = 'default';
            },

            destroyRespuesta(respuesta_id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta respuesta?')) {
                    this.cancelarEdicion();
                    this.$inertia.delete(this.route('muro-respuestas.destroy', [this.institucion_id, this.division.id, this.publicacion.id, respuesta_id]))
                }
            },
        },
    }
</script>
