<template>
    <app-layout>
        <template #header>
            <span class="font-semibold text-md text-gray-800 leading-tight">
                <inertia-link class="hover:underline" :href="route('divisiones.index', institucion_id)">Estructura</inertia-link> /
                <inertia-link class="hover:underline" :href="route('divisiones.show', [institucion_id, division.id])">
                    <span v-if="division.orientacion">{{ division.nivel.nombre }} - {{ division.orientacion.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                    <span v-else>{{ division.nivel.nombre }} - {{ division.curso.nombre }} - {{ division.division }}</span>
                </inertia-link> / 
                <inertia-link class="hover:underline" :href="route('asignaturas.index', [institucion_id, division.id])">Asignaturas</inertia-link> /
                Agregar horarios en {{ asignatura.nombre }}
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
                        
                        <div v-for="(horario, index) in form.diaHorario" :key="horario.index" class="-mx-3 md:flex mb-6">
                            <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                                <label-form>
                                    <template #label-value>
                                        Día
                                    </template>
                                </label-form>
                                
                                <select
                                class="form-select appearance-none block w-full bg-grey-lighter text-black border border-red rounded py-3 px-4 mb-3"
                                required
                                v-model="horario.dia">
                                    
                                    <option value="" disabled selected>-</option>
                                    <option v-for="dia in dias" :key="dia.id" :value="dia">{{ dia }}</option>

                                </select>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/4 px-3 text-center">
                                
                                <label-form>
                                    <template #label-value>
                                        Hora desde
                                    </template>
                                </label-form>
                                
                                <vue-timepicker v-model="horario.horaDesde"></vue-timepicker>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio.
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/4 px-3 text-center">
                                
                                <label-form>
                                    <template #label-value>
                                        Hora hasta
                                    </template>
                                </label-form>
                                
                                <vue-timepicker v-model="horario.horaHasta"></vue-timepicker>
                                
                                <info>
                                    <template #info>
                                        Es obligatorio. 
                                    </template>
                                </info>
                            </div>

                            <div class="md:w-1/4 px-3 text-center">
                                <button 
                                @click="eliminarOtroDiaHora(index)"
                                type="button" 
                                class="border border-red-500 bg-red-500 text-white rounded-full px-4 py-2 my-8 transition duration-500 ease select-none hover:bg-red-700 focus:outline-none focus:shadow-outline">
                                    Eliminar día y horas
                                </button>
                            </div>
                        </div>

                        <div class="-mx-3 md:flex mb-6 text-left">
                            <div class="md:w-full px-3 mb-6 md:mb-0">
                                <button 
                                @click="agregarOtroDiaHora()"
                                type="button" 
                                class="border border-gray-500 bg-gray-500 text-white rounded-full px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-700 focus:outline-none focus:shadow-outline">
                                    Agregar otro día y hora
                                </button>
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
    import VueTimepicker from 'vue2-timepicker'
    import 'vue2-timepicker/dist/VueTimepicker.css'

    export default {
        components: {
            AppLayout,
            EstructuraForm,
            LabelForm,
            InputForm,
            Info,
            Guardar,
            VueTimepicker,
        },

        props: {
            errors: Object,
            institucion_id: String,
            division: Object,
            dias: Array,
            asignatura: Object,
        },

        title: 'Agregar horario',

        data() {
            return {
                form: {
                    diaHorario: [{
                        dia: null,
                        horaDesde: null,
                        horaHasta: null,
                    }],
                },
                mostrarErrores: true,
            }
        },

        methods: {
            submit() {
                this.$inertia.post(this.route('asignaturas-horarios.store', [this.institucion_id, this.division.id, this.asignatura.id]), this.form)
            },

            agregarOtroDiaHora() {
                this.form.diaHorario.push({
                    dia: null,
                    horaDesde: null,
                    horaHasta: null,
                });
            },

            eliminarOtroDiaHora(index) {
                this.form.diaHorario.splice(index, 1);
            },

            cerrarAlerta() {
                this.mostrarErrores = false;
            },
        },
    }
</script>
