<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                Anotate como padre
            </span>
        </template>

        <div class="py-6">

            <!-- Errors Messages -->

            <transition name="fade">
                <div v-if="error">
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

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Seleccionar hijo
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="form.alumno_id">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="alumno in alumnos" :key="alumno.id" :value="alumno.id">
                                            {{ alumno.name }}
                                    </option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio. Apriete en "Guardar" si quiere agregar otro hijo/a.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <guardar></guardar>

                        <button type="button" class="border border-yellow-200 bg-yellow-200 text-black rounded-full px-4 py-2 transition duration-500 ease select-none hover:bg-yellow-400 focus:outline-none focus:shadow-outline">
                            <inertia-link :href="route('roles.mostrarCuentas')">Finalizar registro</inertia-link>
                        </button>

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

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
        },

        props: {
            errors: Object,
            successMessage: String,
            institucion_id: String,
            alumnos: Array,
        },

        title: 'Registrarte como padre',

        data() {
            return {
                form: {
                    alumno_id: null,
                },
                mostrarErrores: true,
            }
        },

        methods: {

            submit() {
                this.$inertia.post(this.route('padres.store', this.institucion_id), this.form)
            },

            cerrarAlerta() {
                this.successMessage = false;
                this.mostrarErrores = false;
            }
        },
    }
</script>
