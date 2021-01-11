<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear institución
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

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Clave de acceso
                                    </template>
                                </label-form>
                                
                                <input-form required type="password" v-model="form.claveDeAcceso" />
                                
                                <info>
                                    <template #info>
                                        Es obligatorio y debe tener entre 8 y 32 caracteres. Es la clave que deberan ingresar los alumnos, docentes, padres y directivos para poder anotarse en tu instituto.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Confirmar clave de acceso
                                    </template>
                                </label-form>
                                
                                <input-form required type="password" v-model="form.claveDeAcceso_confirmation" />
                                
                                <info>
                                    <template #info>
                                        Vuelva a ingresar la clave de acceso.
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

        props: ['errors'],

        data() {
            return {
                form: {
                    numero: null,
                    fundacion: null,
                    historia: null,
                    planDeEstudio: null,
                    claveDeAcceso: null,
                    claveDeAcceso_confirmation: null,
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
                data.append('claveDeAcceso', this.form.claveDeAcceso);
                data.append('claveDeAcceso_confirmation', this.form.claveDeAcceso_confirmation);
                this.$inertia.post(this.route('instituciones.store'), data)
            },
        },
    }
</script>
