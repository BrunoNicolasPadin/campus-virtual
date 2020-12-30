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
                > Muro
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

            <div class="container mx-auto px-4 sm:px-8 my-6">

                <div v-if="state === 'default'" class="bg-white rounded shadow-sm p-8 mb-4 my-4">
                    <form method="post" @submit.prevent="submit">
                        <textarea
                            v-model="form.publicacion"
                            placeholder="Publique aqui"
                            class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3">
                        </textarea>
                        <div class="mt-3">
                            <guardar></guardar>
                        </div>
                    </form>
                </div>

                <div v-show="state === 'editing'">
                    <h2 class="text-2xl font-semibold leading-tight">Actualizar publicacion</h2>

                    <div class="bg-white rounded shadow-sm p-8 mb-4 my-4">
                        <form method="post" @submit.prevent="updatePublicacion">
                            <textarea
                                v-model="updateForm.publicacion"
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
                                    <form method="post" @submit.prevent="destroyPublicacion(updateForm.id)">
                                        <eliminar></eliminar>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="bg-white rounded shadow-sm p-8 my-2" v-for="publicacion in publicaciones.data" :key="publicacion.id">
                    <div class="flex justify-between mb-1">
                        <p class="text-grey-darkest leading-normal text-lg whitespace-pre-wrap">{{ publicacion.publicacion }}</p>
                        <button class="ml-2 mt-1 mb-auto text-blue hover:underline text-sm" @click="editar(publicacion)">Editar</button>
                    </div>
                    <div class="text-grey-dark leading-normal text-sm">
                        <p>
                            {{ publicacion.user.name }} <span class="mx-1 text-xs">&bull;</span> 
                            {{ publicacion.created_at }} <span class="mx-1 text-xs">&bull;</span>
                        <inertia-link 
                            class="hover:underline" 
                            :href="route('muro-respuestas.index', [institucion_id, division.id, publicacion.id])">
                            Resupuestas
                        </inertia-link>
                        <span class="mx-1 text-xs">&bull;</span>
                        <inertia-link 
                            class="hover:underline" 
                            :href="route('muro-archivos.index', [institucion_id, division.id, publicacion.id])">
                            Archivos
                        </inertia-link>
                        </p>
                    </div>
                </div>

                 <pagination :links="publicaciones.links" />
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
            successMessage: String,
            institucion_id: String,
            division: Object,
            publicaciones: Object,
        },

        data() {
            return {
                form: {
                    publicacion: null,
                },
                updateForm: {
                    id: null,
                    publicacion: null,
                },
                state: 'default',
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('muro.store', [this.institucion_id, this.division.id]), this.form)
            },

            editar(publicacion) {
                this.state = 'editing';
                this.updateForm.id = publicacion.id;
                this.updateForm.publicacion = publicacion.publicacion;
            },

            updatePublicacion() {
                this.cancelarEdicion();
                var muro_id = this.updateForm.id;
                this.$inertia.put(this.route('muro.update', [this.institucion_id, this.division.id, muro_id]), this.updateForm)
            },

            cancelarEdicion() {
                this.state = 'default';
            },

            destroyPublicacion(publicacion_id) {
                if (confirm('Estas seguro de que desea eliminar esta publicacion?')) {
                    this.cancelarEdicion();
                    this.$inertia.delete(this.route('muro.destroy', [this.institucion_id, this.division.id, publicacion_id]))
                }
            },
        },
    }
</script>
