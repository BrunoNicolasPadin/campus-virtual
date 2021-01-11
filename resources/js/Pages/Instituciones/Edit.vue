<template>
    <app-layout>
        <template #header>
            <h2 class="text-xl text-gray-800 leading-tight">
                <inertia-link :href="route('instituciones.show', institucion.id)">{{ institucion.user.name }}</inertia-link>
                 > 
                Editar institución
            </h2>
        </template>

        <div class="py-12">

            <!-- Errors Messages -->

            <div v-if="Object.keys(errors).length > 0" class="bg-red-200 px-6 py-4 mx-2 my-4 rounded-md text-lg flex items-center container mx-auto w-full">
                <svg viewBox="0 0 24 24" class="text-red-600 w-5 h-5 sm:w-5 sm:h-5 mr-3">
                    <path fill="currentColor" d="M11.983,0a12.206,12.206,0,0,0-8.51,3.653A11.8,11.8,0,0,0,0,12.207,11.779,11.779,0,0,0,11.8,24h.214A12.111,12.111,0,0,0,24,11.791h0A11.766,11.766,0,0,0,11.983,0ZM10.5,16.542a1.476,1.476,0,0,1,1.449-1.53h.027a1.527,1.527,0,0,1,1.523,1.47,1.475,1.475,0,0,1-1.449,1.53h-.027A1.529,1.529,0,0,1,10.5,16.542ZM11,12.5v-6a1,1,0,0,1,2,0v6a1,1,0,1,1-2,0Z"
                    ></path>
                </svg>
                <span class="text-red-800"> {{ errors[Object.keys(errors)[0]][0] }} </span>
            </div>

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Numero
                                    </template>
                                </label-form>
                                
                                <input-form type="text" v-model="form.numero" />
                                
                                <info>
                                    <template #info>
                                        No es obligatorio
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Fundación
                                    </template>
                                </label-form>
                                
                                <input-form type="text" v-model="form.fundacion" />
                                
                                <info>
                                    <template #info>
                                        No es obligatorio
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3">
                                <label-form>
                                    <template #label-value>
                                        Historia
                                    </template>
                                </label-form>
                                
                                <textarea
                                    class="appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                    cols="30" 
                                    rows="5" v-model="form.historia"></textarea>
                                
                                <info>
                                    <template #info>
                                        No es obligatorio
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Plan de estudio
                                    </template>
                                </label-form>
                                
                                <file-input v-model="form.planDeEstudio" type="file" />
                                
                                <info>
                                    <template #info>
                                        No es obligatorio. Solo puede subir uno.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <guardar></guardar>

                    </form>
                </template>
            </estructura-form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EstructuraForm from '@/Formulario/EstructuraForm.vue'
    import LabelForm from '@/Formulario/LabelForm.vue'
    import InputForm from '@/Formulario/InputForm.vue'
    import Info from '@/Formulario/Info.vue'
    import Guardar from '@/Botones/Guardar.vue'
    import FileInput from '@/Formulario/FileInput.vue'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            FileInput,
       },

        props: {
            errors: Object,
            successMessage: String,
            institucion: Object,
        },

        data() {
            return {
                form: {
                    numero: this.institucion.numero,
                    fundacion: this.institucion.fundacion,
                    historia: this.institucion.historia,
                    planDeEstudio: null,
                },
            }
        },

        methods: {
            submit() {
                var data = new FormData();
                data.append('numero', this.form.numero);
                data.append('fundacion', this.form.fundacion);
                data.append('historia', this.form.historia);
                data.append('archivo', this.form.planDeEstudio);
                data.append('_method', 'put');

                this.$inertia.post(this.route('instituciones.update', this.institucion.id), data)
            },
        },
    }
</script>
