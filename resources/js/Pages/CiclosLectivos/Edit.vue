<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('ciclos-lectivos.index', institucion_id)">Ciclos lectivos</inertia-link> / 
                Editar ciclo lectivo
            </span>
        </template>

        <div class="py-6">

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

            <estructura-form>
                <template #formulario>
                    <form method="post" @submit.prevent="submit">
                        
                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                
                                <label-form>
                                    <template #label-value>
                                        Comienzo
                                    </template>
                                </label-form>
                                
                                <date-picker
                                required
                                valueType="format"
                                format="DD-MM-YYYY"
                                v-model="form.comienzo"
                                class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3"></date-picker>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/2 px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Final
                                    </template>
                                </label-form>
                                
                                <date-picker
                                required
                                valueType="format"
                                format="DD-MM-YYYY"
                                v-model="form.final"
                                class="appearance-none block w-full bg-white text-black border border-red rounded py-3 px-4 mb-3"></date-picker>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6">
                            <div class="md:w-full px-3">
                                
                                <label-form>
                                    <template #label-value>
                                        Activado
                                    </template>
                                </label-form>
                                
                                <input type="checkbox" v-model="form.activado" />
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
    import DatePicker from 'vue2-datepicker'
    import 'vue2-datepicker/index.css'
    import 'vue2-datepicker/locale/es'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            DatePicker,
        },

        props: {
            errors: Object,
            institucion_id: String,
            cicloLectivo: Object,
        },

        title: 'Editar ciclo lectivo',

        data() {
            return {
                form: {
                    comienzo: this.cicloLectivo.comienzo,
                    final: this.cicloLectivo.final,
                    activado: this.cicloLectivo.activado,
                },
                mostrarErrores: true,
            }
        },

        methods: {
            submit() {
                this.$inertia.put(this.route('ciclos-lectivos.update', [this.institucion_id, this.cicloLectivo.id]), this.form)
            },

            cerrarAlerta() {
                this.mostrarErrores = false;
            },
        },
    }
</script>
